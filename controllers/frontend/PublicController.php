<?php
require_once('./communs/connect.php');

require_once('./models/frontend/FrontDriver.php');
require_once('./models/Chambre.class.php');
require_once('./models/Client.class.php');
require_once('./models/Reservation.class.php');

require_once('./assets/librairies/Stripe/vendor/autoload.php');

class PublicController extends Controller
{
    private $driver;

    public function __construct($base)
    {
        $this->driver = new FrontDriver($base);
    }

    public function accueil()
    {
        $data = $this->driver->listeChambre();
        require_once('./views/frontend/accueil.php');
    }

    public function actDetailChambre($nCh)
    {
        $chambre = new Chambre();
        $chambre->setNumChambre($nCh);
        $this->driver->detailChambre($chambre);
        require_once('./views/frontend/chambre_detail.php');
    }

    public function actListeClient()
    {
        $dataCl = $this->driver->listeClient('');
    }

    public function actReservation($nCh)
    {
        $chambre = new Chambre();
        $client = new Client();
        $reserv = new Reservation();

        $client->ad_rec = ['', '', ''];
        $reserv->form = 'required';
        $reserv->recap_donnees = [];
        $reserv->recap_donnees['Nouvelle réservation'] = 'Réservation non validée';
        $chambre->setNumChambre($nCh);
        $reserv->setNumChambre($chambre->getNumChambre());
        $this->driver->detailChambre($chambre);

        if(isset($_POST['reserver'])
            && !empty($_POST['dateArr']) && !empty($_POST['dateDep'])
            && !empty($_POST['nom']) && !empty($_POST['tel']))
        {
            PublicController::actReservationSubmit($chambre, $client, $reserv);
        } else {
            require_once('./views/frontend/reserver.php');
        }
    }

