<?php

require_once dirname(__FILE__) . '/../Model/Db/DbBase.php';

/**
 * TOP 画面の挙動を司る
 */
class IndexController
{
    /**
     * @var array
     */
    private $_value = [];

    /**
     * 実際のページロジックを実行
     */
    public function execute() {

        // POST アクセス以外であれば何もしない
        if (!$this->_isPost()) {
            return;
        }

        // 以下 POST アクセスの場合、パラメータに応じて挙動を変更
        // まず必要なパラメータが揃っているかを確認

        // メールアドレスが設定されていない場合はエラー表示
        if (!isset($_POST['email']) || $_POST['email'] === '') {
            $this->_assign('error', 'Eメールアドレスを入力してください。');
            return;
        }

        // パスワードが設定されていない場合はエラー表示
        if (!isset($_POST['password']) || $_POST['password'] === '') {
            $this->_assign('error', 'パスワードを入力してください。');
            return;
        }

        // TODO: 本当はここで、メールアドレスの形式やパスワードの文字数が正しいのかの判定もする必要がある

        $email = $_POST['email'];
        $password = $_POST['password'];

        // 入力されたパスワードとメアドが正しかったら、データベースのテーブルに挿入する
        $table = Db::getUserTable();
        if (!$table) {
            // TODO: エラーメッセージはもう少し適切なものにする
            die('データベース接続でエラーが発生');
        }

        // …が、その前にメアドの重複を確認し、重複していたらエラー表示
        if (count($table->selectFromEmail($email)) !== 0) {
            $this->_assign('error', 'すでに使用されているメールアドレスです。');
            return;
        }

        // ここまで来て初めてデータベースに値を挿入する
        $r = $table->insert($email, $password);

        // 理由はよくわからないが挿入に失敗したらエラー表示
        if (!$r) {
            $this->_assign('error', 'ユーザー登録に失敗しました。');
            return;
        }

        $this->_assign('success', 'ユーザー登録されました。');
    }

    /**
     * アクセスが POST かどうか判定
     * @return bool
     */
    private function _isPost() {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }

    /**
     * 自分自身のページにリダイレクト(、つまり再読込と同じこと)を行う。
     * これは主に POST でアクセスされたとき、
     * 画面リロードをしたときに2重に POST 処理が行われることを防ぐ用途で使用される想定
     */
    private function _redirectToMyself() {
        header("Location: " . $_SERVER['PHP_SELF']);
    }

    /**
     * html 表示の段階で使うパラメータを設定
     * @param $key
     * @param $value
     */
    private function _assign($key, $value) {
        $this->_value[$key] = $value;
    }

    /**
     * html 表示に使用するパラメータを取得
     * @return array
     */
    public function getValue() {
        return $this->_value;
    }
}