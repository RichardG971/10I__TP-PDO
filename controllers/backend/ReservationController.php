<?php
require_once('./communs/connect.php');

require_once('./models/backend/BackDriver.php');
require_once('./models/Reservation.class.php');
require_once('./models/Chambre.class.php');
require_once('./models/Client.class.php');

class ReservationController extends Controller
{
    private $driver;

    public function __construct($base)
    {
        $this->driver = new BackDriver($base);
    }
    
    public function actListeReserv()
    {
        if(AuthController::isLogged())
        {
            $data = $this->driver->listeReservation();
            $nbRow = (int)count($data);
            
            require_once('./views/backend/admin.php');
        }
    }

    public function actDeleteReserv($nCh, $nCl)
    {
        if(AuthController::isLogged())
        {
            $reserv = $this->driver->detailReservation($nCh, $nCl);

            if(trim(ReservationController::f_ch_retourBdd($reserv->getDateDepart())) > date('Y-m-d'))
            {
                $resSuppr = false;
            } else {
                $resSuppr = true;
            }

            if($_SESSION['role'] === 1 || $resSuppr)
            {
                $this->driver->deleteReserv($reserv);
                header("location:./index.php?action=admin");
            }
            require_once('./views/backend/resSuppr.php');
        }
    }

    // Création de cette fonction pour introduire dans 'actDetailReserv()' et 'actUpdateReserv()' car ils ont la même base.
    private function objReserv($nCh, $nCl)
    {
        // Sélection de la chambre pour récupérer son prix :
        $chambre = new Chambre();
        $chambre->setNumChambre($nCh);
        $this->driver->detailChambre($chambre);
        
        // Sélection de la réservation.
        $reserv = $this->driver->detailReservation($nCh, $nCl);

        // Sélection du client.
        $client = $this->driver->listeClient($nCl);

        $adresseTab = explode(", ", ReservationController::f_ch_retourBddUcwords($client->getAdresse()));
        foreach ($adresseTab as $value) { $client->ad[] = $value; }

        $client->ad_rec = ['', '', ''];
        $reserv->form = 'required';
        $reserv->recap_donnees = [];
        
        return [$chambre, $client, $reserv];
    }

    public function actDetailReserv($nCh, $nCl)
    {
        if(AuthController::isLogged())
        {
            $tabObjReserv = ReservationController::objReserv($nCh, $nCl);
            $chambre = $tabObjReserv[0];
            $client = $tabObjReserv[1];
            $reserv = $tabObjReserv[2];

            // Calcul du prix du séjour.
            $dateArr = new DateTime($reserv->getDateDepart());
            $dateDep = new DateTime($reserv->getDateArrivee());

            $nbJour = $dateArr->diff($dateDep);

            $tpsSejour = $nbJour->format('%a');
            $prixSejour = ($chambre->getPrix() * $tpsSejour).' €';

            require_once('./views/backend/resDetail.php');
        }
    }

