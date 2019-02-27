  <?php
 
function geturl()
{
 
    if ($_REQUEST["myl"] != "") {
      $temp = split(":", $_REQUEST["myl"]);
      $mcc = substr("00000000".($temp[0]),-8);
      $mnc = substr("00000000".($temp[1]),-8);
      $lac = substr("00000000".($temp[2]),-8);
      $cid = substr("00000000".($temp[3]),-8);    
    } else {
      $hex = $_REQUEST["hex"];
      //echo "hex $hex";
      if ($hex=="1"){
            //echo "da hex to dec"; 
            $mcc=substr("00000000".hexdec($_REQUEST["mcc"]),-8);
            $mnc=substr("00000000".hexdec($_REQUEST["mnc"]),-8);
            $lac=substr("00000000".hexdec($_REQUEST["lac"]),-8);
            $cid=substr("00000000".hexdec($_REQUEST["cid"]),-8);
 
            $nlac[0]=substr("00000000".hexdec($_REQUEST["lac0"]),-8);
            $ncid[0]=substr("00000000".hexdec($_REQUEST["cid0"]),-8);           
            $nlac[1]=substr("00000000".hexdec($_REQUEST["lac1"]),-8);
            $ncid[1]=substr("00000000".hexdec($_REQUEST["cid1"]),-8);
            $nlac[2]=substr("00000000".hexdec($_REQUEST["lac2"]),-8);
            $ncid[2]=substr("00000000".hexdec($_REQUEST["cid2"]),-8);
            $nlac[3]=substr("00000000".hexdec($_REQUEST["lac3"]),-8);
            $ncid[3]=substr("00000000".hexdec($_REQUEST["cid3"]),-8);
            $nlac[4]=substr("00000000".hexdec($_REQUEST["lac4"]),-8);
            $ncid[4]=substr("00000000".hexdec($_REQUEST["cid4"]),-8);
            $nlac[5]=substr("00000000".hexdec($_REQUEST["lac5"]),-8);
            $ncid[5]=substr("00000000".hexdec($_REQUEST["cid5"]),-8);
 
      }else{
            //echo "lascio dec";    
            $mcc = substr("00000000".$_REQUEST["mcc"],-8);
            $mnc = substr("00000000".$_REQUEST["mnc"],-8);
            $lac = substr("00000000".$_REQUEST["lac"],-8);
            $cid = substr("00000000".$_REQUEST["cid"],-8);
 
            $nlac[0]=substr("00000000".($_REQUEST["lac0"]),-8);
            $ncid[0]=substr("00000000".($_REQUEST["cid0"]),-8);         
            $nlac[1]=substr("00000000".($_REQUEST["lac1"]),-8);
            $ncid[1]=substr("00000000".($_REQUEST["cid1"]),-8);
            $nlac[2]=substr("00000000".($_REQUEST["lac2"]),-8);
            $ncid[2]=substr("00000000".($_REQUEST["cid2"]),-8);
            $nlac[3]=substr("00000000".($_REQUEST["lac3"]),-8);
            $ncid[3]=substr("00000000".($_REQUEST["cid3"]),-8);
            $nlac[4]=substr("00000000".($_REQUEST["lac4"]),-8);
            $ncid[4]=substr("00000000".($_REQUEST["cid4"]),-8);
            $nlac[5]=substr("00000000".($_REQUEST["lac5"]),-8);
            $ncid[5]=substr("00000000".($_REQUEST["cid5"]),-8);
      }
    }
    //echo "MCC : $mcc <br> MNC : $mnc <br>LAC : $lac <br>CID : $cid <br>";
    return array ($mcc, $mnc, $lac, $cid, $nlac, $ncid);
}
function decodegoogle($mcc,$mnc,$lac,$cid)
{
 
    $mcch=substr("00000000".dechex($mcc),-8);
    $mnch=substr("00000000".dechex($mnc),-8);
    $lach=substr("00000000".dechex($lac),-8);
    $cidh=substr("00000000".dechex($cid),-8);
 
//    echo "<tr><td>Hex </td><td>MCC: $mcch </td><td>MNC: $mnch </td><td>LAC: $lach </td><td>CID: $cidh </td></tr></table>";
 
    $data = 
    "\x00\x0e". // Function Code?
    "\x00\x00\x00\x00\x00\x00\x00\x00". //Session ID?
    "\x00\x00". // Contry Code 
    "\x00\x00". // Client descriptor
    "\x00\x00". // Version
    "\x1b". // Op Code?
    "\x00\x00\x00\x00". // MNC
    "\x00\x00\x00\x00". // MCC
    "\x00\x00\x00\x03".
    "\x00\x00".
    "\x00\x00\x00\x00". //CID
    "\x00\x00\x00\x00". //LAC
    "\x00\x00\x00\x00". //MNC
    "\x00\x00\x00\x00". //MCC
    "\xff\xff\xff\xff". // ??
    "\x00\x00\x00\x00"  // Rx Level?
    ;

    $init_pos = strlen($data);
    $data[$init_pos - 38]= pack("H*",substr($mnch,0,2));
    $data[$init_pos - 37]= pack("H*",substr($mnch,2,2));
    $data[$init_pos - 36]= pack("H*",substr($mnch,4,2));
    $data[$init_pos - 35]= pack("H*",substr($mnch,6,2));
    $data[$init_pos - 34]= pack("H*",substr($mcch,0,2));
    $data[$init_pos - 33]= pack("H*",substr($mcch,2,2));
    $data[$init_pos - 32]= pack("H*",substr($mcch,4,2));
    $data[$init_pos - 31]= pack("H*",substr($mcch,6,2));
    $data[$init_pos - 24]= pack("H*",substr($cidh,0,2));
    $data[$init_pos - 23]= pack("H*",substr($cidh,2,2));
    $data[$init_pos - 22]= pack("H*",substr($cidh,4,2));
    $data[$init_pos - 21]= pack("H*",substr($cidh,6,2));
    $data[$init_pos - 20]= pack("H*",substr($lach,0,2));
    $data[$init_pos - 19]= pack("H*",substr($lach,2,2));
    $data[$init_pos - 18]= pack("H*",substr($lach,4,2));
    $data[$init_pos - 17]= pack("H*",substr($lach,6,2));
    $data[$init_pos - 16]= pack("H*",substr($mnch,0,2));
    $data[$init_pos - 15]= pack("H*",substr($mnch,2,2));
    $data[$init_pos - 14]= pack("H*",substr($mnch,4,2));
    $data[$init_pos - 13]= pack("H*",substr($mnch,6,2));
    $data[$init_pos - 12]= pack("H*",substr($mcch,0,2));
    $data[$init_pos - 11]= pack("H*",substr($mcch,2,2));
    $data[$init_pos - 10]= pack("H*",substr($mcch,4,2));
    $data[$init_pos - 9]= pack("H*",substr($mcch,6,2));

    if ((hexdec($cid) > 0xffff) && ($mcch != "00000000") && ($mnch != "00000000")) {
      $data[$init_pos - 27] = chr(5);
    } else {
      $data[$init_pos - 24]= chr(0);
      $data[$init_pos - 23]= chr(0);
    }

    $context = array (
            'http' => array (
                'method' => 'POST',
                'header'=> "Content-type: application/binary\r\n"
                    . "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data
                )
            );

    $xcontext = stream_context_create($context);
    $str=file_get_contents("http://www.google.com/glm/mmap",FALSE,$xcontext);

    if (strlen($str) > 10) {
      $lat_tmp = unpack("l",$str[10].$str[9].$str[8].$str[7]);
      $lat = $lat_tmp[1]/1000000;
      $lon_tmp = unpack("l",$str[14].$str[13].$str[12].$str[11]);
      $lon = $lon_tmp[1]/1000000;
      //$raggio_tmp = unpack("l",$str[18].$str[17].$str[16].$str[15]);
      //$raggio = $raggio_tmp[1]/1;
      } else {
      echo "Not found!";
      $lat = 0;
      $lon = 0;
      }
      return array($lat,$lon/*,$raggio*/);

    }

