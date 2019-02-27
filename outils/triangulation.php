<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'connexionBD.php';
require_once '../../outils/CellID_To_GPS.php';
  function coordGPSCellule($mcc, $mnc, $lac, $cid, $con){
             $req = "Select lat,lon,datediff(current_date,date_enregistrement) as 'dure' from cell_coordonnegps where mcc=$mcc and mnc=$mnc and cid=$cid and lac=$lac";
             $resultat = $con -> query($req); 
             $heure = new DateTime('now', new DateTimeZone(FUSEAU));
             $dateEnregistrement = $heure->format('Y-m-d H:i:s');
             if($resultat){
                 //aucun resultat, on fait la demande en ligne en ce moment
                 if($resultat -> num_rows == 0){
                     list ($lat,$lon/*,$raggio*/)=decodegoogle($mcc,$mnc,$lac,$cid);
                     if($lat != 0 && $lon != 0){
                         $reqI = "insert into cell_coordonnegps values (null,$mcc,$mnc, $cid, $lac, $lat, $lon,'$dateEnregistrement')";
                         $con -> query ($reqI);
                     }
                     
                 }else{
                     $ligne = $resultat -> fetch_object();
                     if($ligne -> dure > 30){
                         // c'cest perime, on doit faire a nouveau la demande en ligne
                         list ($lat,$lon/*,$raggio*/)=decodegoogle($mcc,$mnc,$lac,$cid);
                         if($lat != 0 && $lon != 0){
                            $reqU = "update cell_coordonnegps set lat=$lat, lon=$lon,date_enregistrement='$dateEnregistrement' where mcc=$mcc and mnc=$mnc and cid=$cid and lac=$lac";
                            $con -> query ($reqU);                         
                         }
                     }else{
                         $lat = $ligne -> lat;
                         $lon = $ligne -> lon;
                     }
                 }
                 return array($lat,$lon);
             }
             return null;
    }


 function getValeurForTriangulation($IDPHONE,$temps, $IDLocateGps){
     $tempsReel = "   select lat0 as lat, lon0 as lon, asu0 as asu  
                from locategps  where locategps.IDPhone=$IDPHONE 
                and heure=(select max(heure) from locategps where IDPHONE=$IDPHONE) "
             . " union "
             . " select lat1 as lat, lon1 as lon, asu1 as asu  
                from locategps  where locategps.IDPhone=$IDPHONE 
                and heure=(select max(heure) from locategps where IDPHONE=$IDPHONE)"
             . " union "
             . " select lat2 as lat, lon2 as lon, asu2 as asu  
                from locategps  where locategps.IDPhone=$IDPHONE 
                and heure=(select max(heure) from locategps where IDPHONE=$IDPHONE)"
             . " union "
             . " select lat3 as lat, lon3 as lon, asu3 as asu  
                from locategps  where locategps.IDPhone=$IDPHONE 
                and heure=(select max(heure) from locategps where IDPHONE=$IDPHONE)"
             . " union "
             . " select lat4 as lat, lon4 as lon, asu4 as asu  
                from locategps  where locategps.IDPhone=$IDPHONE 
                and heure=(select max(heure) from locategps where IDPHONE=$IDPHONE)"
             . " union "
             . " select lat5 as lat, lon5 as lon, asu5 as asu  
                from locategps  where locategps.IDPhone=$IDPHONE 
                and heure=(select max(heure) from locategps where IDPHONE=$IDPHONE) "
             . " union "
             . " select lat6 as lat, lon6 as lon, asu6 as asu  
                from locategps  where locategps.IDPhone=$IDPHONE 
                and heure=(select max(heure) from locategps where IDPHONE=$IDPHONE)";
     $antidate = "   select lat0 as lat, lon0 as lon, asu0 as asu from locategps  where IDLocateGPS=$IDLocateGps "
             . " union "
             . " select lat1 as lat, lon1 as lon, asu1 as asu from locategps  where  IDLocateGPS=$IDLocateGps "
             . " union "
             . " select lat2 as lat, lon2 as lon, asu2 as asu from locategps  where  IDLocateGPS=$IDLocateGps "
             . " union "
             . " select lat3 as lat, lon3 as lon, asu3 as asu from locategps  where IDLocateGPS=$IDLocateGps "
             . " union "
             . " select lat4 as lat, lon4 as lon, asu4 as asu from locategps  where IDLocateGPS=$IDLocateGps "
             . " union "
             . " select lat5 as lat, lon5 as lon, asu5 as asu from locategps  where IDLocateGPS=$IDLocateGps  "
             . " union "
             . " select lat6 as lat, lon6 as lon, asu6 as asu from locategps  where IDLocateGPS=$IDLocateGps ";
     
     $con = connexion();
     // "now" veut dire qu'on consulte la derniere position, sinon c'est une demande d'historique
     $result = ($temps == "now")? $con ->query($tempsReel):$con ->query($antidate);
     $tabAsu = array(); $tabLat = array(); $tabLon = array(); $i = 0;
     if($result && $result->num_rows>2){
         while($ligne = $result->fetch_object()){
             $tabAsu[$i] = $ligne -> asu;
             $tabLat[$i] = $ligne -> lat;
             $tabLon[$i] = $ligne -> lon;
             $i++;
         }
         
     }
     $con ->close();
     return array($tabAsu, $tabLat, $tabLon);
 }
 function getPointIntersection($lat0, $lat1, $lat2, $lon0, $lon1, $lon2, $asu0, $asu1, $asu2){
     $poid0 = $asu0/($asu0+$asu1+$asu2);
     $poid1 = $asu1/($asu0+$asu1+$asu2);
     $poid2 = $asu2/($asu0+$asu1+$asu2);
     
     $lat = $poid0*$lat0 + $poid1*$lat1 + $poid2*$lat2;
     $lon = $poid0*$lon0 + $poid1*$lon1 + $poid2*$lon2;
     return array($lat,$lon);
 }
 
 function getPointIntersectionFullTriangulation($tabAsu, $tabLat, $tabLon){
     if(count($tabAsu) > 2){//Au moins 3 cellules pour la triangulation
         $sommePoid = 0; $lat = 0; $lon = 0;
         //modification des forces du signal
//         $tabAsu[1] = ceil($tabAsu[0] * 2 / 3);
//         $tabAsu[2] = ceil($tabAsu[0] * 1 / 3);
         foreach($tabAsu as $asu){
             $sommePoid += $asu;
         }
         for($i = 0; $i < count($tabAsu); $i++){
             $lat += ($tabAsu[$i] / $sommePoid) * $tabLat[$i];
         }
         
         for($i = 0; $i < count($tabAsu); $i++){
             $lon += ($tabAsu[$i] / $sommePoid) * $tabLon[$i];
         }
         return array($lat,$lon); 
     }
     
 }
 function get_distance_m($lat1, $lng1, $lat2, $lng2) {
        $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
        $rlo1 = deg2rad($lng1);
        $rla1 = deg2rad($lat1);
        $rlo2 = deg2rad($lng2);
        $rla2 = deg2rad($lat2);
        $dlo = ($rlo2 - $rlo1) / 2;
        $dla = ($rla2 - $rla1) / 2;
        $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
        $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return ($earth_radius * $d);
}

