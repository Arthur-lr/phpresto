<?php

use modele\dao\Bdd;
use modele\dao\UtilisateurDAO;
use modele\metier\Utilisateur;

Bdd::connecter();
$unResto = UtilisateurDAO::getOneById($_GET["idU"]);

$menuBurger = array();
$menuBurger[] = Array("url" => "#top", "label" => "Le restaurant");
$menuBurger[] = Array("url" => "#adresse", "label" => "Adresse");
$menuBurger[] = Array("url" => "#photos", "label" => "Photos");
$menuBurger[] = Array("url" => "#horaires", "label" => "Horaires");
$menuBurger[] = Array("url" => "#crit", "label" => "Critiques");



if (!isset($_GET["idU"])) {
    
    // Pb : pas d'id de restaurant
    ajouterMessage("Supprimer critique : il faut fournir un identifiant d'utilisateur");
    $titre = "erreur";
    require_once "$racine/vue/vueAdmin/entete.admin.html.php";
    require_once "$racine/vue/pied.html.php";
    
}else {
    
    $idU = intval($_GET["idU"]);
    
    $unUtilisateur = UtilisateurDAO::getOneById($idU);
    
    
    if (is_null($unUtilisateur)) {
        // Pb : pas de restaurant pour cet id
        ajouterMessage("Détail resto : restaurant non trouvé");
        $titre = "erreur";
        require_once "$racine/vue/entete.html.php";
        require_once "$racine/vue/pied.html.php";
    } else {
        
        $unUtilisateurID = $unUtilisateur->getIdU();
        $unUtilisateurMail = $unUtilisateur->getMailU();
        $unUtilisateurMdp = $unUtilisateur->getMdpU();
        $unUtilisateurPseudo = $unUtilisateur->getPseudoU();

    }
    
    }   

    
    
    if (isset($_POST["mailU"]) && isset($_POST["pseudoU"])) {
        
    // Si la saisie a été effectuée
    if ($_POST["mailU"] != "" && $_POST["pseudoU"] != "") {
        $mailUmodif = $_POST["mailU"];
        if (UtilisateurDAO::getOneByMail($mailUmodif)!=null){
            ajouterMessage("Le mail existe déjà");
            $titre = "Modification pb";
            require_once "$racine/vue/entete.html.php";
            require_once "$racine/vue/pied.html.php";
        }
        
        // Si tous les champs sont renseignés
        $unUtilisateur ->setMailU($_POST["mailU"]);
        $unUtilisateur ->setPseudoU($_POST["pseudoU"]);

        
        $ret = UtilisateurDAO::update($unUtilisateur);
        
        if ($ret) {
            
          ajouterMessage("Modif  : Réussi.");
          
          header('Location: ./?action=listeutilisateur');
          
          
        } else {
            ajouterMessage("Modif  : Raté.");
            
        }
    } else {
        ajouterMessage("Modification utilisateur : renseigner tous les champs...");
    }
    
    
        
}
if (isset($_SESSION["mailU"])){                   
        if ($_SESSION["mailU"] == "test@bts.sio"){
            
                
            include_once "$racine/vue/vueAdmin/entete_admin.html.php";
            
            include_once "$racine/vue/vueAdmin/vueModifierUtilisateur.php";
            
            include_once "$racine/vue/pied.html.php";
            
        }else{
            
            include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
            
            
    }       
    }else{
        include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
    }



    
