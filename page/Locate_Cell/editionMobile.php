<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../../outils/connexionBD.php';
if(isset($_POST['imeiSim']) && isset($_POST['numero']) && isset($_POST['nomUser'])){
    $con = connexion();
    $req = "update phone set numero=?, nomUser=? where imeiSim=? and IDPhone=?";
    $pre = $con ->prepare($req);
    if(!ctype_digit($_POST['numero'])){
        echo "Le num&eacute;ro de t&eacute;l&eacute;phone saisit n'est pas num&eacute;rique";
        return;
    }else if(!ctype_digit($_POST['imeiSim'])){
        echo "Le num&eacute;ro imei saisit n'est pas num&eacute;rique";
        return;
    }else if(ctype_digit($_POST['idphone'])){
        $nom = $con->real_escape_string($_POST['nomUser']);
        $num = $_POST['numero'];
        $imei = $_POST['imeiSim'];
        $ID = $_POST['idphone'];
        $pre ->bind_param("isii",$num,$nom,$imei,$ID);
        $r = $pre ->execute();
        $con -> close();       
    }

}
header("location:mobile-list.php");
    