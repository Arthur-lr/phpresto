<?php
/**
 * Fournit le nom du contrôleur principal en fonction de l'action choisie
 * @param string $action libellé de l'action, valeur du paramètre GET "action" de l'URL
 * @return string nom du fichier PHP de la couche contrôleur correspondant à l'action
 */
require_once "$racine/includes/gestionErreurs.inc.php"; 

function controleurPrincipal(string $action) : string {
    $lesActions = array();
    $lesActions["defaut"] = "accueil.php";
    $lesActions["accueil"] = "accueil.php";
    $lesActions["cgu"] = "cgu.php";
    $lesActions["liste"] = "listeRestos.php";
    $lesActions["detail"] = "detailResto.php";
    $lesActions["recherche"] = "rechercheResto.php";
    $lesActions["connexion"] = "connexion.php";
    $lesActions["deconnexion"] = "deconnexion.php";
    $lesActions["profil"] = "monProfil.php";
    $lesActions["updProfil"] = "updProfil.php";
    $lesActions["inscription"] = "inscription.php";
    $lesActions["aimer"] = "aimer.php";
    $lesActions["noter"] = "noter.php";
    $lesActions["commenter"] = "commenter.php";
    $lesActions["supprimerCritique"] = "supprimerCritique.php";
    $lesActions["administration"] = "AdminController/administration.php";
    $lesActions["modifierlesrestoadmin"] = "AdminController/modifierLesRestoAdmin.php";
    $lesActions["supprimerResto"] = "AdminController/supprimerResto.php";
    $lesActions["modifierunrestoadmin"] = "AdminController/modifierUnResto.php";
    $lesActions["ajoutrestaurant"] = "AdminController/ajoutDeRestaurant.php";
    $lesActions["listeutilisateur"] = "AdminController/listeUtilisateur.php";
    $lesActions["supprimerutilisateur"] = "AdminController/supprimerUtilisateur.php";
    $lesActions["modifierutilisateur"] = "AdminController/modifierUtilisateur.php";
    $lesActions["listeTC"] = "AdminController/listeTC.php";
    $lesActions["supprimerTC"] = "AdminController/supprimerTC.php";
    $lesActions["ajoutTC"] = "AdminController/ajouterTC.php";
    $lesActions["modificationTC"] = "AdminController/modificationTC.php";
    
    
    
    
    if (array_key_exists ( $action , $lesActions )){
        return $lesActions[$action];
    }
    else{
        ajouterMessage("la page demandée n'existe pas");
        return $lesActions["defaut"];
    }

}

