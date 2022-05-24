<?php

use modele\dao\Bdd;
use modele\dao\RestoDAO;
use modele\dao\UtilisateurDAO;

Bdd::connecter();

if (!isset($_GET["idR"])) {
    
    // Pb : pas d'id de restaurant
    ajouterMessage("Supprimer critique : il faut fournir un identifiant de restaurant");
    $titre = "erreur";
    require_once "$racine/vue/vueAdmine/entete.admin.html.php";
    require_once "$racine/vue/pied.html.php";
    
}else {
    
    $idR = $_GET["idR"];
    $titre = "ça marche";
    
    RestoDAO::suppressionParId($idR);
    header('Location: ./?action=modifierlesrestoadmin');
    
        
    }
