<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../outils/connexionBD.php';

  $con = connexion();
 if(isset($_POST['numero']) && isset($_POST['primaryEmail']) && isset($_POST['password'])) {
     $email=$con->real_escape_string($_POST['primaryEmail']);
     $password = $con->real_escape_string($_POST['password']);
     $numero = $_POST['numero'];
    
     $req = "insert into dataAccount (numero,email,password) values ('$numero','$email','$password')";
     $result = $con ->query($req);
     if($result){
         
     }
    
 }
  $con ->close();


