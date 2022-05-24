<?php

use modele\dao\Bdd;
use modele\dao\TypeCuisineDAO;
use modele\dao\UtilisateurDAO;

Bdd::connecter();

if (!isset($_GET["idTC"])) {
    
    // Pb : pas d'id de restaurant
    ajouterMessage("Supprimer critique : il faut fournir un identifiant de restaurant");
    $titre = "erreur";
    require_once "$racine/vue/vueAdmine/entete.admin.html.php";
    require_once "$racine/vue/pied.html.php";
    
}else {
    
    $idTC = $_GET["idTC"];
    $titre = "ça marche";
    
    TypeCuisineDAO::suppressionParId($idTC);
    
    header('Location: ./?action=listeTC');
    
    
        
    }
