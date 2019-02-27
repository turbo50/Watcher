<?php
session_start();

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="generator" content="openElement (1.56.4)" />
  <title>Historique des positions</title>
  <link id="openElement" rel="stylesheet" type="text/css" href="WEFiles/Css/v02/openElement.css?v=50491126800" />
  <link id="OETemplate1" rel="stylesheet" type="text/css" href="Templates/PageMere.css?v=50491126800" />
  <link id="OEBase" rel="stylesheet" type="text/css" href="mobile-historique.css?v=50491126800" />
  <link rel="stylesheet" type="text/css" href="WEFiles/Css/opentip.css?v=50491126800" />
  <!--[if lte IE 7]>
  <link rel="stylesheet" type="text/css" href="WEFiles/Css/ie7.css?v=50491126800" />
  <![endif]-->
  <script type="text/javascript">
   var WEInfoPage = {"PHPVersion":"phpOK","OEVersion":"1-56-4","PagePath":"mobile-historique","Culture":"DEFAULT","LanguageCode":"FR","RelativePath":"","RenderMode":"Export","PageAssociatePath":"mobile-historique","EditorTexts":null};
  </script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/1.10.2.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/migrate.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/Common/oe.min.js?v=50491126800"></script>
  <script type="text/javascript" src="mobile-historique(var).js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.core.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.effects.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.accordion-v21.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/WEMenuAccordion-v22.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.form.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/opentip-jquery.min.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/WESendForm-v29.js?v=50491126800"></script>
  <link rel="stylesheet" href="../../css/datatables.min.css" type="text/css">
         <link type="text/css" rel="stylesheet" href="../../extension/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
         <SCRIPT type="text/javascript" src="../../extension/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
    
         <script src="../../js/jquery-1.12.3.min.js"></script>
         <script src="../../js/jquery.dataTables.min.js"></script> 
  <link rel="stylesheet" type="text/css" href="../../extension/calendrier/jquery.datetimepicker.css"/>
  <style type="text/css">
  
  .custom-date-style {
  	background-color: red !important;
  }
  
  .input{	
  }
  .input-wide{
  	width: 500px;
  }
  
  </style>
  
  
  
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcLI1Ve_129yPrGaXaz0NNwN--z7d9BdY"
              type="text/javascript"></script>
      <script type="text/javascript">
     
  
      var customIcons = {
        Mobile: {
          icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
        },
        BTSS: {
          icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
        },
        BTSP: {
          icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
        }
      };
  
      function load() {
  	  var datedebut = document.getElementById("datetimepicker1").value;
  	  var datefin = document.getElementById("datetimepicker2").value;
  	  var idPhone = parseInt(document.getElementById("IDP").value);
  	  var map = new google.maps.Map(document.getElementById("map"), {
          center: new google.maps.LatLng(4.03016, 9.695004),
          zoom: 15,
          mapTypeId: 'roadmap'
        });
        var infoWindow = new google.maps.InfoWindow;
        var zoneMarqueurs = new google.maps.LatLngBounds();
        // Change this depending on the name of your PHP file
        downloadUrl("../../outils/map/historique_pos.php?IDPHONE="+idPhone+"&debut="+datedebut+"&fin="+datefin, function(data) {
          var xml = data.responseXML;
          var markers = xml.documentElement.getElementsByTagName("marker");	  
          for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("name");
            //var address = markers[i].getAttribute("address");
            var distance = markers[i].getAttribute("dis");
            var point = new google.maps.LatLng( 
                parseFloat(markers[i].getAttribute("lat")),
                parseFloat(markers[i].getAttribute("lng")));
            var html = "<b>" + name + "</b><br/>&nbsp;&agrave;&nbsp;"+distance+"&nbsp;m&egrave;tres de BTS&nbsp;Principale " ;
            var icon = customIcons["BTSP"] || {};
            var marker = new google.maps.Marker({
              map: map,
              position: point,
              icon: icon.icon
            });
            bindInfoWindow(marker, map, infoWindow, html);
  		  zoneMarqueurs.extend( marker.getPosition() );
  		  map.panTo(point);
          }
          map.fitBounds( zoneMarqueurs );
          
            
            
           
            
        });
      }
  
      function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
          infoWindow.setContent(html);
          infoWindow.open(map, marker);
        });
      }
  
      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;
  
        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };
  
        request.open('GET', url, true);
        request.send(null);
      }
       function parseXml(str) {
        if (window.ActiveXObject) {
          var doc = new ActiveXObject('Microsoft.XMLDOM');
          doc.loadXML(str);
          return doc;
        } else if (window.DOMParser) {
          return (new DOMParser).parseFromString(str, 'text/xml');
        }
      }
      function doNothing() {}
  
  
    </script>
  <script type="text/javascript">
   
  </script><?php
  	if (isset($oeHeaderInlineCode)) echo $oeHeaderInlineCode;
  ?>
 </head>
 <body class="RWAuto" data-gl="{&quot;KeywordsHomeNotInherits&quot;:false}"><?php
  	if (isset($oeStartBodyInlineCode)) echo $oeStartBodyInlineCode;
  ?>
  <form id="XForm" method="post" action="#"></form>
  <div id="XBody" class="BaseDiv RWidth OEPageXbody OESK_XBody_Default" style="z-index:1000">
   <div class="OESZ OESZ_DivContent OESZG_XBody">
    <div class="OESZ OESZ_XBodyHeader OESZG_XBody OECT OECT_Header OECTAbs"></div>
    <div class="OESZ_Wrap_Columns OESZ_Wrap_Columns_NoRight">
     <div class="OESZ OESZ_XBodyLeftColumn OESZG_XBody OECT OECT_LeftColumn OECTAbs">
      <div id="WEfd15626d5c" class="BaseDiv RBoth OEWEMenuAccordion OESK_WEMenuAccordion_Default" style="z-index:1">
       <div class="OESZ OESZ_DivContent OESZG_WEfd15626d5c">
        <div class="OESZ OESZ_Top OESZG_WEfd15626d5c"></div>
        <h3 class="OESZ OESZ_FirstTitle OESZG_WEfd15626d5c">
         <a href="mobile-list.php">
          <img src="Files/Image/liste.png" class="OESZ OESZ_Icon OESZG_WEfd15626d5c" alt="Liste des mobiles" />
         </a>
         <a href="mobile-list.php#section1">Liste des mobiles</a>
        </h3>
        <ul class="OESZ OESZ_Box OESZG_WEfd15626d5c" style="list-style-type:none; height:0px; padding: 0px; margin:0px;">
         <li style="display:none"></li>
        </ul>
        <h3 class="OESZ OESZ_FirstTitle OESZG_WEfd15626d5c">
         <a href="deconnexion.php">
          <img src="Files/Image/icone-deconnexion.jpg" class="OESZ OESZ_Icon OESZG_WEfd15626d5c" alt="Deconnexion" />
         </a>
         <a href="deconnexion.php">Deconnexion</a>
        </h3>
        <ul class="OESZ OESZ_Box OESZG_WEfd15626d5c" style="list-style-type:none; height:0px; padding: 0px; margin:0px;">
         <li style="display:none"></li>
        </ul>
        <div class="OESZ OESZ_Bottom OESZG_WEfd15626d5c"></div>
       </div>
      </div>
     </div>
     <div class="OESZ OESZ_XBodyContent OESZG_XBody OECT OECT_Content OECTAbs">
      <div id="WEd1310ae44f" class="BaseDiv RBoth OEWEImage OESK_WEImage_Default" style="z-index:2">
       <div class="OESZ OESZ_DivContent OESZG_WEd1310ae44f">
        <img src="WEFiles/Image/WEImage/Image%20Ban1-WEd1310ae44f.jpg" class="OESZ OESZ_Img OESZG_WEd1310ae44f" alt="" />
       </div>
      </div>
      <div id="WE8ed6bc7401" class="BaseDiv RKeepRatio OEWEImage OESK_WEImage_Default" style="z-index:5">
       <div class="OESZ OESZ_DivContent OESZG_WE8ed6bc7401">
        <img src="WEFiles/Image/WEImage/BTS1-WE8ed6bc7401.png" class="OESZ OESZ_Img OESZG_WE8ed6bc7401" alt="" />
       </div>
      </div>
      <div id="WE4f32b87395" class="BaseDiv RNone OEWECodeBlock OESK_WECodeBlock_Default" style="z-index:4">
       <div class="OESZ OESZ_DivContent OESZG_WE4f32b87395">
        <?php 
           echo "Nom : ".$_SESSION['nom']."<br>";
           echo "Fonction : ".$_SESSION['fonction']."<br>";
        
        ?>
       </div>
      </div>
      <div id="WE8093099a30" class="BaseDiv RNone OEWELabel OESK_WELabel_Default" style="z-index:3">
       <div class="OESZ OESZ_DivContent OESZG_WE8093099a30">
        <span class="OESZ OESZ_Text OESZG_WE8093099a30 ContentBox">Mobile - Localisation<br /></span>
       </div>
      </div>
      <div id="WEc22a714a8b" class="BaseDiv RWidth OEWEHr OESK_WEHrLign_Default" style="z-index:1">
       <div class="OESZ OESZ_DivContent OESZG_WEc22a714a8b">
        <div class="OESZ OESZ_Deco1 OESZG_WEc22a714a8b" style="position:absolute"></div>
        <div class="OESZ OESZ_Deco2 OESZG_WEc22a714a8b" style="position:absolute"></div>
        <div class="OESZ OESZ_Deco3 OESZG_WEc22a714a8b" style="position:absolute"></div>
       </div>
      </div>
      <div id="WE12c365bfea" class="BaseDiv RNone OEWECodeBlock OESK_WECodeBlock_Default" style="z-index:1004">
       <div class="OESZ OESZ_DivContent OESZG_WE12c365bfea">
        <div id="map" style="left: 5px; height: 600px"></div>
       </div>
      </div>
      <div id="WE2596256279" class="BaseDiv RNone OEWECodeBlock OESK_WECodeBlock_Default" style="z-index:1001">
       <div class="OESZ OESZ_DivContent OESZG_WE2596256279">
        <input type="text" class="some_class" name="datedebut" value="" id="datetimepicker1"/><br>
       </div>
      </div>
      <div id="WE0a5d4c33aa" class="BaseDiv RNone OEWECodeBlock OESK_WECodeBlock_Default" style="z-index:1002">
       <div class="OESZ OESZ_DivContent OESZG_WE0a5d4c33aa">
        <input type="text" class="some_class" name="datefin" value="" id="datetimepicker2"/><br>
       </div>
      </div>
      <div id="WEbtAfficher" class="BaseDiv RWidth OEWEButton OESK_WEButton_Default" style="z-index:1003" data-ot="Afiicher l'historique des positions pour ce mobile" data-ot-delay="0.2" data-ot-target="true" data-ot-target-joint="top right" data-ot-tip-joint="bottom left">
       <div class="OESZ OESZ_DivContent OESZG_WEbtAfficher">
        <button class="OESZ OESZ_Button OESZG_WEbtAfficher OEDynTag0" type="button" name="WEbtAfficher" onclick='load()'>Afficher</button>
       </div>
      </div>
      <div id="WEf4420f8258" class="BaseDiv RNone OEWECodeBlock OESK_WECodeBlock_Default" style="z-index:1005">
       <div class="OESZ OESZ_DivContent OESZG_WEf4420f8258">
        <?php 
        	$val = $_GET['IDPHONE'];
          	echo "<input type=\"hidden\" name=\"IDphone\" value= $val  id=\"IDP\" />";
        ?>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
  
 </body>
    
    <script src="../../extension/calendrier/jquery.js"></script>
<script src="../../extension/calendrier/build/jquery.datetimepicker.full.js"></script>
<script>/*
window.onerror = function(errorMsg) {
	$('#console').html($('#console').html()+'<br>'+errorMsg)
}*/


$.datetimepicker.setLocale('en');
$('.some_class').datetimepicker();

$('#datetimepicker1').datetimepicker({
	formatDate:'Y-m-d'
});
$('#datetimepicker2').datetimepicker({
	formatDate:'Y-m-d'
});


</script>
    
    
</html>