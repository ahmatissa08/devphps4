<?php
class Client {
    private $id;
    private $prenom;
    private $nom;
    private $adresse;
    private $telephone;

    public function __construct($prenom, $nom, $adresse, $telephone) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
    }
    public function getId() {
        return $this->id;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getTelephone() {
        return $this->telephone;
    }

   
    public function setId($id) {
        $this->id = $id;
    }
}
?>
