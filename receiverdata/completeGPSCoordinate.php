<?php
//session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../outils/connexionBD.php';
require_once '../../outils/triangulation.php';

 /* Cette fonction recupere les coordonnes gps d'une cellule deja stockee, ou en demande explicitement 
           s'ils n'existent pas ou sont supposes perimes
         */
         


 $IDPhone = $_GET['IDPHONE'];
// $_SESSION['IDPHONE']=$_GET['IDPHONE'];
// $latitude1=$latitude2=0; $longitude1=$longitude2=0; $asu1_=$asu2_=0;
 $con = connexion();
 $req = "select cid0, cid1, cid2,cid3,cid4,cid5,cid6, lac0, lac1, lac2,lac3,lac4,lac5,lac6, "
         . "asu0, asu1, asu2,asu3,asu4,asu5,asu6,idlocatecell,mnc,mcc,heure from locateCell "
         . "where idlocatecell not in (select IDLocateCell from locategps) and "
         . "IDPhone=$IDPhone order by heure desc limit 1 ";
 $result = $con ->query($req);
 if($result && $result->num_rows==1){
     $d1=0;$d2=$d3=$d4=$d3=$d5=$d6=$d1;$ID=0;  
     $ligne = $result->fetch_object();
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
                 if(!empty($con->error)){
                     echo "<center><font color='red'>Une erreur c'est produite lors des calculs, "
                 . "celle-ci rend impossible un affichage des informations "
                         . "coh&eacute;rentes<br></font> $con->error<br></center>";
                 }
//                 echo "$req2";
             }
        }
   
 }
 $con -> close();
