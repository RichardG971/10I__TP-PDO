<?php
class Reservation
{
    private $numClient;
    private $numChambre;
    private $dateArrivee;
    private $dateDepart;
    private $prixTotal = 0;
    private $order;

    public function getDateDepart() {
        return $this->dateDepart;
    }

    public function setDateDepart($dateDepart) {
        $this->dateDepart = $dateDepart;
    }

    public function getDateArrivee() {
        return $this->dateArrivee;
    }

    public function setDateArrivee($dateArrivee) {
        $this->dateArrivee = $dateArrivee;
    }

    public function getNumChambre() {
        return $this->numChambre;
    }

    public function setNumChambre($numChambre) {
        $this->numChambre = $numChambre;
    }

    public function getNumClient() {
        return $this->numClient;
    }

    public function setNumClient($numClient) {
        $this->numClient = $numClient;
    }

    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }
}