    public function actReservationSubmit(Chambre $chambre, Client $client, Reservation $reserv)
    {
        // print_r($_POST); echo '<br><br>';

        // Récupération et formatage des données du formulaire soumis.
        $client->setNom(PublicController::f_ch_recupFormFormatUpper($_POST['nom']));
        $client->setPrenom(PublicController::f_ch_recupFormFormat($_POST['prenom']));
        $client->setTel(PublicController::f_ch_recupFormFormat(preg_replace('/^00+/', '0', $_POST['tel'])));
        $client->ad_rec = $_POST['ad'];

        foreach($client->ad_rec as $value) { $adresse[] = PublicController::f_ch_recupFormFormat($value); }
        $client->setAdresse(implode(", ", $adresse));

        // Sélectionner le numéro client s'il existe.
        $clientAll = $this->driver->listeClient('');

        $row_clientAll = (int)count($clientAll);

        // Contrôler s'il y a des clients en BDD.
        if($row_clientAll === 0) {
            $client->setNumClient('Nouveau client');
            $reserv->recap_donnees['Client'] = $client->getNumClient(); /*****/ $msgAccCl = 'Bienvenue ';
            $reserv->recap_donnees['Num Client'] = 'Non affecté';
        } else {
            foreach($clientAll as $row)
            {
                // html_entity_decode() - Décode une chaîne encodée avec 'htmlentities()'.
                // stripslashes() — Décode une chaîne encodée avec 'addcslashes()'.
                if(PublicController::f_ch_retourBddUpper(stripslashes(html_entity_decode($row->getNom()))) == PublicController::f_ch_retourBddUpper($client->getNom())
                    && PublicController::f_ch_retourBddUpper(stripslashes(html_entity_decode($row->getPrenom()))) == PublicController::f_ch_retourBddUpper($client->getPrenom())
                    && PublicController::f_ch_retourBddUpper(stripslashes(html_entity_decode($row->getAdresse()))) == PublicController::f_ch_retourBddUpper($client->getAdresse()))
                {
                    $reserv->recap_donnees['Client'] = 'Client connu'; /*****/ $msgAccCl = 'Bon retour ';
                    $client->setNumClient($row->getNumClient());
                    $reserv->setNumClient($client->getNumClient());
                    $reserv->recap_donnees['Num Client'] = $client->getNumClient();
                break;
                } else {
                    $client->setNumClient('Nouveau client');
                    $reserv->recap_donnees['Client'] = $client->getNumClient(); /*****/ $msgAccCl = 'Bienvenue ';
                    $reserv->recap_donnees['Num Client'] = 'Non affecté';
                }
            }
        }

        $reserv->recap_donnees['Dates saisies'] = 'Dates non renseignées'; /*****/ $dateInfo = 'Vous n\'avez pas renseigné de dates !';
        // Contrôle de la date d'arrivée si elle est inférieure à la date du jour actuel.
        if($_POST['dateArr'] < date('Y-m-d')) {
            $reserv->recap_donnees['Dates saisies'] = 'Date d\'arrivée ne doit pas être inférieure à la date d\'aujourd\'hui'; /*****/ $dateInfo = 'Votre date d\'arrivée ne peut pas être inférieur à la date d\'aujourd\'hui.';
        } else {
            $reserv->setDateArrivee(trim(addslashes(htmlentities($_POST['dateArr']))));

            // Contrôle de la date de départ si elle est inférieure ou égale à la date d'arrivée.
            if($_POST['dateDep'] <= $_POST['dateArr'])
            {
                $reserv->recap_donnees['Dates saisies'] = 'Date de départ ne doit pas être inférieure ou égale à la date d\'arrivée.'; /*****/ $dateInfo = 'Votre date de départ ne doit pas être inférieur ou égale à votre date d\'arrivée.';
            } else {
                $reserv->recap_donnees['Dates saisies'] = 'Dates choisies valides'; /*****/ $dateInfo = '';
                $reserv->setDateDepart(trim(addslashes(htmlentities($_POST['dateDep']))));

                // Un client peut arriver le jour d'un départ d'un autre client et inversement,
                // il faut donc le prendre en compte en calculant les dates pour la requête sql qui vient ensuite avec 'BETWEEN'.
                // Calcul du temps d'une journée en seconde.
                $t1jour = (24*60*60);
                // Calcul du temps de 28 jours en seconde.
                $t1mois = (28*24*60*60);
                // Ajout de 24h à la date d'arrivée sélectionnée par le client.
                $reserv->dateArr_recPlus1J = date('Y-m-d', (strtotime($reserv->getDateArrivee()) + $t1jour));
                // Ajout de 28 jours à la date d'arrivée sélectionnée par le client.
                $reserv->dateArr_recPlus1M = date('Y-m-d', (strtotime($reserv->getDateArrivee()) + $t1mois));
                // Retrait de 24h à la date de départ sélectionnée par le client.
                $reserv->dateDep_recMoins1J = date('Y-m-d', (strtotime($reserv->getDateDepart()) - $t1jour));
                // echo $reserv->getDateArrivee().' ----- '.$reserv->getDateDepart(); echo '<br>';
                // echo $reserv->dateArr_recPlus1J.' ----- '.$reserv->dateDep_recMoins1J; echo '<br>';

                // Sélection des dates de réservations connues pour la chambre sélectionnée dans la période choisie par le client.
                $verifReserv = $this->driver->VerifReservation($reserv, '');

                $row_verifReserv = (int)count($verifReserv);

                foreach($verifReserv as $row) {
                    $dateIndispoArr[] = '<b>'.PublicController::dateFormatMletter($row->getDateArrivee()).'</b>';
                    $dateIndispoDep[] = '<b>'.PublicController::dateFormatMletter($row->getDateDepart()).'</b>';
                }

                if((!isset($_SESSION['role']) || $_SESSION['role'] !== 1) && $reserv->getDateDepart() > $reserv->dateArr_recPlus1M) {
                    $reserv->recap_donnees['Dates saisies'] = 'Date de départ trop grande'; /*****/ $dateInfo = 'Votre date de départ ne peut aller au delà de 4 semaines de votre date d\'arrivée.';
                    $reserv->recap_donnees['Durée période'] = 'Durée de période sélectionnée sur le site ne doit pas exéder 4 semaines'; /*****/ $periode = 'La période que vous avez choisie est trop grande.<br>Pour plus de possibilités, contacter directement l\'établissement.';
                } else {
                    $reserv->recap_donnees['Durée période'] = 'Durée de période sélectionnée sur le site acceptée';
                    // Si la période est indisponible.
                    if($row_verifReserv !== 0) {
                        $reserv->recap_donnees['Période'] = 'Période indisponible'; /*****/ $periode = 'La période que vous avez choisie n\'est pas disponible.';
                    // Si la période est disponible.
                    } else {
                        $reserv->recap_donnees['Période'] = 'Période disponible';

                        // Si le client éxiste et que la réservation est possible, vérifier qu'il n'a pas déjà une réservation sur cette chambre.
                        if($client->getNumClient() != 'Nouveau client')
                        {
                            $verifReservCl = $this->driver->detailReservation($chambre->getNumChambre(), $client->getNumClient());

                            // S'il y a déjà une réservation existante pour le client.
                            if($verifReservCl->rowSearch !== 0)
                            {
                                $reserv->recap_donnees['Réservation'] = 'Chambre déjà réservée'; /*****/ $reservConnue = 'Vous avez déjà une réservation connue pour cette chambre du ';
                            // S'il n'y pas de réservation éxistante pour le client.
                            } else {
                                $reserv->recap_donnees['Réservation'] = 'Réservation possible';

                                $_SESSION['cons']['client'] = $client;
                            }
                        } else {
                            $_SESSION['cons']['newCl'] = $client;

                            $reserv->recap_donnees['Réservation'] = 'Réservation possible';
                        }

                        // Si un client connu n'a pas déjà de réservation pour cette chambre.
                        if($reserv->recap_donnees['Réservation'] != 'Chambre déjà réservée')
                        {
                            $dateArr = new DateTime($reserv->getDateDepart());
                            $dateDep = new DateTime($reserv->getDateArrivee());

                            $nbJour = $dateArr->diff($dateDep);

                            $tpsSejour = $nbJour->format('%a');
                            $reserv->setPrixTotal((int)(($chambre->getPrix() * $tpsSejour)));

                            $_SESSION['cons']['reserv'] = $reserv;

                            $reserv->recap_donnees['Nouvelle réservation'] = 'Réservation en attente de paiement';
                            $reserv->form = 'readonly';
                        }
                    }
                }
            }
        }
        if(!isset($_SESSION['login']))
        {
            if($reserv->recap_donnees['Nouvelle réservation'] == 'Réservation en attente de paiement') {
                $formRes = 'formResFinal';
            } else {
                $formRes = 'formRes';
            }
        }
        require_once('./views/frontend/reserver.php');
    }

