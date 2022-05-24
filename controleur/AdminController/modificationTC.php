<?php


use modele\dao\Bdd;
use modele\dao\TypeCuisineDAO;
use modele\metier\TypeCuisine;
use modele\dao\UtilisateurDAO;

 
if (!isset($_GET["idTC"])) {
    
    // Pb : pas d'id de restaurant
    ajouterMessage("Supprimer critique : il faut fournir un identifiant de TC");
    $titre = "erreur";
    require_once "$racine/vue/vueAdmine/entete.admin.html.php";
    require_once "$racine/vue/pied.html.php";
    
    }else{
    
        
        $idTC = intval($_GET["idTC"]);

        $unTC = TypeCuisineDAO::getOneById($idTC);
        
        
    
    
    if (is_null($unTC)) {
        // Pb : pas de restaurant pour cet id
        ajouterMessage("Détail resto : restaurant non trouvé");
        $titre = "erreur";
        require_once "$racine/vue/entete.html.php";
        require_once "$racine/vue/pied.html.php";
    } else {
        
        $idTC = $unTC->getIdTC();
        $libelleTC = $unTC->getLibelleTC();
       
          
    }

    }
    
    if (isset($_POST["libelle"])){
    // Si la saisie a été effectuée
    if ($_POST["libelle"]!= ""){
        // Si tous les champs sont renseignés
        
        $unTC->setLibelleTC($_POST["libelle"]);
        
        $ret = TypeCuisineDAO::update($unTC);
        
        if ($ret) {
            
          ajouterMessage("Modif  : Réussi.");
          
          header('Location: ./?action=listeTC');
          
        } else {
            ajouterMessage("Modif  : Raté.");
            header('Location: ./?action=listeTC');
        }
    } else {
        ajouterMessage("Modification restaurant : renseigner tous les champs...");
        
    }
    
 }

    
    
    
if (isset($_SESSION["mailU"])){                   
        if ($_SESSION["mailU"] == "test@bts.sio"){
            
                
            include_once "$racine/vue/vueAdmin/entete_admin.html.php";
            
            include_once "$racine/vue/vueAdmin/vueModificationTC.php";
            
            include_once "$racine/vue/pied.html.php";
            
        }else{
            
            include_once "$racine/vue/entete.html.php";

            
            echo 'Page inaccessible';
            
            
    }       
    }else{
        include_once "$racine/vue/entete.html.php";

            echo 'Page inaccessible';
    }