    public function actUpdateReserv($nCh, $nCl)
    {
        if(AuthController::isLogged())
        {
            $tabObjReserv = ReservationController::objReserv($nCh, $nCl);
            $chambre = $tabObjReserv[0];
            $client = $tabObjReserv[1];
            $reserv = $tabObjReserv[2];
            
            $dateArr_compar = trim($reserv->getDateArrivee());
            $dateDep_compar = trim($reserv->getDateDepart());
        
            // Calcul du temps d'une journée en secondes.
            $t1jour = (24*60*60);
            // Calcul du temps de 28 jours en seconde.
            $t1mois = (28*24*60*60);

            $dateArr_min = $dateArr_max = '';
            $dateDep_min = $dateDep_max = '';

            // Affection des valeurs max et min des dates selon la date d'arrivée et le rôle.
            if($dateArr_compar < date('Y-m-d'))
            {
                $dateArr_min = $dateArr_max = $dateArr_compar;

                if($_SESSION['role'] === 1)
                {
                    $dateDep_min = date('Y-m-d');
                } else {
                    $dateDep_min = $dateDep_compar;
                    $dateDep_max = date('Y-m-d', (strtotime($dateArr_compar) + $t1mois));
                }
            } else {
                if($_SESSION['role'] === 1)
                {
                    $dateArr_min = date('Y-m-d');
                } else {
                    $dateArr_min = $dateArr_max = $dateArr_compar;
                    $dateDep_min = $dateDep_compar;
                    $dateDep_max = date('Y-m-d', (strtotime($dateArr_compar) + $t1mois));
                }
            }

            // Champs concerné requis ou en simple lecture selon le rôle et la date de départ.
            if($dateDep_compar < date('Y-m-d'))
            {
                $reserv->form = 'readonly';
            } else {
                if($_SESSION['role'] === 1)
                {
                    $reserv->form = 'required';
                } else {
                    $reserv->form = 'readonly';
                }
            }

            if(isset($_POST['modifier']))
            {
                // print_r($_POST); echo '<br><br>';

                if($dateDep_compar < date('Y-m-d'))
                {
                    $reserv->recap_donnees['Dates saisies'] = 'Vous ne pouvez modifier les dates d\'un séjour terminé';
                } else {
                    if($_SESSION['role'] !== 1 && $_POST['dateArr'] != $dateArr_compar)
                    {
                        $reserv->recap_donnees['Dates saisies'] = 'Vous n\'êtes pas autorisé à modifier la date d\'arrivée.<br>Plus d\'options, contacter un administrateur.';
                    } else {
                        // Traîter s'il y a mise à jour des dates.
                        if($_POST['dateArr'] != $dateArr_compar || $_POST['dateDep'] != $dateDep_compar)
                        {
                            $reserv->recap_donnees['Dates saisies'] = 'Dates modifiées';
                            // Contrôle de la date d'arrivée si le séjour est en cours.
                            if($_POST['dateArr'] != $dateArr_compar && $dateArr_compar < date('Y-m-d'))
                            {
                                $reserv->recap_donnees['Dates saisies'] = 'Date d\'arrivée ne peut pas être modifier pour un séjour en cours';
                            } else {
                                $reserv->setDateArrivee(trim(addslashes(htmlentities($_POST['dateArr']))));
                                
                                // Contrôle de la date de départ selon le role.
                                if($dateDep_min < $reserv->getDateArrivee())
                                {
                                    $dateDep_min = date('Y-m-d', (strtotime($reserv->getDateArrivee()) + $t1jour));
                                    if($_SESSION['role'] !== 1)
                                    {
                                        $dateDep_max = date('Y-m-d', (strtotime($reserv->getDateArrivee()) + $t1mois));
                                    }
                                }

                                if(trim($_POST['dateDep']) < $dateDep_min)
                                {
                                    if($_SESSION['role'] === 1)
                                    {
                                        if($dateDep_min == date('Y-m-d'))
                                        {
                                            $reserv->recap_donnees['Dates saisies'] = 'Date de départ ne doit pas être inférieure à la date d\'aujourd\'hui.';
                                        } else {
                                            $reserv->recap_donnees['Dates saisies'] = 'Date de départ ne doit pas être inférieure ou égale à la date d\'arrivée.';
                                        }
                                    } else {
                                        $reserv->recap_donnees['Dates saisies'] = 'Date de départ ne doit pas être inférieure à la date de départ initialement enregistrée.';
                                    }
                                } else {
                                    $reserv->recap_donnees['Dates saisies'] = 'Dates renseignées valides';

                                    $reserv->setDateDepart(trim(addslashes(htmlentities($_POST['dateDep']))));

                                    // Ajout de 24h à la date d'arrivée sélectionnée par le client.
                                    $reserv->dateArr_bddPlus1J = date('Y-m-d', (strtotime($reserv->getDateArrivee()) + $t1jour));
                                    // Retrait de 24h à la date de départ sélectionnée par le client.
                                    $reserv->dateDep_bddMoins1J = date('Y-m-d', (strtotime($reserv->getDateDepart()) - $t1jour));
                                    // echo $reserv->getDateArrivee().' ----- '.$reserv->getDateDepart(); echo '<br>';
                                    // echo $reserv->dateArr_bddPlus1J.' ----- '.$reserv->dateDep_bddMoins1J; echo '<br>';

                                    // Sélection des dates de réservations connues pour la modification de réservation choisie par le client.
                                    $comparReserv = $this->driver->VerifReservation($reserv, $chambre->getNumChambre());
                                    $nbRow_res = (int)count($comparReserv);

                                    foreach($comparReserv as $d)
                                    {
                                        $dateIndispoArr[] = '<b>'.ReservationController::dateFormatMletter($d->getDateArrivee()).'</b>';
                                        $dateIndispoDep[] = '<b>'.ReservationController::dateFormatMletter($d->getDateDepart()).'</b>';
                                    }

                                    // Si la période est indisponible.
                                    if($nbRow_res !== 0) {
                                        $reserv->recap_donnees['Période'] = 'Période indisponible';
                                    // Si la période est disponible.
                                    } else {
                                        $reserv->recap_donnees['Période'] = 'Période disponible';
                                        // Mise à jour de la réservation.
                                        $this->driver->updateReserv($reserv, $_SESSION['role']);

                                        $reserv->recap_donnees['Réservation modifiée'] = 'Validée';
                                        $upSuccess = 'Modification réussie';
                                    }
                                }
                            }
                        } else { $reserv->recap_donnees['Dates saisies'] = 'Dates non modifiées'; }
                    }
                }
                // Récupération et formatage des données du formulaire soumis.
                $nom_rec = ReservationController::f_ch_recupFormFormatUpper($_POST['nom']);
                $prenom_rec = ReservationController::f_ch_recupFormFormat($_POST['prenom']);
                $tel_rec = ReservationController::f_ch_recupFormFormat(preg_replace('/^00+/', '0', $_POST['tel']));
                $ad_rec = $_POST['ad'];

                foreach($ad_rec as $value) { $adresse[] = ReservationController::f_ch_recupFormFormat($value); }
                $adresse_rec = implode(", ", $adresse);

                $nom_send = addslashes(htmlentities($nom_rec));
                $prenom_send = addslashes(htmlentities($prenom_rec));
                $tel_send = addslashes(htmlentities($tel_rec));
                $adresse_send = addslashes(htmlentities($adresse_rec));

                
                // Traiter s'il y a mise à jour du client.
                if(ReservationController::f_ch_retourBddUpper(stripslashes(html_entity_decode($client->getNom()))) != ReservationController::f_ch_retourBddUpper($nom_rec)
                    || ReservationController::f_ch_retourBddUpper(stripslashes(html_entity_decode($client->getPrenom()))) != ReservationController::f_ch_retourBddUpper($prenom_rec)
                    || ReservationController::f_ch_retourBddUpper(preg_replace('/^00+/', '0', stripslashes(html_entity_decode($client->getTel())))) != ReservationController::f_ch_retourBddUpper($tel_rec)
                    || ReservationController::f_ch_retourBddUpper(stripslashes(html_entity_decode($client->getAdresse()))) != ReservationController::f_ch_retourBddUpper($adresse_rec))
                {
                    if($_SESSION['role'] === 1) {
                        $client->setNom($nom_send);
                        $client->setPrenom($prenom_send);
                        $client->setTel($tel_send);
                        $client->setAdresse($adresse_send);

                        $this->driver->updateClient($client);
                        
                        $adresse_bddTab = explode(", ", ReservationController::f_ch_retourBddUcwords($adresse_send));
                        foreach ($adresse_bddTab as $key => $value) { $client->ad[$key] = $value; }

                        $reserv->recap_donnees['Mise à jour client'] = 'Oui';
                    } else {
                        $reserv->recap_donnees['Mise à jour client'] = 'Vous n\'êtes pas autorisé à modifier les données du clients.<br>Plus d\'options, contacter un administrateur.';
                    }
                } else {
                    $reserv->recap_donnees['Mise à jour client'] = 'Non';
                }
            }
            require_once('./views/backend/resEdite.php');
        }
    }
}
