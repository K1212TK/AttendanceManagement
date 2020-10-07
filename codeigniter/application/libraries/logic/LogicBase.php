<?php


namespace app\libraries\logic;

use function base_url;

/**
 * ロジック 親クラス
 * Class LogicBase
 * @package app\libraries\logic
 */
class LogicBase
{
    /**
     * 指定したページへリダイレクト
     * @param string $controllerName コントローラ名
     * @param string $functionName ファンクション名
     */
    public function redirect(string $controllerName, string $functionName)
    {
        //Xampp
        //redirect("http://localhost/codeigniter/{$controllerName}/{$functionName}");
        redirect(base_url()."{$controllerName}/{$functionName}");
    }
}
