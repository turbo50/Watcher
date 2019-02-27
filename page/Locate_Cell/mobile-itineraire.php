<?php
session_start();

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="generator" content="openElement (1.56.4)" />
  <title>Trac&#233; d'itin&#233;raire</title>
  <link id="openElement" rel="stylesheet" type="text/css" href="WEFiles/Css/v02/openElement.css?v=50491126800" />
  <link id="OETemplate1" rel="stylesheet" type="text/css" href="Templates/PageMere.css?v=50491126800" />
  <link id="OEBase" rel="stylesheet" type="text/css" href="mobile-itineraire.css?v=50491126800" />
  <!--[if lte IE 7]>
  <link rel="stylesheet" type="text/css" href="WEFiles/Css/ie7.css?v=50491126800" />
  <![endif]-->
  <script type="text/javascript">
   var WEInfoPage = {"PHPVersion":"phpOK","OEVersion":"1-56-4","PagePath":"mobile-itineraire","Culture":"DEFAULT","LanguageCode":"FR","RelativePath":"","RenderMode":"Export","PageAssociatePath":"mobile-itineraire","EditorTexts":null};
  </script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/1.10.2.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/migrate.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/Common/oe.min.js?v=50491126800"></script>
  <script type="text/javascript" src="mobile-itineraire(var).js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.core.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.effects.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/jQuery/Plugins/jquery.ui.accordion-v21.js?v=50491126800"></script>
  <script type="text/javascript" src="WEFiles/Client/WEMenuAccordion-v22.js?v=50491126800"></script>
  <link rel="stylesheet" href="../../css/datatables.min.css" type="text/css">
         <link type="text/css" rel="stylesheet" href="../../extension/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
         <SCRIPT type="text/javascript" src="../../extension/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
    
         <script src="../../js/jquery-1.12.3.min.js"></script>
         <script src="../../js/jquery.dataTables.min.js"></script> 
  
  <link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css"/>
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
  
  <script src="./jquery.js"></script>
  <script src="build/jquery.datetimepicker.full.js"></script>
  <script>/*
  window.onerror = function(errorMsg) {
  	$('#console').html($('#console').html()+'<br>'+errorMsg)
  }*/
  
  $.datetimepicker.setLocale('en');
  
  $('#datetimepicker_format').datetimepicker({value:'2015/04/15 05:03', format: $("#datetimepicker_format_value").val()});
  console.log($('#datetimepicker_format').datetimepicker('getValue'));
  
  $("#datetimepicker_format_change").on("click", function(e){
  	$("#datetimepicker_format").data('xdsoft_datetimepicker').setOptions({format: $("#datetimepicker_format_value").val()});
  });
  $("#datetimepicker_format_locale").on("change", function(e){
  	$.datetimepicker.setLocale($(e.currentTarget).val());
  });
  
  $('#datetimepicker').datetimepicker({
  dayOfWeekStart : 1,
  lang:'en',
  disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
  startDate:	'1986/01/05'
  });
  $('#datetimepicker').datetimepicker({value:'2015/04/15 05:03',step:10});
  
  $('.some_class').datetimepicker();
  
  $('#default_datetimepicker').datetimepicker({
  	formatTime:'H:i',
  	formatDate:'d.m.Y',
  	//defaultDate:'8.12.1986', // it's my birthday
  	defaultDate:'+03.01.1970', // it's my birthday
  	defaultTime:'10:00',
  	timepickerScrollbar:false
  });
  
  $('#datetimepicker10').datetimepicker({
  	step:5,
  	inline:true
  });
  $('#datetimepicker_mask').datetimepicker({
  	mask:'9999/19/39 29:59'
  });
  
  $('#datetimepicker1').datetimepicker({
  	datepicker:false,
  	format:'H:i',
  	step:5
  });
  $('#datetimepicker2').datetimepicker({
  	yearOffset:222,
  	lang:'ch',
  	timepicker:false,
  	format:'d/m/Y',
  	formatDate:'Y/m/d',
  	minDate:'-1970/01/02', // yesterday is minimum date
  	maxDate:'+1970/01/02' // and tommorow is maximum date calendar
  });
  $('#datetimepicker3').datetimepicker({
  	inline:true
  });
  $('#datetimepicker4').datetimepicker();
  $('#open').click(function(){
  	$('#datetimepicker4').datetimepicker('show');
  });
  $('#close').click(function(){
  	$('#datetimepicker4').datetimepicker('hide');
  });
  $('#reset').click(function(){
  	$('#datetimepicker4').datetimepicker('reset');
  });
  $('#datetimepicker5').datetimepicker({
  	datepicker:false,
  	allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00'],
  	step:5
  });
  $('#datetimepicker6').datetimepicker();
  $('#destroy').click(function(){
  	if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
  		$('#datetimepicker6').datetimepicker('destroy');
  		this.value = 'create';
  	}else{
  		$('#datetimepicker6').datetimepicker();
  		this.value = 'destroy';
  	}
  });
  var logic = function( currentDateTime ){
  	if (currentDateTime && currentDateTime.getDay() == 6){
  		this.setOptions({
  			minTime:'11:00'
  		});
  	}else
  		this.setOptions({
  			minTime:'8:00'
  		});
  };
  $('#datetimepicker7').datetimepicker({
  	onChangeDateTime:logic,
  	onShow:logic
  });
  $('#datetimepicker8').datetimepicker({
  	onGenerate:function( ct ){
  		$(this).find('.xdsoft_date')
  			.toggleClass('xdsoft_disabled');
  	},
  	minDate:'-1970/01/2',
  	maxDate:'+1970/01/2',
  	timepicker:false
  });
  $('#datetimepicker9').datetimepicker({
  	onGenerate:function( ct ){
  		$(this).find('.xdsoft_date.xdsoft_weekend')
  			.addClass('xdsoft_disabled');
  	},
  	weekends:['01.01.2014','02.01.2014','03.01.2014','04.01.2014','05.01.2014','06.01.2014'],
  	timepicker:false
  });
  var dateToDisable = new Date();
  	dateToDisable.setDate(dateToDisable.getDate() + 2);
  $('#datetimepicker11').datetimepicker({
  	beforeShowDay: function(date) {
  		if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
  			return [false, ""]
  		}
  
  		return [true, ""];
  	}
  });
  $('#datetimepicker12').datetimepicker({
  	beforeShowDay: function(date) {
  		if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
  			return [true, "custom-date-style"];
  		}
  
  		return [true, ""];
  	}
  });
  $('#datetimepicker_dark').datetimepicker({theme:'dark'})
  
  
  </script>
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
      <div id="WE2d2cdd7b11" class="BaseDiv RNone OEWECodeBlock OESK_WECodeBlock_Default" style="z-index:1001">
       <div class="OESZ OESZ_DivContent OESZG_WE2d2cdd7b11">
        <h1> <font color ="blue" size="20"><center>Page en construction</center></font></h1>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>