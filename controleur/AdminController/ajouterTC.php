<?php

use modele\dao\Bdd;
use modele\dao\TypeCuisineDAO;
use modele\metier\TypeCuisine;
use modele\dao\UtilisateurDAO;

 

if (isset($_POST["libelle"])) {
    // Si la saisie a été effectuée
if ($_POST["libelle"] != "") {
    

    
    $libelleTC = $_POST["libelle"];
    
    $unTypeCuisine = new TypeCuisine (0,$libelleTC);
    

    $ret = TypeCuisineDAO::addTypeCuisine($unTypeCuisine->getLibelleTC());
    
    if ($ret) {
            
          ajouterMessage("Ajout  : Réussi.");
          header('Location: ./?action=listeTC');
          
          
          
        } else {
            ajouterMessage("Ajout : Raté.");
            
        header('Location: ./?action=listeTC');
        }
    } else {
        
        ajouterMessage("Ajout raté : renseigner tous les champs...");
        
        header('Location: ./?action=listeTC');
    }
    
    
        
}

if (isset($_SESSION["mailU"])){                   
        if ($_SESSION["mailU"] == "test@bts.sio"){
            
            include_once "$racine/vue/vueAdmin/entete_admin.html.php"; 
            include_once "$racine/vue/vueAdmin/vueAjoutTC.php";
            
        }else{
            
            include_once "$racine/vue/entete.html.php";
 
            
            echo 'Page inaccessible';
            
            
    }       
    }else{
        include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
    }

