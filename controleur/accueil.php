<?php

use modele\dao\Bdd;
use modele\dao\RestoDAO;
use modele\dao\UtilisateurDAO;

/**
 * Contrôleur accueil
 * Page d'accueil du site
 * 
 * Vue contrôlée : vueAccueil
 * 
 * @version 07/2021 par NB : intégration couche modèle objet
 */
// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url" => "./?action=recherche&critere=nom", "label" => "Recherche par nom");
$menuBurger[] = Array("url" => "./?action=recherche&critere=adresse", "label" => "Recherche par adresse");
$menuBurger[] = Array("url" => "./?action=recherche&critere=type", "label" => "Recherche par type de cuisine");
$menuBurger[] = Array("url" => "./?action=recherche&critere=multi", "label" => "Recherche multicritère");


// Récupération des données GET, POST, et SESSION
//
// Récupération des données utilisées dans la vue 
    Bdd::connecter();
    $listeRestos = RestoDAO::getTop4();
    
    $titre = "Accueil - Resto.fr";
    
   
    
if (isset($_SESSION["mailU"])){                   
        if ($_SESSION["mailU"] == "test@bts.sio"){
            
            include_once"$racine/vue/vueAdmin/entete_admin.html.php";   
            
        }else{

        include_once "$racine/vue/entete.html.php";
    }       
    }else{
        include_once "$racine/vue/entete.html.php";
        
    }
    
 
    
    
        
    // Construction de la vue
    require_once "$racine/vue/vueAccueil.php";
    require_once "$racine/vue/pied.html.php";
    
?>