<?php
class CompteBancaire {
    private $id;
    private $numeroCompte;
    private $solde;
    private $proprietaire;

    public function __construct($numeroCompte, $solde, $proprietaire) {
        $this->numeroCompte = $numeroCompte;
        $this->solde = $solde;
        $this->proprietaire = $proprietaire;
    }

    public function getId() {
        return $this->id;
    }

    public function getNumeroCompte() {
        return $this->numeroCompte;
    }

    public function getSolde() {
        return $this->solde;
    }

    public function getProprietaire() {
        return $this->proprietaire;
    }

    public function setSolde($nouveauSolde) {
        $this->solde = $nouveauSolde;
    }
}
?>
