<?php

require_once dirname(__FILE__) . '/../../../Config/config.php';

class TableBase
{
    /**
     * @var PDO
     */
    protected $_pdo;

    /**
     * @param PDO $pdo
     */
    function __construct(PDO $pdo) {
        $this->_pdo = $pdo;
    }

    /**
     * select 文の prepare を行う
     * @param string $table テーブル名
     * @param string $param where区など
     * @return bool|PDOStatement
     */
    protected function _prepareSelect($table, $param = '') {
        $sql = 'select * from' . ' ' . $table . ' ' . $param;
        return $this->_pdo->prepare($sql);
    }

    /**
     * insert 文の prepare を行う
     * @param string $table
     * @param string $param
     * @return bool|PDOStatement
     */
    protected function _prepareInsert($table, $param) {
        $sql = 'insert into' . ' ' . $table . $param;
        return $this->_pdo->prepare($sql);
    }
}