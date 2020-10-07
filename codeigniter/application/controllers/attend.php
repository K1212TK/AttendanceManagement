<?php

use app\libraries\CommonTrait;
use app\libraries\ImageManager;
use app\libraries\ModelManager;
use app\model\Employee;
use app\model\Punch;

/**
 * 勤怠管理クラス
 * Class attend
 */
class attend extends MY_Controller
{
    use CommonTrait;


    /**
     * 勤怠データ作成
     */
    public function create()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //Modelの読み込み
        $modelPunch = new Punch();
        //現在日付　
        $nowTime = $this->nowTime();
        //社員ID　
        $empId = $this->input->post('emp_id');
        //出勤ステータス
        $punchInState = $this->input->post('punch_in');
        //退勤ステータス
        $punchOutState = $this->input->post('punch_out');
        //出勤時刻
        $punchInTime = $this->input->post('punch_in_time');
        //退勤時刻
        $punchOutTime = $this->input->post('punch_out_time');
        //データID
        $id = $this->input->post('id');
        //logic 読み込み
        $logicAttend = new app\libraries\logic\Attend();
        //postデータが不正でないかのチェック
        $logicAttend->checkCreateInputData($punchInState, $punchOutState, $punchInTime, $punchOutTime);
        //シングルトン呼び出し
        $modelManager = ModelManager::getInstance();

        //出勤
        if (!is_null($punchInState)) {
            $punchInSql = $logicAttend->makePunchInData($modelPunch, $empId, $nowTime, $punchInState);
            //実行するsqlをため込む
            $modelManager->sqlStorage($punchInSql, $modelPunch::DB_NAME);
            //退勤
        } else {
            $punchOutSql = $logicAttend->makePunchOutData($modelPunch, $nowTime, $punchOutState, $id);
            //実行するsqlをため込む
            $modelManager->sqlStorage($punchOutSql, $modelPunch::DB_NAME);
        }
        //sqlの実行
        $modelManager->execStorage();
        //勤怠画面へリダイレクトする
        $logicAttend->redirectToAttendIndex();
    }

    public function index()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //Modelの読み込み
        $modelEmployee = new Employee();
        $modelPunch = new Punch();
        //Logicの読み込み
        $logicAttend = new app\libraries\logic\Attend();
        //社員マスタデータ取得
        $employeeList = $logicAttend->makeEmployeeData($modelEmployee, $modelPunch::DEL_STATE_OFF);
        //取得条件となる日付listの作成
        $searchList = $logicAttend->makeTodayAttendList($modelPunch::DEL_STATE_OFF);
        //日時条件付きで勤怠データ取得するsqlの作成
        $searchSql = $modelPunch->makeSqlGetByPunchIn($searchList);
        //sqlの実行　結果の取得
        $punchList = $modelPunch->execSelect($searchSql);
        //社員マスタデータと勤怠データを結合(left join)
        $viewData['result'] = $logicAttend->joinTableArrayByEmpMasterAndAttend($employeeList, $punchList);
        //画面表示用画像の取得
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('attend/index',$viewData);
        //footerの読み込み
        $this->footerLoad();
    }
}
