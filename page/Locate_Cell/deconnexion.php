<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_unset($_SESSION['nom']);
session_unset($_SESSION['fonction']);
session_destroy();
header('location:connexion.php');
