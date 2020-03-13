<?php
require_once('./communs/connect.php');

require_once('./models/backend/BackDriver.php');
require_once('./models/Chambre.class.php');
require_once('./models/Reservation.class.php');

class ChambreController extends Controller
{
    private $driver;

    public function __construct($base)
    {
        $this->driver = new BackDriver($base);
    }

    public function actAddChambre()
    {
        if(AuthController::isLogged())
        {
            if($_SESSION['role'] === 1)
            {
                $dataCompar = $this->driver->listeChambre();
                foreach($dataCompar as $row)
                {
                    $nChAllCompar[] = $row->getNumChambre();
                }
                unset($dataCompar);
                // var_dump($nChAllCompar);

                $newCh = new Chambre();

                if(isset($_POST['ajouter'])
                    && !empty($_POST['nCh'])
                    && !empty($_POST['prix'])
                    && !empty($_POST['conf']))
                {
                    // var_dump($_POST); echo '<br>';

                    $newCh->setNumChambre((int)$_POST['nCh']);
                    $newCh->setPrix((int)$_POST['prix']);
                    $newCh->setNbLits((int)$_POST['nLits']);
                    $newCh->setNbPers((int)$_POST['nPers']);
                    $newCh->setConfort(trim(addslashes(htmlentities($_POST['conf']))));
                    $newCh->FILES = $_FILES;
                    $newCh->setImage($newCh->FILES['image']['name']);
                    $newCh->setDescription(trim(addslashes(htmlentities($_POST['descr']))));
                    
                    foreach($nChAllCompar as $value)
                    {
                        if($value == $newCh->getNumChambre()) {
                            $nChExist = '<h3 class="text-center"><span class="bg-warning rounded px-3">Numéro de chambre éxistant</span></h3>';
                            break;
                        }
                    }
                    
                    if(!isset($nChExist)) {
                        $this->driver->addChambre($newCh);

                        header("location:./index.php?action=list_chambre");
                        $addSuccess = '<h2 class="text-center">Ajout réussi</h2>';
                    }
                }
                require_once('./views/backend/chAjout.php');
            } else {
                header('location:./index.php?action=list_chambre');
            }
        }
    }
    
    public function actListeChambre()
    {
        if(AuthController::isLogged())
        {
            $reserv = new Reservation();

            $occupationRes = 'Toutes les chambres';
            $data = $this->driver->listeChambre();
            
            $nbChambre = (int)count($data);

            require_once('./views/backend/chambre.php');
            unset($reserv);
        }
    }

    public function actListeChambreStatut()
    {
        if(AuthController::isLogged())
        {
            $reserv = new Reservation();

            $reserv->setDateArrivee(trim($_POST['dateArrSearch']));
            $reserv->setDateDepart(trim($_POST['dateDepSearch']));
            $reserv->statut = trim($_POST['occupation']);

            if((!empty($reserv->getDateArrivee()) || !empty($reserv->getDateDepart())) && $reserv->statut === 'Toutes')
            {
                $reserv->statut = "libre(s)";
            } else {
                $reserv->statut = trim($_POST['occupation']);
            }

            if(!empty($reserv->getDateArrivee()) && empty($reserv->getDateDepart()))
            {
                $t1an = (365*24*60*60);
                $reserv->setDateDepart(date('Y-m-d', (strtotime($reserv->getDateArrivee()) + $t1an)));
            }else if(empty($reserv->getDateArrivee()) && !empty($reserv->getDateDepart())) {
                $t1sem = (7*24*60*60);
                if($reserv->getDateDepart() > date('Y-m-d', (strtotime(date('Y-m-d')) + $t1sem)))
                {
                    $reserv->setDateArrivee(date('Y-m-d'));
                } else {
                    $reserv->setDateArrivee(date('Y-m-d', (strtotime($reserv->getDateDepart()) - $t1sem)));
                }
            }

            if($reserv->statut === 'Toutes')
            {
                $occupationRes = 'Toutes les chambres';
            } else {
                $occupationRes = 'Chambre(s) '.$reserv->statut;
            }

            $data = $this->driver->listeChambreStatut($reserv);
            
            require_once('./views/backend/chambre.php');
        }
    }

    public function actDeleteChambre($nCh, $img)
    {
        if(AuthController::isLogged())
        {
            if($_SESSION['role'] === 1)
            {
                $chambre = new Chambre();
    
                $chambre->setNumChambre($nCh);
                $chambre->setImage($img);
    
                $supStatut = $this->driver->deleteChambre($chambre);
                
                if($supStatut === 0)
                {
                    header("location:./index.php?action=list_chambre");
                    $supMsg = '<div class="posCenter"><h2 class="text-center">Suppression réussie</h2>';
                } else {
                    $supMsg = '<div class="posCenter"><h2 class="text-center">Echec de la suppression...</h2>';
                }
            }  else {
                $supMsg = '<div class="posCenter"><h2 class="text-center">Vous n\'avez pas les autorisations pour supprimer une chambre !</h2>';
            }
        }
        require_once('./views/backend/chSuppr.php');
    }
    
    public function actUpdateChambre($nCh)
    {
        if(AuthController::isLogged())
        {
            if($_SESSION['role'] === 1)
            {
                $chambre = new Chambre();
                
                $chambre->setNumChambre($nCh);

                $this->driver->detailChambre($chambre);

                $chambre->imgPrev = $chambre->getImage();

                if(isset($_POST['valider'])
                    && !empty($_POST['prix'])
                    && !empty($_POST['conf']))
                {
                    // print_r($_POST);
                    
                    $chambre->setPrix((int)$_POST['prix']);
                    $chambre->setNbLits((int)$_POST['nLits']);
                    $chambre->setNbPers((int)$_POST['nPers']);
                    $chambre->setConfort(trim(addslashes(htmlentities($_POST['conf']))));
                    $chambre->FILES = $_FILES;
                    if($chambre->FILES['image']['name'] != ('' && $chambre->getImage()))
                    {
                        $chambre->setImage($chambre->FILES['image']['name']);
                    }
                    $chambre->setDescription(trim(addslashes(htmlentities($_POST['descr']))));
                    
                    $retour = $this->driver->updateChambre($chambre);

                    if($retour)
                    {
                        $upSuccess = '<h2 class="text-center">Modification réussie</h2>';
                    }
                }
                require_once('./views/backend/chEdite.php');
            } else {
                header('location:./index.php?action=list_chambre');
            }
        }
    }
}