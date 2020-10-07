<?php

use app\libraries\CommonTrait;
use app\libraries\ImageManager;
use app\libraries\ModelManager;
use app\model\Employee;
use app\model\Permission;
use app\model\Punch;
use app\model\StoreAuth;

/**
 * Class admin
 */
class admin extends MY_Controller
{
    use CommonTrait;

    //年度開始日
    const START_DAY = '01/01';
    //年度終了日
    const END_DAY = '12/31';

    /**
     * ユーザー作成画面表示
     */
    public function create_user_open()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //画面表示用画像の取得
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通の読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('create_user_menu', $viewData);
        //footerの読み込み
        $this->footerLoad();
    }

    /**
     * 従業員管理画面を開く
     */
    public function select_user_open()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //画面表示用画像の取得
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通の読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('SelectUserMenu', $viewData);
        //footerの読み込み
        $this->footerLoad();
    }

    /**
     * 従業員削除画面を開く
     */
    public function delete_user_open()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //logicの読み込み
        $logicAdmin = new \app\libraries\logic\Admin();
        //取得するデータの削除フラグ
        $delState = 0;
        //削除されていない従業員一覧の取得
        $viewData['employee'] = $logicAdmin->makeDeleteStateData($delState);
        //画面表示用画像の取得
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通の読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('DeleteUserMenu', $viewData);
        //footerの読み込み
        $this->footerLoad();
    }

    /**
     * 勤怠管理画面表示
     */
    public function attend_manager_open()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //logicの読み込み
        $logicAdmin = new \app\libraries\logic\Admin();
        $viewData['result'] = $logicAdmin->makeAttendManagerData();
        //画面表示用画像の取得
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通の読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('attend_manager_menu', $viewData);
        //footerの読み込み
        $this->footerLoad();
    }

    /**
     * 年間勤怠データの検索 取得した年の1月から12月のデータを検索
     */
    public function year_search()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //logicの読み込み
        $logicAdmin = new \app\libraries\logic\Admin();
        //選択した年度の取得
        $year = $this->input->post('year');
        //開始年
        $startYear = $year . '/' . self::START_DAY;
        //終了年
        $endYear = $year . '/' . self::END_DAY;
        $viewData['result'] = $logicAdmin->makeWorkingData($startYear, $endYear);
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('attend_confirmation', $viewData);
        //footerの読み込み
        $this->footerLoad();
    }

    /**
     * 勤怠時間確認画面表示
     */
    public function attend_confirmation_open()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //logicの読み込み
        $logicAdmin = new \app\libraries\logic\Admin();
        //今月初日の取得
        $firstDate = $this->firstMonth();
        // 今月末日の取得
        $lastDate = $this->lastMonth();
        //勤務時間データの作成
        $viewData['result'] = $logicAdmin->makeWorkingData($firstDate, $lastDate);
        //MAX日付の取得
        $viewData['endYear'] = $logicAdmin->getMaxYear('punch_in');
        //MIN日付の取得
        $viewData['startYear'] = $logicAdmin->getMinYear('punch_in');
        //画面表示用画像の取得
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('attend_confirmation', $viewData);
        //footerの読み込み
        $this->footerLoad();
    }

    /**
     * 勤怠データ編集
     */
    public function fix_attend()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //id
        $id = $this->input->post('id');
        //出勤時間
        $punchIn = $this->input->post('punch_in');
        //退勤時間
        $punchOut = $this->input->post('punch_out');
        //入力ボタン ステータス
        $buttonState = $this->input->post('commit');
        //Modelの読み込み
        $punchModel = new Punch();
        //シングルトンインスタンス取得
        $modelManager = ModelManager::getInstance();
        //logicの読み込み
        $logicAdmin = new \app\libraries\logic\Admin();

        //変更時処理
        if (!is_null($buttonState)) {
            //勤怠更新sql
            $updateSql = $logicAdmin->makeFixAttendanceData($punchModel, $id, $punchIn, $punchOut, $punchModel::PUNCH_STATE_OUT, $punchModel::FIX_STATE_DONE);
            $modelManager->sqlStorage($updateSql, $punchModel::DB_NAME);
        } else {
            //削除時処理
            $delSql = $logicAdmin->makeDeleteData($punchModel, $id);
            $modelManager->sqlStorage($delSql, $punchModel::DB_NAME);
        }
        //sqlの実行
        $modelManager->execStorage();
    }

    /**
     * 社員を削除する
     */
    public function deleteEmp()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //社員ID
        $empId = $this->input->post('emp_id');
        //logicの読み込み
        $logicAdmin = new \app\libraries\logic\Admin();
        //model読み込み
        $employee = new Employee();
        //変更するdel_state
        $delState = 1;
        //社員削除データの作成
        $updateSql = $logicAdmin->makeDeleteStateUpdateData($empId, $delState, $employee);
        //インスタンス取得
        $modelManager = ModelManager::getInstance();
        //update文をため込む
        $modelManager->sqlStorage($updateSql, $employee::DB_NAME);
        //update文実行
        $modelManager->execStorage();
    }

    /**
     * 再従業員登録画面を開く
     */
    public function return_user_open()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //logic読み込み
        $logicAdmin = new \app\libraries\logic\Admin();
        //取得するデータの削除フラグ
        $delState = 1;
        //削除されていない従業員一覧の取得
        $viewData['employee'] = $logicAdmin->makeDeleteStateData($delState);
        //画面表示用画像の取得
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通の読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('ReturnUserMenu', $viewData);
        //footerの読み込み
        $this->footerLoad();
    }

    /**
     * ユーザーの再登録
     */
    public function returnUser()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //社員ID
        $empId = $this->input->post('emp_id');
        //logicの読み込み
        $logicAdmin = new \app\libraries\logic\Admin();
        //modelの読み込み
        $employee = new Employee();
        //変更するdel_state
        $delState = 0;
        //社員削除データの作成
        $updateSql = $logicAdmin->makeDeleteStateUpdateData($empId, $delState, $employee);
        $modelManager = ModelManager::getInstance();
        //sqlをため込む
        $modelManager->sqlStorage($updateSql, $employee::DB_NAME);
        //sql実行
        $modelManager->execStorage();
    }

    /**
     * ログイン認証を行う
     */
    public function adminLoginAuth()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //logic読み込み
        $logicAdmin = new \app\libraries\logic\Admin();
        //model読み込み
        $permission = new Permission();
        //名前
        $name = $this->input->post('name');
        //パスワード
        $password = $this->input->post('password');
        //名前とパスワードが一致するデータの取得
        $authDataList = $logicAdmin->makeAuthUserData($name, $password, $permission);
        //ログイン成功時
        if (!empty($authDataList) && $authDataList['store_id'] == $_SESSION['store_id']) {
            //セッションにログイン情報の追加
            $this->session->set_userdata($authDataList);
            $logicAdmin->redirect('Attend', 'index');
        } else {
            //失敗した場合ログイン画面に戻す
            $logicAdmin->redirect('Admin','adminLoginOpen');
        }
    }

    /**
     * ログアウト処理
     */
    public function logout(){
        //削除するsessionのkey
        $sessionKeyList = [
            'name',
            'password',
        ];
        $this->cleanSession($sessionKeyList);

        $this->redirect('Attend','index');
    }

    //ユーザーデータ登録
    public function regist_user()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //Modelの読み込み
        $employeeModel = new Employee();
        //logicの読み込み
        $logicAdmin = new \app\libraries\logic\Admin();
        //ユーザー名
        $empName = $this->input->post('emp_name');
        //誕生日
        $birthDay = $this->input->post('birthday');
        //登録sqlの作成
        $sql = $logicAdmin->makeRegisterData($employeeModel,$empName, $birthDay);
        $modelManager = ModelManager::getInstance();
        //sqlをため込む
        $modelManager->sqlStorage($sql,$employeeModel::DB_NAME);
        //インサート実行
        $modelManager->execStorage();
    }

    /**
     * 管理者ログイン画面を開く
     */
    public function adminLoginOpen(){
        //セッションの確認
        $this->checkSessionStoreId();
        //画面表示用画像の取得
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通の読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('AdminLoginMenu', $viewData);
        //footerの読み込み
        $this->footerLoad();
    }
}
