<?php
require_once('./models/Driver.php');

class FrontDriver extends Driver
{
    public function __construct($base)
    {
        parent::__construct($base);
    }

    public function addReservation(Reservation $reserv)
    {
        $sql = "INSERT INTO reservation (numClient, numChambre, dateArrivee, dateDepart) VALUES (?, ?, ?, ?)";
        $res = $this->base->prepare($sql);
        $insertReserv = [$reserv->getNumClient(), $reserv->getNumChambre(), $reserv->getDateArrivee(), $reserv->getDateDepart()];
        $res->execute($insertReserv);
        $res->closeCursor();
    }

    public function addClient(Client $client)
    {
        $sql = "INSERT INTO client (nom, prenom, tel, adresse) VALUES (?, ?, ?, ?)";
        $res = $this->base->prepare($sql);
        // Mise en forme des données récupérées du formulaire pour l'envoi à la BDD.
        // htmlentities() - Convertit tous les caractères éligibles en entités HTML (exemple : à = &agrave;).
        // addslashes() - Ajout d'antislashs pour échapper les caractères susmentionnés dans une chaîne de caractères qui doit être évalué par PHP.
        $insertCl = [
            addslashes(htmlentities($client->getNom())),
            addslashes(htmlentities($client->getPrenom())),
            addslashes(htmlentities($client->getTel())),
            addslashes(htmlentities($client->getAdresse()))
        ];
        $res->execute($insertCl);
        $res->closeCursor();

        return $this->base->lastInsertId();
    }
}