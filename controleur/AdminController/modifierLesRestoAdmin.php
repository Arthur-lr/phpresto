<?php
use modele\dao\Bdd;
use modele\dao\RestoDAO;
use modele\dao\UtilisateurDAO;

Bdd::connecter();
$listeRestos =  RestoDAO::getAll();

if (isset($_SESSION["mailU"])){                   
        if ($_SESSION["mailU"] == "test@bts.sio"){
            
                
            include_once "$racine/vue/vueAdmin/entete_admin.html.php"; 
            
            include_once "$racine/vue/vueAdmin/modifier_resto_admin.html.php"; 
       
            include_once "$racine/vue/pied.html.php";
            
        }else{
            
            include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
            
            
    }       
    }else{
        include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
    }

    
