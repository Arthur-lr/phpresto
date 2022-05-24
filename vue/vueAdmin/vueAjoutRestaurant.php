<?php
?>

<h1> Ajout d'un Restaurant </h1>
<form action="./?action=ajoutrestaurant" method="POST">
    
    <p> Nom du restaurant : </p>
    <input type="text" name="NomR" ><br/>
    <p> Numéro de voie  : </p>
    
    <input type="text" name="numVoieAdrR" > <br/>
    <p> Adresse : </p>
    
    <input type="text" name="voieAdrR"> <br/>
    <p> Ville : </p>
    
    <input type="text" name="VilleR" > <br/>
    <p> Code Postal : </p>
    
    <input type="text" name="cprR"> <br/>
    
    <p> description </p>
    
    <input type="text" name="descR"> <br/>
    
    
    
    
    <input type="submit" value="Ajouter" />
    
</form>