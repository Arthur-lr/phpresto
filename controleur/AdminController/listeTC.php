<?php

use modele\dao\Bdd;
use modele\dao\TypeCuisineDAO;
use modele\dao\UtilisateurDAO;

/**
 * Contrôleur listeRestos
 * Gère l'affichage de la liste de tous les restaurants
 * 
 * @version 09/2021 par NC
 */
Bdd::connecter();

// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"./?action=recherche&critere=nom","label"=>"Recherche par nom");
$menuBurger[] = Array("url"=>"./?action=recherche&critere=adresse","label"=>"Recherche par adresse");
$menuBurger[] = Array("url"=>"./?action=recherche&critere=type","label"=>"Recherche par type de cuisine");
$menuBurger[] = Array("url"=>"./?action=recherche&critere=multi","label"=>"Recherche multicritère");

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 

$listeTC = TypeCuisineDAO::getAll();


if (isset($_SESSION["mailU"])){                   
        if ($_SESSION["mailU"] == "test@bts.sio"){
            
            
            include_once "$racine/vue/vueAdmin/entete_admin.html.php"; 
            include_once "$racine/vue/vueAdmin/vue_listeTC.php";
            include_once "$racine/vue/pied.html.php";
            
        }else{
            
            include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
            
            
    }       
    }else{
        include_once "$racine/vue/entete.html.php";
        include_once "$racine/vue/vueAccueil.php";            
            echo 'Page inaccessible';
    }
    


