<?php

use modele\dao\Bdd;
use modele\dao\RestoDAO;
use modele\metier\Resto;
use modele\dao\UtilisateurDAO;

 

if (isset($_POST["NomR"]) && isset($_POST["numVoieAdrR"]) && isset($_POST["voieAdrR"]) && isset($_POST["VilleR"]) && isset($_POST["cprR"]) && isset($_POST["descR"])) {
    // Si la saisie a été effectuée
if ($_POST["NomR"] != "" && $_POST["numVoieAdrR"] != "" && $_POST["voieAdrR"] != "" && $_POST["VilleR"] != "" && $_POST["cprR"] != "" && $_POST["descR"] !="") {
  
    $NomResto = $_POST["NomR"];
    $numVoieAdrResto = $_POST["numVoieAdrR"];
    $voieAdrResto = $_POST["voieAdrR"];
    $VilleResto = $_POST["VilleR"];
    $cpResto = $_POST["cprR"];
    $descResto = $_POST["descR"];
    
    $unResto = new Resto (0,$NomResto,$numVoieAdrResto,$voieAdrResto,$cpResto,$VilleResto,null,null,$descResto,null);
    

    $ret = RestoDAO::insert($unResto);
    
    if ($ret) {
            
          ajouterMessage("Ajout  : Réussi.");
          header('Location: ./?action=modifierlesrestoadmin');
          
          
          
        } else {
            ajouterMessage("Ajout  : Raté.");
        
        }
    } else {
        
        ajouterMessage("Ajout raté : renseigner tous les champs...");

    }
    
    
        
}
if (isset($_SESSION["mailU"])){                   
        if ($_SESSION["mailU"] == "test@bts.sio"){
            
            include_once "$racine/vue/vueAdmin/entete_admin.html.php"; 
            include_once "$racine/vue/vueAdmin/vueAjoutRestaurant.php";
            
        }else{
            
            include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
            
            
    }       
    }else{
        include_once "$racine/vue/entete.html.php";
            
            echo 'Page inaccessible';
    }
    
