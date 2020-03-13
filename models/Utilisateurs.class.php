<?php
class Utilisateurs
{
    private $id_util;
    private $login;
    private $pass;
    private $role;
    
    public function getId_util() {
        return $this->id_util;
    }

    public function setId_util($id_util) {
        $this->id_util = $id_util;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }
}