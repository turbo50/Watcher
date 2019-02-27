<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../connexionBD.php';
include_once '../triangulation.php';
$IDPhone = $_GET['IDPHONE'];
$_SESSION['IDPHONE']=$IDPhone;

$heureDebut = $_GET['debut'].":00";
$heureF = $_GET['fin'].":00";
//echo "debut  = $heureDebut   fin = $heureF ";

$heureFin = DateTime::createFromFormat('Y/m/d H:i:s', $heureF)->format('Y-m-d H:i:s');
$heureDeb = DateTime::createFromFormat('Y/m/d H:i:s', $heureDebut)->format('Y-m-d H:i:s');

//echo date('d/M/Y H:i:s', $date);
//
//$heureDeb = $heureDeb_->format('Y-m-d H:i:s');
//$heureFin = $heureFin_->format('Y-m-d H:i:s');
//echo "debut  = $heureDeb   fin = $heureFin ";

    function parseToXML($htmlStr) { 
        $xmlStr=str_replace('<','&lt;',$htmlStr); 
        $xmlStr=str_replace('>','&gt;',$xmlStr); 
        $xmlStr=str_replace('"','&quot;',$xmlStr); 
        $xmlStr=str_replace("'",'&apos;',$xmlStr); 
        $xmlStr=str_replace("&",'&amp;',$xmlStr);
//        $xmlStr=str_replace("_",' ',$xmlStr);
        return $xmlStr; 
    } 
    
    //Dans un premier temps, on cherche des tuples de locatecell qui ne sont pas encore dans locategps
    $con = connexion();
    $reqListeCell = "select idlocatecell,cid0, cid1, cid2,cid3,cid4,cid5,cid6, lac0, lac1, lac2,lac3,"
        ." lac4,lac5,lac6, asu0, asu1, asu2,asu3,asu4,asu5,asu6,mnc,mcc,heure from locateCell " 
       ." where idlocatecell not in (select IDLocateCell from locategps) and IDPhone=$IDPhone and"
        . " heure between '$heureDeb' and '$heureFin' group by cid0,cid1,cid2 order by heure ";
