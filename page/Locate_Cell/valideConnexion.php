<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../../outils/connexionBD.php';
if(isset($_POST['log']) && isset($_POST['mdp'])){
    $NB = 0;
    $con = connexion();
    $req = "Select nom,fonction,count(*) as NB from userauth where login=? and mdp=?";
    $pre = $con ->prepare($req);
    $log = $con->real_escape_string($_POST['log']);
    $mdp = $con->real_escape_string($_POST['mdp']);
    $pre ->bind_param("ss",$log,$mdp);
    $r = $pre ->execute();
    $pre ->bind_result($nom,$fonction,$NB);
    $pre ->fetch();
    if($NB > 0){        
        $_SESSION['nom'] = $nom;
        $_SESSION['fonction'] = $fonction; 
        $con ->close();
        header('location:mobile-list.php');
    }else{
        $con ->close();
        header('location:connexion.php');
        echo "faux";
    
    } 
    echo "rien";
    
}
echo "vide";