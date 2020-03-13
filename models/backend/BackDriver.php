<?php
require_once('./models/Driver.php');

class BackDriver extends Driver
{
    public function __construct($base)
    {
        parent::__construct($base);
    }

    public function addChambre(Chambre $newCh)
    {
        $sql = "INSERT INTO chambre(numChambre, prix, nbLits, nbPers, confort, image, description)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $res = $this->base->prepare($sql);
        $insertCh = [$newCh->getNumChambre(), $newCh->getPrix(), $newCh->getNbLits(), $newCh->getNbPers(), $newCh->getConfort(), $newCh->getImage(), $newCh->getDescription()];
        $res->execute($insertCh);
        $res->closeCursor();

        $destination = './assets/Img/';
        move_uploaded_file($newCh->FILES['image']['tmp_name'],
            $destination.$newCh->getImage());
    }

    public function listeChambreStatut(Reservation $reserv)
    {
        // Sélection des chambres occupées.
        if($reserv->statut === 'occupée(s)')
        {
            $sql = "SELECT * FROM chambre
            WHERE numChambre IN
                (SELECT DISTINCT numChambre FROM reservation
                WHERE (dateArrivee >= ? AND dateArrivee < ?)
                OR (dateDepart > ? AND dateDepart <= ?)
                OR (dateArrivee < ? AND dateDepart > ?))";
        } else if($reserv->statut === 'libre(s)') {
            // Sélection des chambres libres.
            $sql = "SELECT * FROM chambre
            WHERE numChambre NOT IN
                (SELECT DISTINCT numChambre FROM reservation
                WHERE (dateArrivee >= ? AND dateArrivee < ?)
                OR (dateDepart > ? AND dateDepart <= ?)
                OR (dateArrivee < ? AND dateDepart > ?))";
        }

        $res = $this->base->prepare($sql);
        $selChambre = [$reserv->getDateArrivee(), $reserv->getDateDepart(), $reserv->getDateArrivee(), $reserv->getDateDepart(), $reserv->getDateArrivee(), $reserv->getDateDepart()];
        $res->execute($selChambre);
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

    public function deleteChambre(Chambre $chambre)
    {
        $sql = "DELETE FROM chambre WHERE numChambre = ?";
        $res = $this->base->prepare($sql);
        $res->execute([$chambre->getNumChambre()]);
        $res->closeCursor();

        $sql = "SELECT * FROM chambre WHERE numChambre = ?";
        $res = $this->base->prepare($sql);
        $res->execute([$chambre->getNumChambre()]);
        $res->fetch(PDO::FETCH_OBJ);
        $rowSearch = (int)$res->rowCount();
        $res->closeCursor();

        if($rowSearch === 0)
        {
            unlink('./assets/Img/'.$chambre->getImage());
        }

        return $rowSearch;
    }

    public function updateChambre(Chambre $chambre)
    {
        if($chambre->getImage() == "")
        {
            $sql = "UPDATE chambre SET prix = ?, nbLits = ?, nbPers = ?, confort = ?, description = ? WHERE numChambre = ?";
            $res = $this->base->prepare($sql);
            $updChambre = [$chambre->getPrix(), $chambre->getNbLits(), $chambre->getNbPers(), $chambre->getConfort(), $chambre->getDescription(), $chambre->getNumChambre()];
            $res->execute($updChambre);

            return true;
        } else {
            $sql = "UPDATE chambre SET prix = ?, nbLits = ?, nbPers = ?, confort = ?, image = ?, description = ? WHERE numChambre = ?";
            $res = $this->base->prepare($sql);
            $updChambre = [$chambre->getPrix(), $chambre->getNbLits(), $chambre->getNbPers(), $chambre->getConfort(), $chambre->getImage(), $chambre->getDescription(), $chambre->getNumChambre()];
            $res->execute($updChambre);

            $destination = './assets/Img/';
            move_uploaded_file($chambre->FILES['image']['tmp_name'],
                $destination.$chambre->getImage());
            
            if(($chambre->getImage() != '') && ($chambre->getImage() != $chambre->imgPrev))
            {
                unlink('./assets/Img/'.$chambre->imgPrev);
            }
            return true;
        }
        $res->closeCursor();
    }

    public function deleteReserv(Reservation $reserv)
    {
        $sql = "DELETE FROM reservation WHERE numClient = ? && numChambre = ?";
        $res = $this->base->prepare($sql);
        $res->execute([$reserv->getNumClient(), $reserv->getNumChambre()]);
        $res->closeCursor();
    }

    public function updateReserv(Reservation $reserv, $role)
    {
        if($role === 1) {
            $sql = "UPDATE reservation SET dateArrivee = ?, dateDepart = ? WHERE numClient = ?";
            $res = $this->base->prepare($sql);
            $updReserv = [$reserv->getDateArrivee(), $reserv->getDateDepart(), $reserv->getNumClient()];
        } else {
            $sql = "UPDATE reservation SET dateDepart = ? WHERE numClient = ?";
            $res = $this->base->prepare($sql);
            $updReserv = [$reserv->getDateDepart(), $reserv->getNumClient()];
        }
        $res->execute($updReserv);
        $res->closeCursor();
    }

    public function updateClient(Client $client)
    {
        $sql = "UPDATE client SET nom = ?, prenom = ?, tel = ?, adresse = ? WHERE numClient = ?";
        $res = $this->base->prepare($sql);
        $updClient = [$client->getNom(), $client->getPrenom(), $client->getTel(), $client->getAdresse(), $client->getNumClient()];
        $res->execute($updClient);
        $res->closeCursor();
    }

    public function getUser(Utilisateurs $user)
    {
        $sql = "SELECT * FROM utilisateurs WHERE login = ? AND pass = ?";
        $res = $this->base->prepare($sql);
        $res->execute([$user->getLogin(), $user->getPass()]);
        $row = $res->fetch(PDO::FETCH_OBJ);
        $user->nbRow = (int)$res->rowCount();
        $res->closeCursor();

        if($user->nbRow !== 0)
        {
            $user->setId_util($row->id_util);
            $user->setRole($row->role);
        }
        return $user;
    }

    public function listeRole()
    {
        $sql = "SELECT DISTINCT role FROM utilisateurs";
        $res = $this->base->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_OBJ);
        $res->closeCursor();

        $data = [];
        $compteur = 0;
        
        foreach($rows as $row)
        {
            $role = new Utilisateurs();
            $role->setRole($row->role);
            (int)$role->getRole() === 1 ? $role->statut = 'Administrateur': $role->statut = 'Réceptionniste';

            $data[$compteur++] = $role;
        }
        return $data;
    }

    public function listeLogin()
    {
        $sql = "SELECT login FROM utilisateurs";
        $res = $this->base->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_OBJ);
        $res->closeCursor();

        $data = [];
        $compteur = 0;
        
        foreach($rows as $row)
        {
            $login = new Utilisateurs();
            $login->setLogin($row->login);

            $data[$compteur++] = $login;
        }
        return $data;
    }

    public function createUser(Utilisateurs $user)
    {
        $sql = "INSERT INTO utilisateurs(login, pass, role) VALUES (?, ?, ?)";
        $res = $this->base->prepare($sql);
        $insertUser = [$user->getLogin(), $user->getPass(), $user->getRole()];
        $res->execute($insertUser);
        $res->closeCursor();
        $user->setId_util($this->base->lastInsertId());
        (int)$user->getRole() === 1 ? $user->statut = 'Administrateur': $user->statut = 'Réceptionniste';

        return $user;
    }
}