<?php

use modele\dao\Bdd;
use modele\dao\RestoDAO;
use modele\metier\Resto;
use modele\dao\UtilisateurDAO;

Bdd::connecter();
$unResto = RestoDAO::getOneById($_GET["idR"]);

$menuBurger = array();
$menuBurger[] = Array("url" => "#top", "label" => "Le restaurant");
$menuBurger[] = Array("url" => "#adresse", "label" => "Adresse");
$menuBurger[] = Array("url" => "#photos", "label" => "Photos");
$menuBurger[] = Array("url" => "#horaires", "label" => "Horaires");
$menuBurger[] = Array("url" => "#crit", "label" => "Critiques");



if (!isset($_GET["idR"])) {
    
    // Pb : pas d'id de restaurant
    ajouterMessage("Supprimer critique : il faut fournir un identifiant de restaurant");
    $titre = "erreur";
    require_once "$racine/vue/vueAdmine/entete.admin.html.php";
    require_once "$racine/vue/pied.html.php";
    
}else {
    
    $titre = "ça marche";
    $idR = intval($_GET["idR"]);
    
    $unResto = RestoDAO::getOneById($idR);
    
    
    if (is_null($unResto)) {
        // Pb : pas de restaurant pour cet id
        ajouterMessage("Détail resto : restaurant non trouvé");
        $titre = "erreur";
        require_once "$racine/vue/entete.html.php";
        require_once "$racine/vue/pied.html.php";
    } else {
        
        $idResto = $unResto->getIdR();
        $NomResto = $unResto->getNomR();
        $numAdrResto = $unResto->getNumAdr();
        $voieAdrResto= $unResto->getVoieAdr();
        $villeResto = $unResto->getVilleR();
        $NomCPReso = $unResto->getCpR();
          
    }

    }
    
    if (isset($_POST["NomR"]) && isset($_POST["numVoieAdrR"]) && isset($_POST["voieAdrR"]) && isset($_POST["VilleR"]) && isset($_POST["cprR"])) {
    // Si la saisie a été effectuée
    if ($_POST["NomR"] != "" && $_POST["numVoieAdrR"] != "" && $_POST["voieAdrR"] != "" && $_POST["VilleR"] != "" && $_POST["cprR"] != "") {
        // Si tous les champs sont renseignés
        $unResto ->setNomR($_POST["NomR"]);
        $unResto ->setNumAdr($_POST["numVoieAdrR"]);
        $unResto ->setVoieAdr($_POST["voieAdrR"]);
        $unResto ->setVilleR($_POST["VilleR"]);
        $unResto ->setCpR($_POST["cprR"]);
    
        $ret = RestoDAO::update($unResto);
        
        if ($ret) {
            
          ajouterMessage("Modif  : Réussi.");
          
          header('Location: ./?action=modifierlesrestoadmin');
          
        } else {
            ajouterMessage("Modif  : Raté.");
        }
    } else {
        ajouterMessage("Modification restaurant : renseigner tous les champs...");
    }
    
    
        
}

if (isset($_SESSION["mailU"])){                   
        if ($_SESSION["mailU"] == "test@bts.sio"){
            
                
            include_once "$racine/vue/vueAdmin/entete_admin.html.php";
            
            include_once "$racine/vue/vueAdmin/vueModifierUnResto.php";

            include_once "$racine/vue/pied.html.php";
            
        }else{
            
            include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
            
            
    }       
    }else{
        include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
    }

    

    
