<?php
	require_once "connexion(var).php";
	include_once "WEFiles/Server/DB/OEDB.php";
?><?php
//session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../../outils/connexionBD.php';
if(isset($_POST['l_89']) && isset($_POST['m_89'])){
    $con = connexion();
    $req = "Select nom,fonction,count(*) as 'NB' from userAuth where login=? and mdp=?";
    $pre = $con ->prepare($req);
    $pre ->bind_param("ss",$con->escape_string($_POST['l_89']),$con->escape_string($_POST['m_89']));
    $result = $pre ->execute();
    if($result && $result ->num_rows == 1){
        $ligne = $result -> fetch_object();
        if($ligne -> NB == 1){
            $_SESSION['nom'] = $ligne ->nom;
            $_SESSION['fonction'] = $ligne ->fonction; 
            $con ->close();
            header('location:mobile-list.php');
        }else{
            $con ->close();
            header('location:connexion.php');
            
        }
    }  
    
}

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="generator" content="openElement (1.56.4)" />
  <title>Se connecter</title>
  <link id="openElement" rel="stylesheet" type="text/css" href="WEFiles/Css/v02/openElement.css?v=50491126800" />
  <link id="OETemplate1" rel="stylesheet" type="text/css" href="Templates/BaseCalque.css?v=50491126800" />
  <link id="OEBase" rel="stylesheet" type="text/css" href="connexion.css?v=50491126800" />
  <link rel="stylesheet" type="text/css" href="WEFiles/Css/opentip.css?v=50491126800" />
  <!--[if lte IE 7]>
  <link rel="stylesheet" type="text/css" href="WEFiles/Css/ie7.css?v=50491126800" />
  <![endif]-->
  <script type="text/javascript">
   var WEInfoPage = {"PHPVersion":"phpOK","OEVersion":"1-56-4","PagePath":"connexion","Culture":"DEFAULT","LanguageCode":"FR","RelativePath":"","RenderMode":"Export","PageAssociatePath":"connexion","EditorTexts":null};
  </script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/1.10.2.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/migrate.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/Common/oe.min.js?v=50491126800"></script>
  <script type="text/javascript" src="connexion(var).js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.form.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/opentip-jquery.min.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/WESendForm-v29.js?v=50491126800"></script>
  <script type="text/javascript">
   var WEEdValidators = {"WE9021ce9aca":[{"MsgError":"Please enter your error message.","Expression":".+"}],"WE0cc324b51b":[{"MsgError":"Please enter your error message.","Expression":".+"}]}
  </script><?php
  	if (isset($oeHeaderInlineCode)) echo $oeHeaderInlineCode;
  ?>
 </head>
 <body class="" data-gl="{&quot;KeywordsHomeNotInherits&quot;:false}"><?php
  	if (isset($oeStartBodyInlineCode)) echo $oeStartBodyInlineCode;
  ?>
  <form id="XForm" method="post" action="#"></form>
  <div id="XBody" class="BaseDiv RWidth OEPageXbody OESK_XBody_Default" style="z-index:1000">
   <div class="OESZ OESZ_DivContent OESZG_XBody">
    <div class="OESZ OESZ_XBodyContent OESZG_XBody OECT OECT_Content OECTAbs">
     <div id="WEcf29fa0a10" class="BaseDiv RBoth OEWEPanel OESK_WEPanel_Default" style="z-index:1001">
      <div class="OESZ OESZ_DivContent OESZG_WEcf29fa0a10">
       <div class="OECT OECT_Content OECTAbs OEDynTag0" style="<?php echo $oei['WEcf29fa0a10..OEDynTag0.style'];?>">
        <div id="WEe9fa1752c6" class="BaseDiv RNone OEWELabel OESK_WELabel_Default" style="z-index:1001">
         <div class="OESZ OESZ_DivContent OESZG_WEe9fa1752c6">
          <span class="OESZ OESZ_Text OESZG_WEe9fa1752c6 ContentBox OEDynTag0">Nom d'utilisateur ou adresse mail</span>
         </div>
        </div>
        <div id="WE9021ce9aca" class="BaseDiv RWidth OEWETextBoxV2 OESK_WETextBox2_Default" style="z-index:1002">
         <div class="OESZ OESZ_DivContent OESZG_WE9021ce9aca">
          <input name="log" type="text" class="OESZ OESZ_TextBox OESZG_WE9021ce9aca OEDynTag0" value="<?php echo $oei['WE9021ce9aca..OEDynTag0.value'];?>" />
         </div>
        </div>
        <div id="WE456c3bfa52" class="BaseDiv RNone OEWELabel OESK_WELabel_Default" style="z-index:1003">
         <div class="OESZ OESZ_DivContent OESZG_WE456c3bfa52">
          <span class="OESZ OESZ_Text OESZG_WE456c3bfa52 ContentBox OEDynTag0">Mot de passe</span>
         </div>
        </div>
        <div id="WE0cc324b51b" class="BaseDiv RWidth OEWETextBoxV2 OESK_WETextBox2_Default" style="z-index:1004">
         <div class="OESZ OESZ_DivContent OESZG_WE0cc324b51b">
          <input name="mdp" type="password" class="OESZ OESZ_TextBox OESZG_WE0cc324b51b OEDynTag0" value="<?php echo $oei['WE0cc324b51b..OEDynTag0.value'];?>" />
         </div>
        </div>
        <div id="WE718582af48" class="BaseDiv RNone OEWECheckBoxV2 OESK_WECheckBox2_Default" style="z-index:1005">
         <div class="OESZ OESZ_DivContent OESZG_WE718582af48">
          <input type="checkbox" class="OESZ OESZ_CheckBox OESZG_WE718582af48 OEDynTag0" name="oelRememberMe" value="oelRememberMe" <?php echo $oei['WE718582af48..OEDynTag0.checked'];?>="<?php echo $oei['WE718582af48..OEDynTag0.checked'];?>"  />
         </div>
        </div>
        <div id="WE4e2c15cc37" class="BaseDiv RNone OEWELabel OESK_WELabel_Default" style="z-index:1006">
         <div class="OESZ OESZ_DivContent OESZG_WE4e2c15cc37">
          <span class="OESZ OESZ_Text OESZG_WE4e2c15cc37 ContentBox OEDynTag0">Garder ma session ouverte</span>
         </div>
        </div>
        <div id="WEd104065589" class="BaseDiv RNone OEWELink OESK_WELink_Default" style="z-index:1007">
         <div class="OESZ OESZ_DivContent OESZG_WEd104065589">
          <a class="OESZ OESZ_Link OESZG_WEd104065589 ContentBox OEDynTag0" data-cd="PageLink" href="<?php echo $oei['WEd104065589..OEDynTag0.href'];?>">Je n'ai pas encore de compte</a>
         </div>
        </div>
        <div id="WE6889be4670" class="BaseDiv RNone OEWELink OESK_WELink_Default" style="z-index:1008">
         <div class="OESZ OESZ_DivContent OESZG_WE6889be4670">
          <a class="OESZ OESZ_Link OESZG_WE6889be4670 ContentBox OEDynTag0" data-cd="PageLink" href="<?php echo $oei['WE6889be4670..OEDynTag0.href'];?>">J'ai oublié mon mot de passe</a>
         </div>
        </div>
        <div id="WE17bb4191d5" class="BaseDiv RWidth OEWEButton OESK_WEButton_Default" style="z-index:1009">
         <div class="OESZ OESZ_DivContent OESZG_WE17bb4191d5">
          <button class="OESZ OESZ_Button OESZG_WE17bb4191d5 OEDynTag0" type="button" name="WE17bb4191d5" data-oe-target-url="<?php echo $oei['WE17bb4191d5..OEDynTag0.data-oe-target-url'];?>">Connexion</button>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
    <div class="OESZ OESZ_XBodyFooter OESZG_XBody OECT OECT_Footer OECTAbs"></div>
   </div>
  </div>
 </body>
</html>