//    //list($mcc,$mnc,$lac,$cid, $nlac, $ncid)=geturl();
//
//    echo "<table cellspacing=30><tr><td>Dec</td><td>MCC: $mcc </td><td>MNC: $mnc </td><td>LAC: $lac </td><td>CID: $cid </td></tr>";
//
//    list ($lat,$lon,$raggio)=decodegoogle($mcc,$mnc,$lac,$cid);
//
//      echo "<br>Google result for the main Cell<br>";
//      echo "Lat=$lat <br> Lon=$lon <br> Range=$raggio m<br>";
//      echo "<a href=\"http://maps.google.it/maps?f=q&source=s q&hl=it&geocode=&q=$lat,$lon&z=14\" TARGET=\"_blank\" >See on Google maps</a> <BR> <br>";
//
//      for ($contatore=0; $contatore < (count($nlac)); $contatore++) {
//        if ($nlac[$contatore]==0) {
//            //echo "trovato campo vuoto al contatore $contatore<BR>";
//            $ncelle=$contatore;
//            break;
//        }   
//    }
//
//    for ($contatore=0; $contatore < ($ncelle); $contatore++) {
//        echo "LAC: $nlac[$contatore]\t CID: $ncid[$contatore]<BR>";
//        list ($nlat[$contatore],$nlon[$contatore],$nraggio[$contatore])=decodegoogle($mcc,$mnc,$nlac[$contatore],$ncid[$contatore]);
//        echo "<br>Google result for the Neighbor Cell $contatore <br>";
//        echo "nLat=$nlat[$contatore] <br> nLon=$nlon[$contatore] <br> nRaggio=$nraggio[$contatore] m<br><br>";
//    }
//
//      echo "<div id=\"map\" style=\"width: 100%; height: 700px\"></div>";
//      echo "<script type=\"text/javascript\">";
//      echo "var latgoogle=$lat;";
//      echo "var longoogle=$lon;";
//      echo "var raggio=$raggio;";
//
//    //creo un file contenente le coordinate delle celle ****  
//        $stringa_xml_doc = " <markers>\n\t";
//        $stringa_xml_doc =$stringa_xml_doc. "<marker lat=\"$lat\" lng=\"$lon\" rag=\"$raggio\" html=\"Main cell\" ico=\"antred\" label=\"Main\" />"; 
//            for($contatore= 0; $contatore < $ncelle; $contatore++) 
//            { 
//                if ($nlat[$contatore]!=0) {
//                    $stringa_xml_doc =$stringa_xml_doc. "<marker lat=\"$nlat[$contatore]\" lng=\"$nlon[$contatore]\" rag=\"$nraggio[$contatore]\" html=\"Cell $contatore\" ico=\"antbrown\" label=\"Marker $contatore\" />"; 
//                }
//
//            } 
//        $stringa_xml_doc =$stringa_xml_doc."\n </markers>";
//
//        echo ($stringa_xml_doc);
//        //$stringa_xml = $stringa_xml_dtd.$stringa_xml_doc;
//        $stringa_xml = $stringa_xml_doc;
//
//        $file_name = "celle_xml.xml";
//        $file = fopen ($file_name,"w");
//        $num = fwrite ($file, $stringa_xml);
//
//        fclose($file);
//
//        echo("File XML creato con successo!!");
//
//    //***
//
//      echo "nLat=new Array();";
//      echo "nLon=new Array();";
//      echo "nraggio=new Array();";
//      for ($contatore=0; $contatore < ($ncelle); $contatore++)
//                { 
//      echo "        nLat [$contatore]   =$nlat[$contatore];
//                    nLon [$contatore]   =$nlon[$contatore];
//                    nraggio [$contatore]=$nraggio[$contatore];";
//
//                }
//
//      echo "</script>";
 
?>