//    echo "          premiere req = $reqListeCell          ";
    $resultat = $con -> query($reqListeCell);
    if($resultat && $resultat -> num_rows > 0){
        //Dans ce cas il a des lignes dont ils faut fournir les coordonnes GPS
        while($ligne = $resultat -> fetch_object()){
                $d1=0;$d2=$d3=$d4=$d3=$d5=$d6=$d1;  
                 
                 $mcc = $ligne->mcc;
                 $mnc = $ligne->mnc;
                 $IDLoc = $ligne->idlocatecell;
                 $asu0 = $ligne->asu0;
                 $asu1 = $ligne->asu1;
                 $asu2 = $ligne->asu2;
                 $asu3 = $ligne->asu3;
                 $asu4 = $ligne->asu4;
                 $asu5 = $ligne->asu5;
                 $asu6 = $ligne->asu6;
                 $lac0 = $ligne->lac0;
                 $lac1 = $ligne->lac1;
                 $lac2 = $ligne->lac2;
                 $lac3 = $ligne->lac3;
                 $lac4 = $ligne->lac4;
                 $lac5 = $ligne->lac5;
                 $lac6 = $ligne->lac6;
                 $cid0 = $ligne->cid0;
                 $cid1 = $ligne->cid1;
                 $cid2 = $ligne->cid2;
                 $cid3 = $ligne->cid3;
                 $cid4 = $ligne->cid4;
                 $cid5 = $ligne->cid5;
                 $cid6 = $ligne->cid6;
                 $heure = $ligne->heure;  
                 //obtention des coordonnes GPS
                 list ($lat0,$lon0)=  coordGPSCellule($mcc,$mnc,$lac0,$cid0,$con);

                 $reqI = "select insertGpsPrincipale($IDLoc,$IDPhone,$lat0,$lon0,$asu0,'$heure') as 'ID'";
                 //On insère seulement si nous avons des valeurs valides de coordonnés
                 if($lat0 != 0 && $lon0 != 0){
                     $result = $con ->query($reqI);

            //         echo "\n Reqi I : $reqI\n";
                     if($result){
                         $ligne = $result->fetch_object();
                         $ID = $ligne->ID;
                     }
                     //on rassemble les autres cellules pour une eventuelle triangulation
                     if($lac1!=null && $cid1!=null){
                        list ($lat1,$lon1) = coordGPSCellule($mcc,$mnc,$lac1,$cid1,$con);
                        $d1 = get_distance_m($lat0, $lon0, $lat1, $lon1);
                     }
                     if($lac2!=null && $cid2!=null){
                        list ($lat2,$lon2)= coordGPSCellule($mcc,$mnc,$lac2,$cid2,$con);
                        $d2 = get_distance_m($lat0, $lon0, $lat2, $lon2);
                     }
                     if($lac3!=null && $cid3!=null){
                        list ($lat3,$lon3)= coordGPSCellule($mcc,$mnc,$lac3,$cid3,$con);
                        $d3 = get_distance_m($lat0, $lon0, $lat3, $lon3);
                     }
                     if($lac4!=null && $cid4!=null){
                        list ($lat4,$lon4)= coordGPSCellule($mcc,$mnc,$lac4,$cid4,$con);
                        $d4 = get_distance_m($lat0, $lon0, $lat4, $lon4);
                     }
                     if($lac5!=null && $cid5!=null){
                        list ($lat5,$lon5)= coordGPSCellule($mcc,$mnc,$lac5,$cid5,$con);
                        $d5 = get_distance_m($lat0, $lon0, $lat5, $lon5);
                     }
                     if($lac6!=null && $cid6!=null){
                        list ($lat6,$lon6)= coordGPSCellule($mcc,$mnc,$lac6,$cid6,$con);
                        $d6 = get_distance_m($lat0, $lon0, $lat6, $lon6);
                     }
                     $tabDis = array("cell1"=>$d1,"cell2"=>$d2,"cell3"=>$d3,"cell4"=>$d4,"cell5"=>$d5,"cell6"=>$d6);
            ////         echo "\nd1=$d1 d2=$d2 d3=$d3 d4=$d4 d5=$d5\n";
                     asort($tabDis);
            //         while (list($c,$v)=each($tabDis)){
            //             echo "$c=$v" ;
            //         }
                    echo "<br>" ;
            //         //Nous avons au moins deux distances dans le tableau
                     if(count($tabDis)>1){
                         $val ="";
                         $i = 1;
                         foreach ($tabDis as $cle=>$valeur){
                             if($i > 2){
                                 break;
                             }
                             if($i > 1){
                                 $val.=" , ";
                             }
                             if($cle == "cell1" && $valeur!=0){
                                $val.=" lat$i=$lat1,lon$i=$lon1,asu$i=$asu1,d$i=".ceil($valeur);
                                $i++;
                             }else if($cle == "cell2" && $valeur!=0){
                                $val.=" lat$i=$lat2,lon$i=$lon2,asu$i=$asu2,d$i=".ceil($valeur);
                                $i++;
                             }else if($cle == "cell3" && $valeur!=0){
                                $val.=" lat$i=$lat3,lon$i=$lon3,asu$i=$asu3,d$i=".ceil($valeur);
                                $i++;
                             }else if($cle == "cell4" && $valeur!=0){
                                $val.=" lat$i=$lat4,lon$i=$lon4,asu$i=$asu4,d$i=".ceil($valeur);
                                $i++;
                             }else if($cle == "cell5" && $valeur!=0){
                                $val.=" lat$i=$lat5,lon$i=$lon5,asu$i=$asu5,d$i=".ceil($valeur);
                                $i++;
                             }else if($cle == "cell6" && $valeur!=0){
                                $val.=" lat$i=$lat6,lon$i=$lon6,asu$i=$asu6,d$i=".ceil($valeur);
                                $i++;
                             }

                         }
                         $req2 = "update locategps set $val where idlocategps=$ID";
                         if(!empty($val)){
                             $result = $con -> query($req2);
                         }
                         echo "<center><font color='red'>Une erreur c'est produite lors des calculs, "
                         . "celle-ci rend impossible un affichage des informations "
                                 . "coh&eacute;rentes<br></font> $con->error<br></center>";
                         echo "$req2";
                     }
                }                  
        }
    }
    //Desormais tout les tuples qui nous interessent sont dans locategps
    header("Content-type: text/xml");

    // Start XML file, echo parent node

    echo '<markers>';
    
    $reqListPosition = "select IDLocateGPS from locategps join phone using(IDPhone) where phone.IDPhone=$IDPhone and heure between '$heureDeb' and '$heureFin'  ";
    $res = $con -> query($reqListPosition);
    if($res && $res -> num_rows > 0){
        while($tuple = $res -> fetch_object()){
            //$query ='SELECT "BTS Principale" as "nomUser",numero,lat0 as "lat",lon0 as "lon",0 as "dis" FROM locategps join phone using(IDPhone) WHERE phone.IDPhone='.$ID.' and heure=(select max(heure) from locategps where IDPHONE='.$ID.')';
            $req = "   select 'BTS Principale' as nomUser,lat0 as 'lat', lon0 as 'lon', 0 as 'dis'  
                from locategps  where  IDLocategps=$tuple->IDLocateGPS ";
//             . " union "
//             . " select 'BTS Secondaire' as nomUser,lat1 as 'lat', lon1 as 'lon', d1 as 'dis' 
//                from locategps where  IDLocategps=$tuple->IDLocateGPS"
//             . " union "
//             . " select 'Troisieme BTS' as nomUser,lat2 as 'lat', lon2 as 'lon', d2 as 'dis'  
//                from locategps where  IDLocategps=$tuple->IDLocateGPS"
//             . " union "
//             . " select 'Quatrieme BTS' as nomUser,lat3 as 'lat', lon3 as 'lon', d3 as 'dis'  
//                from locategps where IDLocategps=$tuple->IDLocateGPS"
//             . " union "
//             . " select 'Cinquieme BTS' as nomUser,lat4 as 'lat', lon4 as 'lon', d4 as 'dis'  
//                from locategps where  IDLocategps=$tuple->IDLocateGPS"
//             . " union "
//             . " select 'Sixieme BTS' as nomUser,lat5 as 'lat', lon5 as 'lon', d5 as 'dis'  
//                from locategps where IDLocategps=$tuple->IDLocateGPS "
//             . " union "
//             . " select 'Septieme BTS' as nomUser,lat6 as 'lat', lon6 as 'lon', d6 as 'dis'  
//                from locategps where IDLocategps=$tuple->IDLocateGPS";        
//            echo "<br><br> $req<br><br>";
            $result = $con ->query($req);
            if (!$result) {
              die('Invalid query: ' . mysql_error());
            }

            // Iterate through the rows, printing XML nodes for each
            while ($row = $result->fetch_object()){
              if($row ->lat !=null || !empty($row ->lat)){
                  // ADD TO XML DOCUMENT NODE
                  $name = $row->nomUser;
                  if($name == "BTS Principale"){
                      $lati1 = $row->lat;
                      $lngi1 = $row->lon;
                  }
              }
            }
            list ($tabAsu, $tabLat, $tabLon) = getValeurForTriangulation($IDPhone,"not now",$tuple->IDLocateGPS);
            if(count($tabAsu) > 2){
            //On a au moins 3 cellule pour trianguler
                list($latPhone,$lonPhone) = getPointIntersectionFullTriangulation($tabAsu, $tabLat, $tabLon) ;

                //on obtient la distance de la BTS Principale au telephone
                $dis = get_distance_m($lati1, $lngi1, $latPhone, $lonPhone);
                /*
                 * position du mobile trianguler
                 */
                $req = "select concat_ws('  ',coalesce(nomUser,''),"
                        . "date_format(heure,'%d/%m/%Y %H:%i:%s')) AS 'Etiquette'"
                        . " FROM locategps join phone using(IDPhone) "
                        . "WHERE phone.IDPhone=$IDPhone and IDLocateGPS=$tuple->IDLocateGPS";
                $result = $con ->query($req);
                $ligne = $result -> fetch_object();
            //    $name = $ligne -> Etiquette.' à '.$dis.' mètres de BTS_P';
                $nomPT = $ligne -> Etiquette;
                $latPT = $latPhone ;
                $lonPT = $lonPhone;
                $distancePT = ceil($dis);
             }else{
                 //Ici il n'y a pas eu de triangulation, on garde les infos de la cellule principale
                $nomPT = $ligne -> Etiquette;
                $latPT = $lati1 ;
                $lonPT = $lngi1;
                $distancePT = "0";
             }
             
            echo '<marker ';
            echo 'name=" '.$nomPT.'" ';
            //echo 'address="' . parseToXML($row['address']) . '" ';
            echo 'lat="' . $latPT . '" ';
            echo 'lng="' . $lonPT . '" ';
            echo 'dis="' . $distancePT . '" ';
            //echo 'type="' . $row['type'] . '" ';
            echo '/>';
        }
    }
     
    // End XML file
    echo '</markers>';
    
    $con->close();
    
