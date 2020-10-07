<?php


namespace app\libraries\logic;


use app\libraries\CommonTrait;
use app\model\Employee;
use app\model\Permission;
use app\model\Punch;
use app\model\StoreAuth;
use function date;
use function strtotime;

/**
 * Class admin
 * @package app\libraries\logic
 */
class Admin extends LogicBase
{
    use CommonTrait;

    //時
    const HOURS = 3600;
    //分
    const MINUTES = 60;
    //切り上げ時間
    const ROUNDED_UP_TIME = 30;
    //view表示用デートフォーマット
    const VIEW_DATE_FORMAT = 'Y-m-d\TH:i';
    //table登録時のデートフォーマット
    const REGIST_DATE_FORMAT = 'Y-m-d H:i';

    /**
     * 勤怠テーブル内の最大年を取得
     * @param $columnName
     * @return false|string
     */
    public function getMaxYear($columnName)
    {
        //最大年の取得
        $punchModel = new Punch();
        $maxDate = $punchModel->execMaxSelect($columnName);
        return date('Y', strtotime($maxDate[$columnName]));
    }

    /**
     * 勤怠テーブル内の最小年を取得
     * @param $columnName
     * @return false|string
     */
    public function getMinYear($columnName)
    {
        //最小年の取得
        $punchModel = new Punch();
        $minDate = $punchModel->execMinSelect($columnName);
        return date('Y', strtotime($minDate[$columnName]));
    }

    /**
     * 勤務日数データ作成
     * @param $attendData
     * @return array
     */
    public function makeWorkingDayData($attendData)
    {
        //勤務日数データ格納用List
        $workingDayList = [];
        foreach ($attendData as $value) {
            if (isset($workingDayList[$value['emp_id']])) {
                $workingDayList[$value['emp_id']] += 1;
            } else {
                $workingDayList[$value['emp_id']] = 1;
            }
        }
        return $workingDayList;
    }

    /**
     * 勤務データ作成
     * @param $firstDate
     * @param $lastDate
     * @return array
     */
    public function makeWorkingData($firstDate, $lastDate)
    {

        //今月分の勤務データの取得
        $attendData = $this->getWorkingDataByDate($firstDate, $lastDate);
        //勤務日数データの作成
        $workingDayList = $this->makeWorkingDayData($attendData);
        //総勤務時間を秒で取得
        $secondTimeList = $this->calcTotalSecond($attendData);
        //勤務時間を時分に変換
        $workingHoursList = $this->convertSecondToTime($secondTimeList);
        //勤務時間切り上げ処理
        $roundedUpList = $this->roundedUpTime($workingHoursList);
        //時分に分かれているデータを結合する
        $workingTimeDataList = $this->convertTime($roundedUpList);
        //勤務時間listと勤務日数listを結合する
        $workDataList = $this->joinWorkTimeDataAndWorkDayData($workingDayList, $workingTimeDataList);
        //employeeクラスインスタンス生成
        $employee = new Employee();
        //employeeテーブルデータ全取得
        $empDataList = $employee->execAllSelect();
        //社員マスタデータと勤務時間データを結合する
        return $this->joinEmpAndWorkingHourData($workDataList, $empDataList);
    }

    /**
     * 勤務時間listと勤務日数listを結合する
     * @param $workingDayList
     * @param $workingTimeDataList
     * @return array
     */
    public function joinWorkTimeDataAndWorkDayData($workingDayList, $workingTimeDataList)
    {
        //結果格納用list
        $workDataList = [];
        foreach ($workingDayList as $empId => $workingDay) {
            //勤務時間と勤務日数を格納
            $workDataList[$empId] = array("workingTime" => $workingTimeDataList[$empId], "workingDay" => $workingDay);
        }
        return $workDataList;
    }

    /**
     * 今月分の勤務時間データを取得
     * @param $firstDate
     * @param $lastDate
     * @return array|mixed
     */
    public function getWorkingDataByDate($firstDate, $lastDate)
    {//Modelの読み込み
        $punchModel = new Punch();

        $searchList = [
            'firstDate' => $firstDate,
            'lastDate' => $lastDate,
            'punch_state' => '2',
        ];
        $sql = $punchModel->makeSqlGetByPunchInAndPunchState($searchList);

        //勤怠データ
        $attendData = [];
        //今月分出勤データ
        if (!empty($sql)) {
            $attendData = $punchModel->execSelect($sql);
        }
        return $attendData;
    }

