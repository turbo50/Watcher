<?php
session_start();
if(!isset($_SESSION['nom']) || !isset($_SESSION['fonction']) ){
	header('location:connexion.php');
}

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="generator" content="openElement (1.56.4)" />
  <title>Edition d'un mobile</title>
  <link id="openElement" rel="stylesheet" type="text/css" href="WEFiles/Css/v02/openElement.css?v=50491126800" />
  <link id="OETemplate1" rel="stylesheet" type="text/css" href="Templates/PageMere.css?v=50491126800" />
  <link id="OEBase" rel="stylesheet" type="text/css" href="mobile-edition.css?v=50491126800" />
  <!--[if lte IE 7]>
  <link rel="stylesheet" type="text/css" href="WEFiles/Css/ie7.css?v=50491126800" />
  <![endif]-->
  <script type="text/javascript">
   var WEInfoPage = {"PHPVersion":"phpOK","OEVersion":"1-56-4","PagePath":"mobile-edition","Culture":"DEFAULT","LanguageCode":"FR","RelativePath":"","RenderMode":"Export","PageAssociatePath":"mobile-edition","EditorTexts":null};
  </script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/1.10.2.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/migrate.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/Common/oe.min.js?v=50491126800"></script>
  <script type="text/javascript" src="mobile-edition(var).js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.core.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.effects.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.accordion-v21.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/WEMenuAccordion-v22.js?v=50491126800"></script>
  <link rel="stylesheet" href="../../css/datatables.min.css" type="text/css">
         <link type="text/css" rel="stylesheet" href="../../extension/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
         <SCRIPT type="text/javascript" src="../../extension/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
    
         <script src="../../js/jquery-1.12.3.min.js"></script>
         <script src="../../js/jquery.dataTables.min.js"></script><?php
  include_once '../../outils/connexionBD.php';
include_once '../../classe/Mobile.php';
$con = connexion();
$req = "select numero, imeiSim, nomUser from phone where IDPHONE=".$_GET['IDPHONE'];
$res = $con -> query($req);
if($res && $res->num_rows == 1){
	$ligne = $res -> fetch_object();
	$imeiSim = $ligne -> imeiSim;
	$nomUser = ($ligne -> nomUser == null)? "":$ligne -> nomUser;
	$numero = ($ligne -> numero == null)? "":$ligne -> numero;
}
			
$con -> close();

  ?>

 </head>
 <body class="RWAuto" data-gl="{&quot;KeywordsHomeNotInherits&quot;:false}">
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
      <div id="WE6758fb8a35" class="BaseDiv RNone OEWECodeBlock OESK_WECodeBlock_Default" style="z-index:1001">
       <div class="OESZ OESZ_DivContent OESZG_WE6758fb8a35">
        <fieldset>
                    <legend>Edition d'un mobile</legend>
                     <form name="editMobil" action="editionMobile.php" method="POST">
                       
                                <label>Imei de la Sim</label><br>
                                <?php echo "<input type=\"text\" name=\"imeiSim\" value= $imeiSim  readonly=\"readonly\" />";?><br>
                            
                                <label>Num&eacute;ro t&eacute;l&eacute;phone.</label><br>
                                <?php echo "<input type=\"text\" name=\"numero\" value=$numero />";?><br>
                            
                         
                                <label>Nom du d&eacute;tenteur (Alias)</label><br>
                                <?php echo "<input type=\"text\" name=\"nomUser\" value= \"$nomUser\" size=\"20\" />";?><br>
                            
                           
                                <input type="submit" value="Modifier" /><br>
        			<?php $id = $_GET['IDPHONE']; echo "<input type=\"hidden\" name=\"idphone\" value= $id  />";?>
                           
                        
                    </form>
                    
        
                </fieldset>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>