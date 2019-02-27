<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    //Inclusion des paramètres de connexion
    include 'ressources_communes.php';
            
    function connexion(){
       //Connexion au serveur
        $connexion = new mysqli(HOST,USER,PWD,DATABASE);
        //Affichage d'un message en cas d'erreurs
        if(!$connexion)
        {
            echo "<script type=text/javascript>";
            echo "alert('Connexion Impossible à la base de donnees')</script>";
        }

        return $connexion;
    }
    
    
