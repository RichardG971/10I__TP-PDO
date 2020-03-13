<?php
require_once('./controllers/backend/AuthController.php');
require_once('./controllers/Controller.php');
require_once('./controllers/backend/ChambreController.php');
require_once('./controllers/backend/ReservationController.php');
require_once('./controllers/frontend/PublicController.php');
require_once('./controllers/backend/UserController.php');


class Router
{
    private $ctrChambre;
    private $ctrReserv;
    private $ctrPub;
    private $ctrUser;

    public function __construct($base)
    {
        $this->ctrChambre = new ChambreController($base);
        $this->ctrReserv = new ReservationController($base);
        $this->ctrPub = new PublicController($base);
        $this->ctrUser = new UserController($base);
    }

    public function reqUrl()
    {
        try
        {
            if(isset($_GET['action']))
            {
                if($_GET['action'] == 'list_chambre')
                {
                    if(isset($_POST['search']) && (!empty($_POST['dateArrSearch']) || !empty($_POST['dateDepSearch'])))
                    {
                        $this->ctrChambre->actListeChambreStatut();
                    } else {
                        $this->ctrChambre->actListeChambre();
                    }
                } else if($_GET['action'] == 'ajout_chambre') {
                    $this->ctrChambre->actAddChambre();
                } else if($_GET['action'] == 'detail_chambre') {
                    if(isset($_GET['chambre']))
                        {
                            $nCh = (int)htmlentities(trim($_GET['chambre']));
                            
                            if($nCh !== 0)
                            {
                                $this->ctrPub->actDetailChambre($nCh);
                            }
                        }
                } else if($_GET['action'] == 'del_chambre') {
                    if(isset($_GET['chambre']) && isset($_GET['img']))
                    {
                        $nCh = (int)htmlentities(trim($_GET['chambre']));
                        $img = $_GET['img'];
                        
                        if($nCh !== 0)
                        {
                            $this->ctrChambre->actDeleteChambre($nCh, $img);
                        }
                    }
                } else if($_GET['action'] == 'upd_chambre') {
                    if(isset($_GET['chambre']))
                    {
                        $nCh = (int)htmlentities(trim($_GET['chambre']));
                        
                        if($nCh !== 0)
                        {
                            $this->ctrChambre->actUpdateChambre($nCh);
                        }
                    }
                } else if($_GET['action'] == 'admin') {
                    $this->ctrReserv->actListeReserv();
                } else if($_GET['action'] == 'reservation') {
                    if(isset($_GET['chambre']))
                    {
                        $nCh = (int)trim($_GET['chambre']);

                        if($nCh !== 0)
                        {
                            $this->ctrPub->actReservation($nCh);
                        }
                    }
                } else if($_GET['action'] == 'del_reserv') {
                    if(isset($_GET['client']) && isset($_GET['chambre']))
                    {
                        $nCh = (int)trim($_GET['chambre']);
                        $nCl = (int)trim($_GET['client']);
                        
                        if(($nCh && $nCl) !== 0)
                        {
                            $this->ctrReserv->actDeleteReserv($nCh, $nCl);
                        }
                    }
                } else if($_GET['action'] == 'detail_reserv') {
                    if(isset($_GET['client']) && isset($_GET['chambre']))
                    {
                        $nCh = (int)trim($_GET['chambre']);
                        $nCl = (int)trim($_GET['client']);
                        
                        if(($nCh && $nCl) !== 0)
                        {
                            $this->ctrReserv->actDetailReserv($nCh, $nCl);
                        }
                    }
                } else if($_GET['action'] == 'upd_reserv') {
                    if(isset($_GET['client']) && isset($_GET['chambre']))
                    {
                        $nCh = (int)trim($_GET['chambre']);
                        $nCl = (int)trim($_GET['client']);
                        
                        if(($nCh && $nCl) !== 0)
                        {
                            $this->ctrReserv->actUpdateReserv($nCh, $nCl);
                        }
                    }
                } else if($_GET['action'] == 'login') {
                    $this->ctrUser->actlogin();
                } else if($_GET['action'] == 'logout') {
                    $this->ctrUser->actlogout();
                } else if($_GET['action'] == 'add_user') {
                    $this->ctrUser->actFormUser();
                } else if ($_GET['action']=='recap') {
                    if($_SERVER['REQUEST_METHOD'] === 'POST')
                    {
                        $this->ctrPub->payement();
                    } else {
                        $this->ctrPub->checkout();
                    }
                } else {
                    throw new Exception("Action non valide", 1);
                }
            }
            else
            {
                $this->ctrPub->accueil();
            }
        } catch (Exception $e) {
            // echo $e->getMessage();
            $this->page404($e->getMessage());
        }
    }

    private function page404($msgerreur)
    {
        require_once('./views/page404.php');
    }
}