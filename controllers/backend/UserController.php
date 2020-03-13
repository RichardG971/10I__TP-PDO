<?php
session_start(); // Pas besoin d'appeler la 'session_start()' ailleurs car 'UserController.php' est appelé dans le 'Router' et toute les pages sont appelées à travers celui-ci.
require_once('./communs/connect.php');

require_once('./models/backend/BackDriver.php');
require_once('./models/Utilisateurs.class.php');

class UserController extends Controller
{
    private $driver;

    public function __construct($base)
    {
        $this->driver = new BackDriver($base);
    }

    public function actlogin()
    {
        $erreur = '';

        if(isset($_POST['soumettre']))
        {
            if(!empty($_POST['login']) && !empty($_POST['pwd']))
            {
                $user = new Utilisateurs;
                $user->setLogin(trim(htmlspecialchars(UserController::f_ch_retourBddUcwords($_POST['login']))));
                $user->setPass(md5(trim(htmlspecialchars($_POST['pwd']))));

                $this->driver->getUser($user);
        
                if($user->nbRow !== 0)
                {
                    $_SESSION['role'] = (int)$user->getRole();
                    $_SESSION['login'] = $user->getLogin();
                    header('location:./index.php?action=admin');
                } else {
                    $erreur =
                        '<div class="alert alert-danger text-center">
                            <strong>Attention !</strong> Le login ou le mot de passe est incorrect !
                        </div>';
                }
            } else {
                $erreur = '
                    <div class="alert alert-danger text-center">
                        <strong>Le login ou le mot de passe est vide!</strong> 
                    </div>';
            }
        }
        require_once('./views/backend/index.php');
    }

    public function actlogout()
    {
        session_start();
        session_destroy();
        session_unset();

        header('location:index.php?action=login');
        exit;
    }

    public function actFormUser()
    {
        if($_SESSION['role'] === 1)
        {
            $login = UserController::f_ch_retourBddUcwords($_POST['login']);
            $role = $this->driver->listeRole();

            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                foreach($_POST as $key => $val)
                {
                    if($key != 'ajouter' && empty($val))
                    {
                        $reponse =
                            '<div class="alert alert-danger text-center">
                                <strong>Attention !</strong> Tous les champs sont requis !
                            </div>';
                        break;
                    }
                }
                if(!isset($reponse))
                {
                    $reponse = UserController::actCreateUser();
                }
            }
            require_once('./views/backend/userAjout.php');
        } else {
            header('location:./index.php?action=admin');
        }
    }
    
    private function actCreateUser()
    {
        $user = new Utilisateurs();
        $user->setLogin(trim(UserController::f_ch_recupFormFormat($_POST['login'])));
        
        $verifLogin = $this->driver->listeLogin();

        foreach($verifLogin as $row)
        {
            if(UserController::f_ch_retourBddUcwords($row->getLogin()) == $user->getLogin())
            {
                $reponse = 
                    '<div class="alert alert-danger text-center">
                        <strong>Attention !</strong> Ce login éxiste déjà,<br>veuillez en choisir un autre.
                    </div>';

                unset($user);
                return $reponse;
                break;
            }
        }

        if(!isset($reponse))
        {
            if($_POST['pwd'] !== $_POST['pwd2'])
            {
                return 
                    '<div class="alert alert-danger text-center">
                        <strong>Attention !</strong> Les mots de passe ne sont pas identiques !
                    </div>';
            } else {
                $user->setLogin(htmlspecialchars(addslashes($user->getLogin())));
                $user->setPass(md5(trim(htmlspecialchars(addslashes($_POST['pwd'])))));
                $user->setRole((int)trim(htmlspecialchars(addslashes($_POST['role']))));

                $this->driver->createUser($user);
                
                return
                    '<div class="alert alert-success text-center">
                        <strong>Nouvel utilisateur créé avec succès !</strong><br>
                        Id : '.$user->getId_util().'<br>
                        Role : '.$user->statut.'<br>
                        Login : '.UserController::f_ch_retourBddUcwords($user->getLogin()).'
                    </div>'
                ;
            }
        }
    }
}