    /**
     * 時間を表示用に変換する
     * @param array $roundedUpList
     * @return array
     */
    public function convertTime(array $roundedUpList):array
    {
        //結果格納用list
        $resultList = [];
        //時分を結合
        foreach ($roundedUpList as $key => $value) {
            $resultList[$key] = $value["hour"] . ":" . $value["minutes"];
        }
        return $resultList;
    }

    /**
     * 社員マスタと勤務時間データの結合
     * @param array $workDataList
     * @param array $empDataList
     * @return array
     */
    public function joinEmpAndWorkingHourData(array $workDataList,array $empDataList):array
    {
        //結果格納用list
        $resultList = [];
        //社員マスタ
        $empMap = array_column($empDataList, null, 'emp_id');
        //勤務時間データ
        foreach ($workDataList as $empId => $workData) {
            //社員マスタに勤務時間listのkeyデータが存在する場合
            if (isset($empMap[$empId])) {
                $resultData = $empMap[$empId];
                $resultData['workingTime'] = $workData['workingTime'];
                $resultData['workingDay'] = $workData['workingDay'];
                $resultList[] = $resultData;
            }
        }
        return $resultList;
    }

    /**
     * 勤務時間切り上げ処理
     * @param array $WorkingHoursList
     * @return array
     */
    public function roundedUpTime(array $WorkingHoursList):array
    {
        foreach ($WorkingHoursList as $empId => $WorkingHours) {
            $WorkingHoursList[$empId]['minutes'] = ceil($WorkingHours['minutes'] / self::ROUNDED_UP_TIME) * self::ROUNDED_UP_TIME;
        }
        return $WorkingHoursList;
    }

    /**
     * 総勤務時間計算
     * @param array $attendData
     * @return array
     */
    public function calcTotalSecond(array $attendData):array
    {

        $resultList = [];
        foreach ($attendData as $attend) {
            //出勤時刻
            $inTime = date("H:i", strtotime($attend['punch_in']));
            //退勤時刻
            $outTime = date("H:i", strtotime($attend['punch_out']));

            if (!empty($resultList[$attend['emp_id']])) {
                //時間計算した結果を格納する
                $resultList[$attend['emp_id']] += strtotime($outTime) - strtotime($inTime);
            } else {
                $resultList[$attend['emp_id']] = strtotime($outTime) - strtotime($inTime);
            }
        }
        return $resultList;
    }

    /**
     * 秒で算出した勤務時間を時分に変換する
     * @param array $secondList
     * @return array
     */
    public function convertSecondToTime(array $secondList):array
    {
        //時分へ変換　別メソッドへ
        foreach ($secondList as $key => $value) {
            //時
            $hours = floor($value / self::HOURS);
            //分
            $minutes = floor(($value / self::MINUTES) % self::MINUTES);

            $secondList[$key] = array("hour" => $hours, "minutes" => $minutes);
        }
        return $secondList;
    }

    /**
     * 削除するデータを作成 　deleteフラグを1へ、delete_atに現在日付を入れる。
     * @param Punch $punchModel
     * @param int $id
     * @return string
     */
    public function makeDeleteData(Punch $punchModel, int $id):string
    {
        $delList = [
            'id' => $id,
            'del_state' => '1',
        ];
        //del_stateを更新するsqlの作成
        return $punchModel->makeSqlUpdateDelState($delList);
    }

    /**
     * 勤怠修正データの作成
     * @param Punch $punchModel
     * @param int $id
     * @param string $punchIn
     * @param string $punchOut
     * @param int $punchState
     * @param int $fixState
     * @return string
     */
    public function makeFixAttendanceData(
        Punch $punchModel,
        int $id, string $punchIn,
        string $punchOut,
        int $punchState,
        int $fixState
    ): string
    {
        //出勤日付のフォーマットを変更
        $inTime = date(self::REGIST_DATE_FORMAT, strtotime($punchIn));
        //退勤日付のフォーマットを変更
        $outTime = date(self::REGIST_DATE_FORMAT, strtotime($punchOut));

        $updateList = [
            'id' => $id,
            'punch_in' => $inTime,
            'punch_out' => $outTime,
            'punch_state' => $punchState,
            'fix_state' => $fixState,
        ];
        return $punchModel->makeSqlUpdateByFixStateAndPunch($updateList);
    }

    /**
     * 登録データの作成
     * @param Employee $employeeModel
     * @param string $empName
     * @param string $birthDay
     * @return string
     */
    public function makeRegisterData(Employee $employeeModel, string $empName, string $birthDay):string
    {
        $insertList = [
            'name' => $empName,
            'birthday' => $birthDay,
        ];
        return $employeeModel->makeSqlInsertByEmployeeTable($insertList);
    }

