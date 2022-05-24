<?php
use modele\dao\Bdd;
use \modele\dao\UtilisateurDAO;

/**
 * Contrôleur deconnexion
 * Fin de la session authentifiée et retour à la page de connexion
 * 
 * Vue contrôlée : vueAuthentification
 * 
 */
// Récupération des données GET, POST, et SESSION
// 
// Récupération des données utilisées dans la vue 

Bdd::connecter();

$titre = "authentification";

// Fin de la ssession
logout();           

// Construction de la vue
$GLOBALS['isLoggedOn'] = false;
if (isset($_SESSION["mailU"])){                   
        if ($_SESSION["mailU"] == "test@bts.sio"){
            
            include_once"$racine/vue/vueAdmin/entete_admin.html.php";   
            
        }else{

        include_once "$racine/vue/entete.html.php";
    }       
    }else{
        include_once "$racine/vue/entete.html.php";
    }
require_once "$racine/vue/vueAuthentification.php";
require_once "$racine/vue/pied.html.php";

?>