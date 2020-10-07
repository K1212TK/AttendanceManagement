<?php


namespace app\libraries\logic;

use app\libraries\CommonTrait;
use app\model\Punch;

/**
 * Class attend
 * @package app\libraries\logic
 */
class Attend extends LogicBase
{
    use CommonTrait;
    //営業終了時間
    const END_DATE_TIME = '-6 hours';
    const SEARCH_DATE_FORMAT = 'Y-m-d';
    const TIME_STAMP_FORMAT = 'Y-m-d H:i:s';
    const START_TIME = '00:00:00';
    const END_TIME = '23:59:59';

    /**
     * テーブル配列取得後結合
     * @param array $empMasterList
     * @param array $attendList
     * @return array
     */
    public function joinTableArrayByEmpMasterAndAttend(array $empMasterList, array $attendList): array
    {
        //勤怠mapの作成 対象list,null,key項目
        $attendMap = array_column($attendList, null, 'emp_id');
        //格納用list
        $resultList = [];
        //社員テーブルでforeach
        foreach ($empMasterList as $emp) {
            $empId = $emp['emp_id'];
            //勤怠データに社員マスタの社員IDが存在するか
            if (isset($attendMap[$empId])) {
                //連想配列
                $resultData = $emp;
                $resultData['punch_in'] = date("H:i", strtotime($attendMap[$empId]['punch_in']));
                if (is_null($attendMap[$empId]['punch_out'])) {
                    $resultData['punch_out'] = "\"\"";
                } else {
                    $resultData['punch_out'] = date("H:i", strtotime($attendMap[$empId]['punch_out']));
                }

                $resultData['punch_state'] = $attendMap[$empId]['punch_state'];
                $resultData['id'] = $attendMap[$empId]['id'];
                $resultList[] = $resultData;
            } else {
                $resultData = $emp;
                $resultData['punch_in'] = "\"\"";
                $resultData['punch_out'] = "\"\"";
                $resultData['punch_state'] = "";
                $resultData['id'] = "";
                $resultList[] = $resultData;
            }
        }
        return $resultList;
    }

    /**
     * attend/create パラメータ整合性チェック
     * 不整合だった場合 attend/indexにredirect
     * @param int|null $punchInState
     * @param int|null $punchOutState
     * @param string|null $punchInTime
     * @param string|null $punchOutTime
     */
    public function checkCreateInputData(
        ?int $punchInState,
        ?int $punchOutState,
        ?string $punchInTime,
        ?string $punchOutTime
    )
    {
        //出勤時刻が打刻されていない状態で退勤が押された場合
        if (empty($punchInTime) && !is_null($punchOutState)) {
            $this->redirectToAttendIndex();
            //出勤時刻が入っている状態で出勤が押された場合
        } else if (!empty($punchInTime) && !is_null($punchInState)) {
            $this->redirectToAttendIndex();
            //出勤時刻、退勤時刻が既に入力されていた場合
        } else if (!empty($punchInTime) && !empty($punchOutTime)) {
            $this->redirectToAttendIndex();
        }
    }

    /**
     * 出勤データsqlの作成
     * @param Punch $modelPunch
     * @param int $empId
     * @param string $nowTime
     * @param int $punchInState
     * @return string
     */
    public function makePunchInData(Punch $modelPunch, int $empId, string $nowTime, int $punchInState): string
    {

        $insertList = [
            'emp_id' => $empId,
            'punch_in' => $nowTime,
            'punch_state' => $punchInState,
        ];
        //sql作成処理の作成
        return $modelPunch->makeSqlInsertByPunchIn($insertList);
    }

    /**
     * 退勤データ作成
     * @param Punch $modelPunch
     * @param string $nowTime
     * @param int $punchOutState
     * @param int $id
     * @return string
     */
    public function makePunchOutData(Punch $modelPunch, string $nowTime, int $punchOutState, int $id): string
    {
        //更新対象データの取得
        $targetData = $this->makeUpdateData($id);
        $updateList = [
            'punch_out' => $nowTime,
            'punch_state' => $punchOutState,
            'id' => $targetData[0]['id'],
        ];
        //更新sqlの作成
        return $modelPunch->makeSqlUpdateByPunchOut($updateList);
    }

    /**
     * 取得するデータの出勤時刻の指定
     * @param int $del_state
     * @return array
     */
    public function makeTodayAttendList(int $del_state): array
    {
        //現在時間から6時間減算した結果の格納
        $dateTime = date(self::TIME_STAMP_FORMAT,strtotime(self::END_DATE_TIME));
        $date = date(self::SEARCH_DATE_FORMAT,  strtotime($dateTime));

        $searchList = [
            'start_punch_in' => $date.' '.self::START_TIME,
            'end_punch_in' => $date.' '.self::END_TIME,
            'del_state' => $del_state,
            ];
        return $searchList;
    }

    /**
     * 更新対象データのSELECT　
     * @param int $id
     * @return array
     */
    private function makeUpdateData(int $id): array
    {
        $modelPunch = new Punch();
        $searchList = [
            'id' => $id,
        ];
        //更新対象データ取得用sql
        $updateTargetSql = $modelPunch->makeSqlGetById($searchList);
        //更新データの取得
        $updateTargetList = $modelPunch->execSelect($updateTargetSql);
        return $updateTargetList;
    }

    /**
     * 社員データの作成
     * @param $modelEmployee
     * @param $delState
     * @return mixed
     */
    public function makeEmployeeData($modelEmployee, $delState)
    {

        $searchList = [
            'del_state' => $delState,
        ];

        $sql = $modelEmployee->makeSqlGetByDelState($searchList);

        return $modelEmployee->execSelect($sql);
    }

    /**
     * attend/indexにredirect
     */
    public function redirectToAttendIndex()
    {
        $this->redirect('attend', 'index');
    }
}