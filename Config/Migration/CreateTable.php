<?php

require_once dirname(__FILE__) . '/../config.php';

/**
 * テーブルの新規作成や削除をコード上で行うためのクラス
 *
 * 実行する場合、コマンドラインから
 *  php /path/to/CreateTable.php up
 *  php /path/to/CreateTable.php down
 * のように使用してください。
 *
 * up を指定した場合はテーブル作成、down を指定した場合はテーブルの削除を行います。
 * ※ down コマンドを実行した場合はテーブルに含まれるすべてのデータが削除されてしまいます。
 *
 * このクラスを使用する前に、Config/config.php のデータベース設定を記入してください。
 *
 * テーブルを新しく追加したい場合は、このクラスの
 *  _getUpSqls / _getDownSqls
 * メソッドの内容を書き換えて、コマンドラインから再度実行してください。
 *
 * 本来であればトランザクション等を考慮しなければいけないですが、簡単のために省略しています。
 */
class CreateTable
{
    /**
     * テーブル作成を行う
     * @return bool
     */
    public function up() {
        $db = $this->_connect();
        if (!$db) {
            echo "データベース接続に失敗しました\n";
        }

        // 実行する sql 文をすべて取得
        $sqls = $this->_getUpSqls();

        // sql 文を一つずつ実行するためにループを回す
        foreach ($sqls as $sql) {

            // sql 文を実行
            $r = $db->query($sql);

            // 途中でエラーがあった場合はエラー表示して終了
            if (!$r) {
                echo "テーブル作成に失敗しました\n";
                return false;
            }
        }

        // 最後までエラーがなかったら成功
        echo "テーブルをすべて作成しました\n";
        return true;
    }

    /**
     * テーブル削除を行う
     * @return bool
     */
    public function down() {
        $db = $this->_connect();
        if (!$db) {
            echo "データベース接続に失敗しました\n";
        }

        // 実行する sql 文をすべて取得
        $sqls = $this->_getDownSqls();

        // sql 文を一つずつ実行するためにループを回す
        foreach ($sqls as $sql) {

            // sql 文を実行
            $r = $db->query($sql);

            // 途中でエラーがあった場合はエラー表示して終了
            if (!$r) {
                echo "テーブル削除に失敗しました\n";
                return false;
            }
        }

        // 最後までエラーがなかったら成功
        echo "テーブルをすべて削除しました\n";
        return true;
    }

    /**
     * データベースに接続
     * 失敗したときには false を返します。
     *
     * @return bool|PDO
     */
    private function _connect() {
        try {
            $config = getGlobalConfig();
            $db = new PDO(
                'mysql:host=' . $config['mysql']['host'] . '; dbname=' . $config['mysql']['dbname'] . '; charset=utf8',
                $config['mysql']['username'],
                $config['mysql']['password']);
            return $db;
        } catch (Exception $e) {
            // TODO: 本来なら例外を握りつぶすべきではないが、仮でこうしておく
            return false;
        }
    }

    /**
     * テーブルを作成する sql 文を取得
     * @param string $name テーブル名
     * @param array $params ['id int(11) auto_increment primary key', 'email varchar(255)', …] の形式の配列
     * @return string
     */
    private function _getCreateTableSql($name, array $params) {
        $sql = 'create table' . ' ' . $name . ' (';
        $sql .= implode(',', $params);
        $sql .= ')';
        return $sql;
    }

    /**
     * テーブルを削除する sql 文を取得
     * @param string $name テーブル名
     * @return string
     */
    private function _getDropTableSql($name) {
        $sql = 'drop table' . ' ' . $name;
        return $sql;
    }

    /**
     * テーブル作成を行うための SQL 文をすべて取得する
     * @return array
     */
    private function _getUpSqls() {
        $sqls = [];
        $sqls[] = $this->_getCreateTableSql('keijiban', [
            'id int(11) auto_increment primary key',
            'email varchar(255)',
            'password varchar(255)'
        ]);
        $sqls[] = $this->_getCreateTableSql('comment', [
            'id int(11) auto_increment primary key',
            'username varchar(255)',
            'comment varchar(255)'
            // TODO: ここに投稿日時や更新日時を保存するためのカラムを追加する必要がある
        ]);
        return $sqls;
    }

    /**
     * テーブル削除を行うための SQL 文をすべて取得する
     * @return array
     */
    private function _getDownSqls() {
        $sqls = [];
        $sqls[] = $this->_getDropTableSql('keijiban');
        $sqls[] = $this->_getDropTableSql('comment');
        return $sqls;
    }
}



$migration = new CreateTable();
$option = isset($argv[1]) ? $argv[1] : '';

if ($option === 'up') {
    $migration->up();
} else if ($option === 'down') {
    $migration->down();
} else {
    echo "up(テーブル作成用) もしくは down(テーブル削除用) の引数を指定してください。\n";
}