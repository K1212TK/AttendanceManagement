<?php


namespace app\libraries;

/**
 * Class ImageManager
 * @package app\libraries
 */
class ImageManager
{
    private static $imageManager;
    private $imageList;
    //画像格納先パス
    const IMAGE_PASS = 'img/';

    /**
     * ImageManager constructor.
     * viewに表示する画像データの表示
     */
    private function __construct()
    {
        $this->imageList = [
            'img_header' =>
                [
                    'src' => self::IMAGE_PASS.'header.png',
                    'alt' => 'ヘッダー',
                    'class' => 'head-logo'
                ],
            'img_attend_fix' =>
                [
                    'src' => self::IMAGE_PASS.'attend_fix.png',
                    'alt' => '勤怠修正',
                    'class' => 'head_image',
                    'width' => '57',
                ],
            'img_attend_check_time' =>
                [
                    'src' => self::IMAGE_PASS.'attend_time_check.png',
                    'alt' => '勤怠時間確認',
                    'class' => 'head_image',
                    'width' => '85',
                ],
            'img_between_search' =>
                [
                    'src' => self::IMAGE_PASS.'between_search.png',
                    'alt' => '期間検索',
                    'class' => 'image',
                    'width' => '80',
                ],
            'img_birthday' =>
                [
                    'src' => self::IMAGE_PASS.'birthday.png',
                    'alt' => '誕生日',
                    'class' => 'image',
                    'width' => '50',
                ],
            'img_check_time' =>
                [
                    'src' => self::IMAGE_PASS.'check_time.png',
                    'alt' => '勤務時間確認メニュー',
                    'class' => 'image',
                    'width' => '160',
                ],
            'img_create_emp' =>
                [
                    'src' => self::IMAGE_PASS.'create_emp.png',
                    'alt' => '新規従業員登録メニュー',
                    'class' => 'image'
                ],
            'img_delete' =>
                [
                    'src' => self::IMAGE_PASS.'delete.png',
                    'alt' => '削除',
                    'class' => 'image',
                    'width' => '34',
                ],
            'img_delete_button' =>
                [
                    'src' => self::IMAGE_PASS.'delete_button.png',
                    'alt' => '削除ボタン',
                    'class' => 'image',
                    'width' => '34',
                ],
            'img_emp_name' =>
                [
                    'src' => self::IMAGE_PASS.'emp_name.png',
                    'alt' => '名前',
                    'class' => 'image',
                    'width' => '34',
                ],
            'img_emp_no' =>
                [
                    'src' => self::IMAGE_PASS.'emp_no.png',
                    'alt' => '社員NO',
                    'class' => 'image',
                    'width' => '58',
                ],
            'img_emp_regist' =>
                [
                    'src' => self::IMAGE_PASS.'emp_regist.png',
                    'alt' => '従業員管理',
                    'class' => 'head_image',
                    'width' => '75',
                ],
            'img_finish_day' =>
                [
                    'src' => self::IMAGE_PASS.'finishday.png',
                    'alt' => '退勤日',
                    'class' => 'image',
                    'width' => '49',
                ],
            'img_fix_menu' =>
                [
                    'src' => self::IMAGE_PASS.'fix_logo.png',
                    'alt' => '勤怠修正',
                    'class' => 'image'
                ],
            'img_in' =>
                [
                    'src' => self::IMAGE_PASS.'in.png',
                    'alt' => '出勤',
                    'class' => 'image',
                    'width' => '34',
                ],
            'img_in_button' =>
                [
                    'src' => self::IMAGE_PASS.'in_button.png',
                    'alt' => '出勤',
                    'class' => 'image',
                    'width' => '35',
                ],
            'img_in_time' =>
                [
                    'src' => self::IMAGE_PASS.'in_time.png',
                    'alt' => '出勤時間',
                    'class' => 'image',
                    'width' => '65',
                ],
            'img_info' =>
                [
                    'src' => self::IMAGE_PASS.'info.png',
                    'alt' => 'お知らせ',
                    'class' => 'image',
                    'width' => '60',
                ],
            'img_input_attend' =>
                [
                    'src' => self::IMAGE_PASS.'logo.png',
                    'alt' => '勤怠入力',
                    'class' => 'image',
                ],
            'img_out' =>
                [
                    'src' => self::IMAGE_PASS.'out.png',
                    'alt' => '退勤',
                    'class' => 'image',
                    'width' => '34',
                ],
            'img_out_button' =>
                [
                    'src' => self::IMAGE_PASS.'out_button.png',
                    'alt' => '退勤ボタン',
                    'class' => 'image',
                    'width' => '35',
                ],
            'img_out_time' =>
                [
                    'src' => self::IMAGE_PASS.'out_time.png',
                    'alt' => '退勤時刻',
                    'class' => 'image',
                    'width' => '65',
                ],
            'img_reflection' =>
                [
                    'src' => self::IMAGE_PASS.'reflection.png',
                    'alt' => '反映',
                    'class' => 'image',
                    'width' => '34',
                ],
            'img_reflection_button' =>
                [
                    'src' => self::IMAGE_PASS.'reflection_button.png',
                    'alt' => '反映ボタン',
                    'class' => 'image',
                    'width' => '34',
                ],
            'img_regist' =>
                [
                    'src' => self::IMAGE_PASS.'regist.png',
                    'alt' => '反映ボタン',
                    'class' => 'image',
                    'width' => '50',
                ],
            'img_search' =>
                [
                    'src' => self::IMAGE_PASS.'search.png',
                    'alt' => '検索',
                    'class' => 'image',
                    'width' => '43',
                ],
            'img_shift' =>
                [
                    'src' => self::IMAGE_PASS.'shift.png',
                    'alt' => 'シフト管理',
                    'class' => 'image'
                ],
            'img_shift_menu' =>
                [
                    'src' => self::IMAGE_PASS.'shift_manager.png',
                    'alt' => 'シフト管理メニュー',
                    'class' => 'head_image',
                    'width' => '70',
                ],
            'img_start_day' =>
                [
                    'src' => self::IMAGE_PASS.'startday.png',
                    'alt' => '出勤日',
                    'class' => 'image',
                    'width' => '49',
                ],
            'img_total_attend_day' =>
                [
                    'src' => self::IMAGE_PASS.'total_attend_day.png',
                    'alt' => '総勤務日数',
                    'class' => 'image',
                    'width' => '80',
                ],
            'img_total_attend_time' =>
                [
                    'src' => self::IMAGE_PASS.'total_attend_time.png',
                    'alt' => '総勤務時間',
                    'class' => 'image',
                    'width' => '80',
                ],
            'img_del_emp' =>
                [
                    'src' => self::IMAGE_PASS.'del_emp.png',
                    'alt' => '従業員削除',
                    'class' => 'image',
                    'width' => '90',
                ],
            'img_create_emp_button' =>
                [
                    'src' => self::IMAGE_PASS.'create_emp_button.png',
                    'alt' => '新規従業員登録',
                    'class' => 'image',
                    'width' => '120',
                ],
            'img_re_create_emp' =>
                [
                    'src' => self::IMAGE_PASS.'re_create_emp.png',
                    'alt' => '再従業員登録',
                    'class' => 'image',
                    'width' => '100',
                ],
            'img_delete_emp_logo' =>
                [
                    'src' => self::IMAGE_PASS.'delete_emp_logo.png',
                    'alt' => '従業員削除ロゴ',
                    'class' => 'image',
                    'width' => '150',
                ],
            'img_re_create' =>
                [
                    'src' => self::IMAGE_PASS.'re_create.png',
                    'alt' => '再登録',
                    'class' => 'image',
                    'width' => '49',
                ],
            'img_re_create_button' =>
                [
                    'src' => self::IMAGE_PASS.'re_create_button.png',
                    'alt' => '再登録',
                    'class' => 'image',
                    'width' => '49',
                ],
            'img_re_emp_logo' =>
                [
                    'src' => self::IMAGE_PASS.'re_emp_logo.png',
                    'alt' => '従業員再登録',
                    'class' => 'image',
                    'width' => '170',
                ],
            'img_admin_login' =>
                [
                    'src' => self::IMAGE_PASS.'admin_login.png',
                    'alt' => '管理者ログイン',
                    'class' => 'image',
                    'width' => '230',
                ],
            'img_user_name' =>
                [
                    'src' => self::IMAGE_PASS.'user_name.png',
                    'alt' => 'ユーザー名',
                    'class' => 'image',
                    'width' => '80',
                ],
            'img_password' =>
                [
                    'src' => self::IMAGE_PASS.'password.png',
                    'alt' => 'パスワード',
                    'class' => 'image',
                    'width' => '80',
                ],
            'img_login' =>
                [
                    'src' => self::IMAGE_PASS.'login.png',
                    'alt' => 'ログイン',
                    'class' => 'image',
                    'width' => '90',
                ],
            'img_login_button' =>
                [
                    'src' => self::IMAGE_PASS.'login.png',
                    'alt' => 'ログインボタン',
                    'class' => 'login-button',
                    'width' => '70',
                ],
            'img_store_logo' =>
                [
                    'src' => self::IMAGE_PASS.'store_logo.png',
                    'alt' => '店舗ロゴ',
                    'class' => 'image',
                    'width' => '200',
                ],
            'img_logout_button' =>
                [
                    'src' => self::IMAGE_PASS.'logout_button.png',
                    'alt' => 'ログアウトボタン',
                    'class' => 'login-button',
                    'width' => '80',
                ],
        ];
    }

    /**
     * @return ImageManager
     * インスタンス取得
     */
    public static function getInstance()
    {
        if (!isset(self::$imageManager)) {
            self::$imageManager = new ImageManager();
        }
        return self::$imageManager;
    }

    public function getImageList()
    {
        return $this->imageList;
    }
}