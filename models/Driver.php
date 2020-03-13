<?php
abstract class Driver
{
    protected $base;

    public function __construct($base)
    {
        $this->base = $base;
    }

    public function listeChambre()
    {
        $sql = "SELECT * FROM chambre";
        $res = $this->base->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_OBJ);
        $res->closeCursor();

        $data = [];
        $compteur = 0;
        
        foreach($rows as $row)
        {
            $ch = new Chambre();
            $ch->setNumChambre($row->numChambre);
            $ch->setPrix($row->prix);
            $ch->setNbLits($row->nbLits);
            $ch->setNbPers($row->nbPers);
            $ch->setConfort($row->confort);
            $ch->setImage($row->image);
            $ch->setDescription(strlen($row->description) > 150 ? substr($row->description, 0, 150)." ..." : $row->description);

            $data[$compteur++] = $ch;
        }
        return $data;
    }

    public function detailChambre(Chambre $chambre)
    {
        $sql = "SELECT * FROM chambre WHERE numChambre = ?";
        $res = $this->base->prepare($sql);
        $res->execute([$chambre->getNumChambre()]);
        $row = $res->fetch(PDO::FETCH_OBJ);
        $res->closeCursor();

        $chambre->setPrix($row->prix);
        $chambre->setNbLits($row->nbLits);
        $chambre->setNbPers($row->nbPers);
        $chambre->setConfort($row->confort);
        $chambre->setImage($row->image);
        $chambre->setDescription($row->description);
        
        return $chambre;
    }

    public function listeReservation()
    {
        $sql = "SELECT * FROM reservation ORDER BY dateArrivee, dateDepart";
        $res = $this->base->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_OBJ);
        $res->closeCursor();

        $data = [];
        $compteur = 0;
        
        foreach($rows as $row)
        {
            $reserv = new Reservation();
            $reserv->setNumClient($row->numClient);
            $reserv->setNumChambre($row->numChambre);
            $reserv->setDateArrivee($row->dateArrivee);
            $reserv->setDateDepart($row->dateDepart);

            $data[$compteur++] = $reserv;
        }
        return $data;
    }
    
    public function VerifReservation(Reservation $reserv, $nClExist)
    {
        $data = [];
        $compteur = 0;

        if($nClExist === '')
        {
            $sql = "SELECT dateArrivee, dateDepart FROM reservation WHERE numChambre = ?
                AND (dateArrivee BETWEEN ? AND ? OR dateDepart BETWEEN ? AND ?) ORDER BY dateArrivee";
            $res = $this->base->prepare($sql);
            $selReserv = [$reserv->getNumChambre(), $reserv->getDateArrivee(), $reserv->dateDep_recMoins1J, $reserv->dateArr_recPlus1J, $reserv->getDateDepart()];
            $res->execute($selReserv);
            $rows = $res->fetchAll(PDO::FETCH_OBJ);
            $res->closeCursor();
            
            foreach($rows as $row)
            {
                $resReserv = new Reservation();
                $resReserv->setDateArrivee($row->dateArrivee);
                $resReserv->setDateDepart($row->dateDepart);

                $data[$compteur++] = $resReserv;
            }
        } else {
            $sql = "SELECT dateArrivee, dateDepart FROM reservation WHERE numChambre = ? && numClient != ?
                && (dateArrivee BETWEEN ? AND ? OR dateDepart BETWEEN ? AND ?) ORDER BY dateArrivee";
            $res = $this->base->prepare($sql);
            $selReserv = [$reserv->getNumChambre(), $reserv->getNumClient(), $reserv->getDateArrivee(), $reserv->dateDep_bddMoins1J, $reserv->dateArr_bddPlus1J, $reserv->getDateDepart()];
            $res->execute($selReserv);
            $rows = $res->fetchAll(PDO::FETCH_OBJ);
            $res->closeCursor();
            
            foreach($rows as $row)
            {
                $resReserv = new Reservation();
                $resReserv->setDateArrivee($row->dateArrivee);
                $resReserv->setDateDepart($row->dateDepart);

                $data[$compteur++] = $resReserv;
            }
        }
        return $data;
    }
    
    public function listeClient($param)
    {
        if($param === '')
        {
            $sql = "SELECT * FROM client";
            $res = $this->base->prepare($sql);
            $res->execute();
            $rows = $res->fetchAll(PDO::FETCH_OBJ);
            $res->closeCursor();

            $data = [];
            $compteur = 0;
            
            foreach($rows as $row)
            {
                $client = new Client();
                $client->setNumClient($row->numClient);
                $client->setNom($row->nom);
                $client->setPrenom($row->prenom);
                $client->setTel($row->tel);
                $client->setAdresse($row->adresse);

                $data[$compteur++] = $client;
            }
            return $data;
        } else {
            $client = new Client();

            $sql = "SELECT * FROM client WHERE numClient = ?";
            $res = $this->base->prepare($sql);
            $res->execute([$param]);
            $row = $res->fetch(PDO::FETCH_OBJ);
            $res->closeCursor();

            $client->setNumClient($row->numClient);
            $client->setNom($row->nom);
            $client->setPrenom($row->prenom);
            $client->setTel($row->tel);
            $client->setAdresse($row->adresse);

            return $client;
        }
    }

    public function detailReservation($nCh, $nCl)
    {
        $reserv = new Reservation();
        
        $sql = "SELECT dateArrivee, dateDepart FROM reservation WHERE numChambre = ? && numClient = ?";
        $res = $this->base->prepare($sql);
        $res->execute([$nCh, $nCl]);
        $row = $res->fetch(PDO::FETCH_OBJ);
        $reserv->rowSearch = (int)$res->rowCount();
        $res->closeCursor();

        if($reserv->rowSearch !== 0)
        {
            $reserv->setNumChambre($nCh);
            $reserv->setNumClient($nCl);
            $reserv->setDateArrivee($row->dateArrivee);
            $reserv->setDateDepart($row->dateDepart);
        }
        return $reserv;
    }
}