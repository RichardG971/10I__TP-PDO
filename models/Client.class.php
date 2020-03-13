<?php
class Client
{
    private $numClient;
    private $nom;
    private $prenom;
    private $tel;
    private $adresse;

    public function getAdresse() {
        return $this->adresse;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function getTel() {
        return $this->tel;
    }

    public function setTel($tel) {
        $this->tel = $tel;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getNumClient() {
        return $this->numClient;
    }

    public function setNumClient($numClient) {
        $this->numClient = $numClient;
    }
}