<?php
session_start();
if(!isset($_SESSION['nom']) || !isset($_SESSION['fonction']) ){
	header('location:connexion.php');
}
include_once '../../receiverdata/completeGPSCoordinate.php';

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="generator" content="openElement (1.56.4)" />
  <title>Visualisation du mobile</title>
  <link id="openElement" rel="stylesheet" type="text/css" href="WEFiles/Css/v02/openElement.css?v=50491126800" />
  <link id="OETemplate1" rel="stylesheet" type="text/css" href="Templates/PageMere.css?v=50491126800" />
  <link id="OEBase" rel="stylesheet" type="text/css" href="mobile-map.css?v=50491126800" />
  <!--[if lte IE 7]>
  <link rel="stylesheet" type="text/css" href="WEFiles/Css/ie7.css?v=50491126800" />
  <![endif]-->
  <script type="text/javascript">
   var WEInfoPage = {"PHPVersion":"phpOK","OEVersion":"1-56-4","PagePath":"mobile-map","Culture":"DEFAULT","LanguageCode":"FR","RelativePath":"","RenderMode":"Export","PageAssociatePath":"mobile-map","EditorTexts":null};
  </script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/1.10.2.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/migrate.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/Common/oe.min.js?v=50491126800"></script>
  <script type="text/javascript" src="mobile-map(var).js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.core.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.effects.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.accordion-v21.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/WEMenuAccordion-v22.js?v=50491126800"></script>
  <link rel="stylesheet" href="../../css/datatables.min.css" type="text/css">
         <link type="text/css" rel="stylesheet" href="../../extension/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
         <SCRIPT type="text/javascript" src="../../extension/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
    
         <script src="../../js/jquery-1.12.3.min.js"></script>
         <script src="../../js/jquery.dataTables.min.js"></script> 
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
  	  var idPhone = parseInt(document.getElementById("IDP").value);
        var map = new google.maps.Map(document.getElementById("map"), {
          center: new google.maps.LatLng(4.03016, 9.695004),
          zoom: 15,
          mapTypeId: 'roadmap'
        });
        var infoWindow = new google.maps.InfoWindow;
        var zoneMarqueurs = new google.maps.LatLngBounds();
        // Change this depending on the name of your PHP file
        downloadUrl("../../outils/map/phpsqlajax_genxml2.php?IDPHONE="+idPhone, function(data) {
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
            var icon = (name=="BTS Principale")? customIcons["BTSP"] || {}:customIcons["BTSS"] || {};
            var marker = new google.maps.Marker({
              map: map,
              position: point,
              icon: icon.icon
            });
            bindInfoWindow(marker, map, infoWindow, html);
  		  zoneMarqueurs.extend( marker.getPosition() );
  		  map.panTo(point);
          }
          
          var mobile = xml.documentElement.getElementsByTagName("mobile");
          if(mobile.length>0){
  			  var name = mobile[0].getAttribute("name");
  			  //var address = markers[i].getAttribute("address");
  			  var distanceM = mobile[0].getAttribute("dis");
  			  var point = new google.maps.LatLng(
  				  parseFloat(mobile[0].getAttribute("lat")),
  				  parseFloat(mobile[0].getAttribute("lng")));
  			  var html = "<b>" + name + "</b><br/>&nbsp;&agrave;&nbsp;"+distanceM+"&nbsp;m&egrave;tres de BTS&nbsp;Principale " ;
  			  var icon = customIcons["Mobile"] || {};
  			  var marker = new google.maps.Marker({
  				map: map,
  				position: point,
  				icon: icon.icon
  			  });
  			  bindInfoWindow(marker, map, infoWindow, html);
  		}
            
            
            /*Triangle */
            
     
              var triangleCoords;
              if(markers.length>2){
  				/*for(int i=0; i<markers.length; i++){
  					triangleCoords[i] = {lat:parseFloat(markers[i].getAttribute("lat")), 
  										 lng:parseFloat(markers[i].getAttribute("lng"))}
  				}*/
  			    triangleCoords = [
  				  {lat:parseFloat(markers[0].getAttribute("lat")), lng:parseFloat(markers[0].getAttribute("lng"))},
  				  {lat:parseFloat(markers[1].getAttribute("lat")),lng:parseFloat(markers[1].getAttribute("lng"))},
  				  {lat:parseFloat(markers[2].getAttribute("lat")),lng:parseFloat(markers[2].getAttribute("lng"))}
  				];
  
  				// Construct the polygon.
  				var bermudaTriangle = new google.maps.Polygon({
  				  paths: triangleCoords,
  				  strokeColor: '#FF0000',
  				  strokeOpacity: 0.8,
  				  strokeWeight: 2,
  				  fillColor: '#FF0000',
  				  fillOpacity: 0.35
  				});
  				bermudaTriangle.setMap(map);
  				// on veut maintenant faire un zoom sur tous les marqueurs
  				map.fitBounds( zoneMarqueurs );
  			}
  			
            	
  			
  		  
  		  // Dessin du perimetre de recherche.
  			if(mobile.length>0){
  				  var cityCircle = new google.maps.Circle({
  				  strokeColor: '#D8EBF8',
  				  strokeOpacity: 0.8,
  				  strokeWeight: 2,
  				  fillColor: '#D8EBF8',
  				  fillOpacity: 0.35,
  				  map: map,
  				  center: point,
  				  radius: parseFloat(distanceM)
  				});
  			}
            
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
  
      var reload = setInterval(load, 60000 * 3);
  
  
    </script>
 </head>
 <body class="RWAuto" data-gl="{&quot;KeywordsHomeNotInherits&quot;:false}" onclick='load()'>
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
      <div id="WE8ed6bc7401" class="BaseDiv RKeepRatio OEWEImage OESK_WEImage_Default" style="z-index:5">
       <div class="OESZ OESZ_DivContent OESZG_WE8ed6bc7401">
        <img src="WEFiles/Image/WEImage/BTS1-WE8ed6bc7401.png" class="OESZ OESZ_Img OESZG_WE8ed6bc7401" alt="" />
       </div>
      </div>
      <div id="WEd1310ae44f" class="BaseDiv RBoth OEWEImage OESK_WEImage_Default" style="z-index:2">
       <div class="OESZ OESZ_DivContent OESZG_WEd1310ae44f">
        <img src="WEFiles/Image/WEImage/Image%20Ban1-WEd1310ae44f.jpg" class="OESZ OESZ_Img OESZG_WEd1310ae44f" alt="" />
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
      <div id="WEa214d91272" class="BaseDiv RNone OEWECodeBlock OESK_WECodeBlock_Default" style="z-index:1001">
       <div class="OESZ OESZ_DivContent OESZG_WEa214d91272">
        <div id="map" style="left: 5px; height: 600px"></div>
       </div>
      </div>
      <div id="WEb8fb539795" class="BaseDiv RNone OEWECodeBlock OESK_WECodeBlock_Default" style="z-index:1002">
       <div class="OESZ OESZ_DivContent OESZG_WEb8fb539795">
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
</html>