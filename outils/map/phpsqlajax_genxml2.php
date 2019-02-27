<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../connexionBD.php';
include_once '../triangulation.php';
$ID = $_GET['IDPHONE'];

    function parseToXML($htmlStr) { 
        $xmlStr=str_replace('<','&lt;',$htmlStr); 
        $xmlStr=str_replace('>','&gt;',$xmlStr); 
        $xmlStr=str_replace('"','&quot;',$xmlStr); 
        $xmlStr=str_replace("'",'&apos;',$xmlStr); 
        $xmlStr=str_replace("&",'&amp;',$xmlStr);
//        $xmlStr=str_replace("_",' ',$xmlStr);
        return $xmlStr; 
    } 
    
    // Opens a connection to a mySQL server
    $con = connexion();

    // Select all the rows in the markers table
    $query ='SELECT IDLOcateGPS,"BTS Principale" as "nomUser",numero,lat0 as "lat",lon0 as "lon",0 as "dis" FROM locategps join phone using(IDPhone) WHERE phone.IDPhone='.$ID.' and heure=(select max(heure) from locategps where IDPHONE='.$ID.')';
     $req = "   select IDLOcateGPS,'BTS Principale' as nomUser,numero,lat0 as 'lat', lon0 as 'lon', 0 as 'dis'  
                from locategps join phone using(IDPhone) where locategps.IDPhone=$ID 
                and heure=(select max(heure) from locategps where IDPHONE=$ID) "
             . " union "
             . " select IDLOcateGPS,'BTS Secondaire' as nomUser,numero,lat1 as 'lat', lon1 as 'lon', d1 as 'dis' 
                from locategps join phone using(IDPhone)  where locategps.IDPhone=$ID 
                and heure=(select max(heure) from locategps where IDPHONE=$ID)"
             . " union "
             . " select IDLOcateGPS,'Troisieme BTS' as nomUser,numero,lat2 as 'lat', lon2 as 'lon', d2 as 'dis'  
                from locategps join phone using(IDPhone)  where locategps.IDPhone=$ID 
                and heure=(select max(heure) from locategps where IDPHONE=$ID)"
             . " union "
             . " select IDLOcateGPS,'Quatrieme BTS' as nomUser,numero,lat3 as 'lat', lon3 as 'lon', d3 as 'dis'  
                from locategps join phone using(IDPhone)  where locategps.IDPhone=$ID 
                and heure=(select max(heure) from locategps where IDPHONE=$ID)"
             . " union "
             . " select IDLOcateGPS,'Cinquieme BTS' as nomUser,numero,lat4 as 'lat', lon4 as 'lon', d4 as 'dis'  
                from locategps join phone using(IDPhone)  where locategps.IDPhone=$ID 
                and heure=(select max(heure) from locategps where IDPHONE=$ID)"
             . " union "
             . " select IDLOcateGPS,'Sixieme BTS' as nomUser,numero,lat5 as 'lat', lon5 as 'lon', d5 as 'dis'  
                from locategps join phone using(IDPhone)  where locategps.IDPhone=$ID 
                and heure=(select max(heure) from locategps where IDPHONE=$ID) "
             . " union "
             . " select IDLOcateGPS,'Septieme BTS' as nomUser,numero,lat6 as 'lat', lon6 as 'lon', d6 as 'dis'  
                from locategps join phone using(IDPhone)  where locategps.IDPhone=$ID 
                and heure=(select max(heure) from locategps where IDPHONE=$ID)";        
//            echo " $req<br>";
    $result = $con ->query($req);
    if (!$result) {
      die('Invalid query: ' . mysql_error());
    }

    header("Content-type: text/xml");

    // Start XML file, echo parent node

    echo '<markers>';

    // Iterate through the rows, printing XML nodes for each
    $nbrePoint = 0;
    while ($row = $result->fetch_object()){
      if($row ->lat !=null || !empty($row ->lat)){
          // ADD TO XML DOCUMENT NODE
          $name = $row->nomUser;
          echo '<marker ';
          echo 'name="' . $name. '" ';
          //echo 'address="' . parseToXML($row['address']) . '" ';
          echo 'lat="' . $row->lat . '" ';
          echo 'lng="' . $row->lon . '" ';
          echo 'dis="' . $row->dis . '" ';
          //echo 'type="' . $row['type'] . '" ';
          if($name == "BTS Principale"){
              $lati1 = $row->lat;
              $lngi1 = $row->lon;
              $IDLocateGPS = $row -> IDLOcateGPS;
          }
          echo '/>';
          $nbrePoint++;
      }
    }
    list ($tabAsu, $tabLat, $tabLon) = getValeurForTriangulation($ID,"now",0);
    if(count($tabAsu) > 2){
    //On a au moins 3 cellule pour trianguler
        list($latPhone,$lonPhone) = getPointIntersectionFullTriangulation($tabAsu, $tabLat, $tabLon) ;
        //on obtient la distance de la BTS Principale au telephone
        $dis = get_distance_m($lati1, $lngi1, $latPhone, $lonPhone);
        $con ->query("update locategps set latPhone=$latPhone, lonPhone=$lonPhone,dPhone=$dis where IDLocateGPS=$IDLocateGPS");
        
        /*
         * position du mobile trianguler
         */
        $req = "select concat_ws('  ',coalesce(nomUser,''),date_format(heure,'%d/%m/%Y %H:%i:%s')) AS 'Etiquette' FROM locategps join phone using(IDPhone) WHERE phone.IDPhone=$ID and heure=(select max(heure) from locategps where IDPHONE=$ID)";
        $result = $con ->query($req);
        $ligne = $result -> fetch_object();
    //    $name = $ligne -> Etiquette.' à '.$dis.' mètres de BTS_P';
        echo '<mobile ';
        echo 'name=" '.$ligne -> Etiquette.'" ';
        //echo 'address="' . parseToXML($row['address']) . '" ';
        echo 'lat="' . $latPhone . '" ';
        echo 'lng="' . $lonPhone . '" ';
        echo 'dis="' . ceil($dis) . '" ';
        //echo 'type="' . $row['type'] . '" ';
        echo '/>';

     }
    // End XML file
    echo '</markers>';
    
    $con->close();
    
