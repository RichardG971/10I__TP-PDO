<?php
class Chambre
{
    private $numChambre;
    private $prix;
    private $nbLits;
    private $nbPers;
    private $confort;
    private $image;
    private $description;

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getConfort() {
        return $this->confort;
    }

    public function setConfort($confort) {
        $this->confort = $confort;
    }

    public function getNbPers() {
        return $this->nbPers;
    }

    public function setNbPers($nbPers) {
        $this->nbPers = $nbPers;
    }

    public function getNbLits() {
        return $this->nbLits;
    }

    public function setNbLits($nbLits) {
        $this->nbLits = $nbLits;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function getNumChambre() {
        return $this->numChambre;
    }

    public function setNumChambre($numChambre) {
        $this->numChambre = $numChambre;
    }
}