    /**
     * 勤怠管理画面に表示するデータの作成
     * @return array
     */
    public function makeAttendManagerData():array
    {
        //Modelの読み込み
        $employee = new Employee();
        $punch = new Punch();

        $searchList = [
            'punch_state' => '1',
            'del_state' => '0',
            'limit' => 50,
        ];

        //勤怠テーブルのpunch_stateが1かつdel_stateが1以外のデータをemp_id順で取得(50件で取得)するsqlの作成
        $limitSql = $punch->makeSqlGetByPunchStateAndDelStateANDLimit($searchList);
        //作成したsqlでデータの取得
        $punchList = $punch->execSelect($limitSql);
        //社員マスタからは全データを取得する
        $empList = $employee->execAllSelect();
        //社員データと勤怠データの結合
        $joinData = $this->joinEmpAndPunchTable($empList, $punchList);
        return $this->convertDateFormat($joinData);
    }

    /**
     * テーブル結合
     * @param array $empList
     * @param array $punchList
     * @return array
     */
    public function joinEmpAndPunchTable(array $empList, array $punchList): array
    {
        //社員mapの作成 対象list,null,key項目
        $empMap = array_column($empList, null, 'emp_id');
        //結果格納用
        $resultList = [];
        //勤怠データでループ
        foreach ($punchList as $punch) {
            //社員ID
            $empId = $punch['emp_id'];
            //社員mapに勤怠テーブルのempIdが存在するかチェック
            if (isset($empMap[$empId])) {
                $resultData = $punch;
                $resultData['name'] = $empMap[$empId]['name'];
                $resultList[] = $resultData;
            }
        }
        return $resultList;
    }

    /**
     * 日付を日と時間に分割する
     * @param array $punchList
     * @return array
     */
    public function convertDateFormat(array $punchList): array
    {
        $resultList = [];
        foreach ($punchList as $punch) {
            $resultData = $punch;
            //退勤時刻がnullだったら
            if (is_null($punch['punch_out'])) {
                $resultData['punch_out'] = "\"\"";
            } else {
                $resultData['punch_out'] = date(self::VIEW_DATE_FORMAT, strtotime($punch['punch_out']));
            }
            //出勤時刻がnullだったら
            if (is_null($punch['punch_in'])) {
                $resultData['punch_in'] = "\"\"";
            } else {
                $resultData['punch_in'] = date(self::VIEW_DATE_FORMAT, strtotime($punch['punch_in']));
            }
            $resultList[] = $resultData;
        }
        return $resultList;
    }

    /**
     * del_stateが0の社員を取得する
     * @param int $delState
     * @return array
     */
    public function makeDeleteStateData(int $delState): array
    {

        //modelの読み込み
        $employee = new Employee();
        $searchList = [
            'del_state' => $delState,
        ];
        $sql = $employee->makeSqlGetByDelState($searchList);
        //削除ステータスに対応したデータの取得
        $empList = $employee->execSelect($sql);
        return $empList;
    }

    /**
     * 削除ステータス更新データの作成
     * @param int $empId
     * @param int $delState
     * @param Employee $employee
     * @return string
     */
    public function makeDeleteStateUpdateData(int $empId, int $delState, Employee $employee): string
    {

        $keyList = [
            'emp_id' => $empId,
        ];
        //更新対象データの取得
        $sql = $employee->makeSqlSelect($keyList);
        $updateDataList = $employee->execRowSelect($sql);
        //$updateListを初期化
        //削除時
        if ($delState == $employee::DEL_STATE_ON) {
            $updateList = [
                'emp_id' => $updateDataList['emp_id'],
                'del_state' => $delState,
                'delete_time' => date(self::REGIST_DATE_FORMAT),
            ];
        } else {
            $updateList = [
                'emp_id' => $updateDataList['emp_id'],
                'del_state' => $delState,
                'delete_time' => NULL,
            ];
        }

        $sql = $employee->makeSqlUpdateDelState($updateList);

        return $sql;
    }

    /**
     * ユーザー、パスワードの認証データの取得
     * @param string $name
     * @param string $password
     * @param Permission $permission
     * @return array
     */
    public function makeAuthUserData(string $name, string $password, Permission $permission): array
    {
        $searchList = [
            'name' => $name,
            'password' => $password,
        ];
        //ユーザー名、パスワード確認用sqlの作成
        $sql = $permission->makeSqlSelect($searchList);
        $authDataList = $permission->execRowSelect($sql);

        return $authDataList;
    }
}