    public function checkout()
    {
        $reserv = $_SESSION['cons']['reserv'];

        if(isset($_GET['nCh']) && !empty($_GET['nCh']))
        {
            $nCh = $_GET['nCh'];
            $prix = $_GET['prix'];
        }
        require_once('./views/frontend/checkout.php');
    }

    public function payement()
    {
        if(isset($_POST['stripeToken']) && !empty($_POST['stripeToken']))
        {
            $token = $_POST['stripeToken'];
            $prix = (int)$_POST['prix'];
            $nCh = $_POST['nCh'];

            \Stripe\Stripe::setApiKey("sk_test_fnszwMz2YEz6KX7eBXLCjJfz00JfebNXx0");
            $charge = \Stripe\Charge::create(
                [
                    'amount'=>$prix*100,
                    'currency'=>'eur',
                    'description'=>'ventes d\'un séjour',
                    'source'=> $token
                ]
            );
        }

        if($charge)
        {
            if(isset($_SESSION['cons']['newCl']))
            {
                $client = $_SESSION['cons']['newCl'];
                $reserv = $_SESSION['cons']['reserv'];
                unset($_SESSION['cons']['newCl']);
                unset($_SESSION['cons']['reserv']);

                $lastId = (int)$this->driver->addClient($client); // Récupérer l'id du nouveau client.
                $reserv->setNumClient($lastId);
            } else {
                $reserv = $_SESSION['cons']['reserv'];
                unset($_SESSION['cons']['reserv']);
            }
            $this->driver->addReservation($reserv);
            $reserv->setOrder(uniqid());
            $client = $this->driver->listeClient($reserv->getNumClient());
        }
        require_once('./views/frontend/recap.php');
    }
}