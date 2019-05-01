<?php

require_once dirname(__FILE__) . '/../../Config/config.php';
require_once 'Table/UserTable.php';

class Db
{
    /**
     * ユーザーテーブルを取得
     * @return UserTable|null
     */
    static public function getUserTable() {
        $pdo = self::_connect();
        if (!$pdo) {
            return null;
        }
        return new UserTable($pdo);
    }

    /**
     * データベースに接続
     * 失敗したときには false を返します。
     * @return bool|PDO
     */
    static private function _connect() {
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
}