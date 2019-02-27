<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

	//inclusion du fichier de connexion 
	include_once 'connexionBD.php';
	$conn = connexion();
	// initialisation des variables
	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;


	//on fixe les index des colonnes
	$columns = array( 
		0 =>'NomUser', 
		1 => 'numero',
		2 => 'imeiSim',
                3 => 'location',
                4 => 'edit',
                5 => 'history',
                6 => 'itinerary'
	);

	$where = $sqlTot = $sqlRec = "";

	// on se rassure si les criteres de recherche sont fixés
	if( !empty($params['search']['value']) ) {   
		$where .="  where ";
		$where .="  nomUser LIKE '%".$params['search']['value']."%' or numero LIKE '%".$params['search']['value']."%' or imeiSim LIKE '%".$params['search']['value']."%' ";    
	}

	// on obtient le nombre total de lignes avant la recherche
	$sql = "SELECT nomUser,numero,imeiSim,concat_ws('',concat('<a href=\"mobile-map.php?IDPHONE=',IDPhone),'\">Localiser</a>') as 'location',concat_ws('',concat('<a href=\"mobile-edition.php?IDPHONE=',IDPhone),'\">Editer</a>') as 'edit',concat_ws('',concat('<a href=\"mobile-historique.php?IDPHONE=',IDPhone),'\">Historique</a>') as 'histoy',concat_ws('',concat('<a href=\"mobile-itineraire.php?IDPHONE=',IDPhone),'\">Itin&eacute;raire</a>') as 'itinerary' FROM phone ";
	$sqlTot .= $sql;
	$sqlRec .= $sql;
	//on ajoute la clause where si elle existe
	if(isset($where) && $where != '') {

		$sqlTot .= $where;
		$sqlRec .= $where;
	}


 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

	$queryTot = mysqli_query($conn, $sqlTot) or die("Erreur de connexion:". mysqli_error($conn));
        

	$totalRecords = mysqli_num_rows($queryTot);

	$queryRecords = mysqli_query($conn, $sqlRec) or die("Erreur lors de la lecture des produits");

	//iterate on results row and create new index array of data
        //On boucle sur les lignes et on cree un nouveau tableau de donnees
	while( $row = mysqli_fetch_row($queryRecords) ) { 
		$data[] = $row;
	}	

	$json_data = array(
			"draw"            => intval( $params['draw'] ),   
			"recordsTotal"    => intval( $totalRecords ),  
			"recordsFiltered" => intval($totalRecords),
			"data"            => $data   // total data array
			);

	echo json_encode($json_data);  // send data as json format
?>
	