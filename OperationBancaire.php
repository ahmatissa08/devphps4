<?php
class OperationBancaire {
    public static function effectuerDepot(CompteBancaire $compte, $montant) {
        $nouveauSolde = $compte->getSolde() + $montant;
        $compte->setSolde($nouveauSolde);
        self::enregistrerTransaction($compte, 'Dépôt', $montant);
    }

    public static function effectuerRetrait(CompteBancaire $compte, $montant) {
        if ($compte->getSolde() >= $montant) {
            $nouveauSolde = $compte->getSolde() - $montant;
            $compte->setSolde($nouveauSolde);
            self::enregistrerTransaction($compte, 'Retrait', -$montant);
        } else {
            echo "Solde insuffisant pour effectuer le retrait.";
        }
    }

    public static function effectuerVirement(CompteBancaire $compteSource, CompteBancaire $compteDestination, $montant) {
        if ($compteSource->getSolde() >= $montant) {
            $nouveauSoldeSource = $compteSource->getSolde() - $montant;
            $nouveauSoldeDestination = $compteDestination->getSolde() + $montant;

            $compteSource->setSolde($nouveauSoldeSource);
            $compteDestination->setSolde($nouveauSoldeDestination);

            self::enregistrerTransaction($compteSource, 'Virement sortant', -$montant);

            self::enregistrerTransaction($compteDestination, 'Virement entrant', $montant);
        } else {
            echo "Solde insuffisant pour effectuer le virement.";
        }
    }

    private static function enregistrerTransaction(CompteBancaire $compte, $description, $montant) {
    }
}
?>
