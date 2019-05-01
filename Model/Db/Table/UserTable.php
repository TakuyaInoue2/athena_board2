<?php

require_once dirname(__FILE__) . '/TableBase.php';

class UserTable extends TableBase
{

    /**
     * @param string $email
     * @return array fetch 結果
     */
    public function selectFromEmail($email) {
        $prepare = $this->_prepareSelect('keijiban', 'where email like :email');
        $prepare->bindParam(':email', $email, PDO::PARAM_STR);
        $prepare->execute();
        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function insert($email, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $prepare = $this->_prepareInsert('keijiban', '(email, password) values (:email, :password)');
        $prepare->bindParam(':email', $email, PDO::PARAM_STR);
        $prepare->bindParam(':password', $password, PDO::PARAM_STR);
        return $prepare->execute();
    }

}