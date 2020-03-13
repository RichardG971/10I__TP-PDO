<?php
class AuthController
{
    static function isLogged()
    {
        try
        {
            if(isset($_SESSION['login']))
            {
                return true;
            } else {
                throw new Exception("Action non valide", 1);
            }
        } catch (Exception $e) {
            AuthController::page404($e->getMessage());
        }
    }

    static private function page404($msgerreur)
    {
        require_once('./views/page404.php');
    }
}