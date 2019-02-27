<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../outils/connexionBD.php';
include_once '../outils/ressources_communes.php';
include_once '../outils/CellID_To_GPS.php';

 $con = connexion();
 
 if(isset($_POST['mnc']) && isset($_POST['mcc']) && isset($_POST['cid0']) && isset($_POST['lac0']) && isset($_POST['asu'])){
     if($_POST['cid0']>1){//Les donnees envoyees semblent donc valides
         
	 $mcc = $_POST['mcc'];
	 $mnc = $_POST['mnc'];
	 $lac = $_POST['lac0'];
	 $cid = $_POST['cid0'];
         $asu = $_POST['asu'];
         $number = $_POST['numero'];
         $simImei = $_POST['simImei'];
         $asu1 =0; $asu2 =0; $asu3 =0; $asu4 =0; $asu5 =0;
         $lac1 =0; $lac2 =0; $lac3 =0; $lac4 =0; $lac5 =0;
         $cid1 =0; $cid2 =0; $cid3 =0; $cid4 =0; $cid5 =0;
//         echo "dans le premier if";
         /*
          * Exploitation des donnees sur les autres cellules BTS
          */
         $typeReseau = $_POST['typeReseau'];
         
         if(isset($_POST['lac1']) && isset($_POST['cid1']) && isset($_POST['asu1'])){
             $lac1 = $_POST['lac1']; $cid1 = $_POST['cid1']; $asu1 = $_POST['asu1'];
         }
         if(isset($_POST['lac2']) && isset($_POST['cid2']) && isset($_POST['asu2'])){
             $lac2 = $_POST['lac2']; $cid2 = $_POST['cid2']; $asu2 = $_POST['asu2'];
         }
         if(isset($_POST['lac3']) && isset($_POST['cid3']) && isset($_POST['asu3'])){
             $lac3 = $_POST['lac3']; $cid3 = $_POST['cid3']; $asu3 = $_POST['asu3'];
         }
         if(isset($_POST['lac4']) && isset($_POST['cid4']) && isset($_POST['asu4'])){
             $lac4 = $_POST['lac4']; $cid4 = $_POST['cid4']; $asu4 = $_POST['asu4'];
         }
         if(isset($_POST['lac5']) && isset($_POST['cid5']) && isset($_POST['asu5'])){
             $lac5 = $_POST['lac5']; $cid5 = $_POST['cid5']; $asu5 = $_POST['asu5'];
         }
         
        if($number == ""){
            $number = null;
        }
        $heure = new DateTime('now', new DateTimeZone(FUSEAU));
        $req1 = "call insertLocateCell($lac,$cid,$asu,$lac1,$cid1,$asu1,$lac2,$cid2,$asu2,"
                . " $lac3,$cid3,$asu3,$lac4,$cid4,$asu4,$lac5,$cid5,$asu5,$mnc,$mcc,$simImei,$number,'$heure')";
        $resultat = $con ->query($req1);
//        echo "$req1";
        
     }
 }
//  echo "fin";
  $con ->close();
