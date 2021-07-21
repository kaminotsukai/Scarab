<?php declare(strict_types = 1);

namespace Scarab\View;

/**
 * HTMLのレンダリングを担当（テンプレートファイルを読み込み、コンテンツを生成する）
 */
class View
{
    private array $data;

    public function __construct() {}

    /**
     * ビュー変数をセットしたテンプレートファイルの内容を返す。
     * 出力をバッファリングすることでHTMLコンテンツを変数に格納する
     */
    public function render(string $filePath, array $data)
    {
        $this->data = $data;

        ob_start();

        // TODO: なんでバッファリングするのか？
        // require => 問題があると処理が止まるので、描画などの問題があっても続行していいような場合はincludeを使用する
        // file_get_content => ファイルの内容をすべて読み込むが、全てを文字列として変換されるのでマッピングできない
        // fgets => ファイルを1行ずつ読み取るので問題外

        // ここでテンプレートファイルを読み込んで、テンプレートファイル内に記述されたPHP関数を実行する
        include($filePath);
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /**
     * ビュー変数を取得する
     *
     * @param string $name
     * @return void
     */
    public function __get(string $name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * このクラスに存在しないメソッドが呼ばれた時に実行される
     */
    public function __call($helperMethod, $args)
    {
        $helperClass = "\\Scarab\\View\\Helpers\\" . ucfirst($helperMethod) . 'Helper';
        $helperInstance = new $helperClass();
        return call_user_func_array(
            array($helperInstance, $helperMethod),
            $args
        );
    }
}
