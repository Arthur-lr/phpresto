<?php

namespace modele\dao;

use modele\metier\Utilisateur;
use modele\metier\Resto;
use modele\dao\RestoDAO;
use modele\dao\TypeCuisineDAO;
use modele\dao\Bdd;
use PDO;
use PDOException;
use Exception;

/**
 * Description of UtilisateurDAO
 * N.B. : chargement de type "lazy" pour casser le cycle 
 * "un utilisateur aime des restaurants, un restaurant collectionne des critiques, une critique est émise par un utilisateur, "
 * Donc, pour chaque restaurant, on ne chargera pas les critiques, les photos ni les types de cuisine proposés
 * @author N. Bourgeois
 * @version 07/2021
 */
class UtilisateurDAO {

    /**
     * Retourne un objet Utilisateur d'après son email
     * @param string $mailU mail de l'utilisateur recherché
     * @return Utilisateur l'objet Utilisateur recherché ou null
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getOneByMail(string $mailU): ?Utilisateur {
        $leUser = null;
        try {
            $requete = "SELECT * FROM utilisateur WHERE mailU  = ?";
            $stmt = Bdd::connecter()->prepare($requete);
            $stmt->bindParam(1, $mailU);
            $stmt->execute();
            
            // Si au moins un (et un seul) utilisateur (car login est unique), c'est que le mail existe dans la BDD
            if ($stmt->rowCount() > 0) {
                $enreg = $stmt->fetch(PDO::FETCH_ASSOC);
                $idU = $enreg['idU'];
                $lesRestosAimes = RestoDAO::getAimesByIdU($idU);
                $lesTcPref = TypeCuisineDAO::getAllPreferesByIdU($idU);
                $leUser = new Utilisateur($idU, $enreg['mailU'], $enreg['mdpU'], $enreg['pseudoU']);
                $leUser->setLesTypesCuisinePreferes($lesTcPref);
                $leUser->setLesRestosAimes($lesRestosAimes);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getOneByMail : <br/>" . $e->getMessage());
        }
        return $leUser;
    }

    /**
     * Retourne un objet Utilisateur d'après son identifiant
     * @param int $idU identifiant de l'utilisateur recherché
     * @return Utilisateur l'objet Utilisateur recherché ou null
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getOneById(int $idU): ?Utilisateur {
        $leUser = null;
        try {
            $requete = "SELECT * FROM utilisateur WHERE idU = :idU";
            $stmt = Bdd::connecter()->prepare($requete);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok && $stmt->rowCount() > 0) {
                $enreg = $stmt->fetch(PDO::FETCH_ASSOC);
                $lesRestosAimes = RestoDAO::getAimesByIdU($idU);
                $lesTcPref = TypeCuisineDAO::getAllPreferesByIdU($idU);
                $leUser = new Utilisateur($idU, $enreg['mailU'], $enreg['mdpU'], $enreg['pseudoU']);
                $leUser->setLesTypesCuisinePreferes($lesTcPref);
                $leUser->setLesRestosAimes($lesRestosAimes);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getOneById : <br/>" . $e->getMessage());
//            throw new Exception("Erreur dans la méthode " . get_called_class() );
        }
        return $leUser;
    }

    /**
     * Ajouter un enregistrement à la table utilisateur d'après un objet Utilisateur
     * N.B. : l'identifiant utilisateur est autoincrémenté
     * Le mot de passe n'est pas enregistré (traitement à part pour maîtriser le hachage)
     * @param Utilisateur $unUser
     * @return bool true si l'opération réussit, false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function insert(Utilisateur $unUser): bool {
        $ok = false;
        try {
            $requete = "INSERT INTO utilisateur (mailU, pseudoU) VALUES (:mailU,:pseudoU)";
            $stmt = Bdd::getConnexion()->prepare($requete);
//            $mdpUCrypt = crypt($unUser->getMdpU(), "sel");
            $stmt->bindValue(':mailU', $unUser->getMailU(), PDO::PARAM_STR);
//            $stmt->bindValue(':mdpU', $mdpUCrypt, PDO::PARAM_STR);
            $stmt->bindValue(':pseudoU', $unUser->getPseudoU(), PDO::PARAM_STR);
            $ok = $stmt->execute();
            
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::insert : <br/>" . $e->getMessage());
        }
        return $ok;
    }

    /**
     * Mettre à jour un enregistrement à la table utilisateur d'après un objet Utilisateur
     * Le mot de passe n'est pas enregistré (traitement à part pour maîtriser le hachage)
     * @param Utilisateur $unUser utilisateur contenant les données à mettre à jour
     * @return bool true si l'opération réussit, false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function update(Utilisateur $unUser): bool {
        $ok = false;
        try {
        $requete = "UPDATE utilisateur SET mailU = :mailU, pseudoU = :pseudoU WHERE idU = :idU";
        $stmt = Bdd::getConnexion()->prepare($requete);
//        $mdpUCrypt = crypt($unUser->getMdpU(), "sel");
        $stmt->bindValue(':mailU', $unUser->getMailU());
//        $stmt->bindValue(':mdpU', $mdpUCrypt, PDO::PARAM_STR);
        $stmt->bindValue(':pseudoU', $unUser->getPseudoU());
        $stmt->bindValue(':idU', $unUser->getIdU(), PDO::PARAM_INT);
        $ok = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::update : <br/>" . $e->getMessage());
        }
        return $ok;
    }
    
    /**
     * Mettre à jour le mot de passe d'un enregistrement à la table utilisateur
     * @param int $idU identifiant de l'utilisateur à mettre à jour
     * @param string $mdpClair nouveau mot de passe non chiffré
     * @return bool true si l'opération réussit, false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function updateMdp(int $idU, string $mdpClair): bool {
        $ok = false;
        try {
        $requete = "UPDATE utilisateur SET mdpU = :mdpU WHERE idU = :idU";
        $stmt = Bdd::getConnexion()->prepare($requete);
        $mdpUCrypt = password_hash($mdpClair, PASSWORD_DEFAULT);
        $stmt->bindValue(':mdpU', $mdpUCrypt, PDO::PARAM_STR);
        $stmt->bindValue(':idU', $idU, PDO::PARAM_INT);
        $ok = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::updateMdp : <br/>" . $e->getMessage());
        }
        return $ok;
    }



    public static function getAll(): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM utilisateur";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAll : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }
    
    private static function enregistrementVersObjet(array $enreg): Utilisateur {
        $id = $enreg['idU'];
        // Instanciation sans les associations
        $leUtilisateur = new Utilisateur(
                $enreg['idU'], $enreg['mailU'], $enreg['mdpU'], $enreg['pseudoU']
        );

        return $leUtilisateur;
    }
    
    public static function suppressionParId(int $idU): bool {
        $resultat = false;
        try {
            
            $requete = "DELETE FROM aimer WHERE idU  = ?;"
                    . "DELETE FROM critiquer WHERE idU  = ?;"
                    . "DELETE FROM utilisateur WHERE idU  = ?;";
            
            
        $stmt = Bdd::getConnexion()->prepare($requete);
        $stmt->bindParam(1, $idU, PDO::PARAM_INT);
        $stmt->bindParam(2, $idU, PDO::PARAM_INT);
        $stmt->bindParam(3, $idU, PDO::PARAM_INT);

        
        $resultat = $stmt->execute();
        
        

      } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAimesByIdU : <br/>" . $e->getMessage());
        }
        
        return $resultat;
    }
    
    
    
}
