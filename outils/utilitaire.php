<?php
 include_once 'connexionBD.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

      /*Fonction qui retourne un tableau contenant les resultats d'une requete SQL*/
      function  donneesTableau($requete){
          $con = connexion();
          $resultat = $con -> query($requete);
          if(!$resultat){
            echo "Lecture impossible";
          }
          else{	
                $entete = $resultat -> fetch_fields();
                echo "<table border=\"1\" style=\" width: 100%\"> <tr>";
                //Affichage des entetes
                foreach($entete as $colonne){
                    echo "<th>", htmlentities($colonne -> name) ,"</th>";
                }
                echo "</tr>";
                //Lecture des lignes du résultat
                while($ligne = $resultat -> fetch_array(MYSQLI_NUM)){
                    echo "<tr>";
                    $i = 0;
                    foreach($ligne as $valeur){
                        if($i == 0){
                            echo "<td><input  type='hidden'>$valeur</> </td>";
                        }else{
                            echo "<td> $valeur </td>";
                        }
                        
                    }
                    echo "</tr>";
                }
                echo "</table>";
          }
          $resultat -> free_result();
          $con -> close();    
     }
 
     function chiffrement (){
         // On calcule la taille de la clé pour l'algo triple DES
            $cle_taille = mcrypt_module_get_algo_key_size(MCRYPT_3DES);
            // On calcule la taille du vecteur d'initialisation pour l'algo triple DES et pour le mode NOFB
            $iv_taille = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_NOFB);
            //On fabrique le vecteur d'initialisation, la constante MCRYPT_RAND permet d'initialiser un vecteur aléatoire
            $iv = mcrypt_create_iv($iv_taille, MCRYPT_RAND);

            $cle ="Ceci est une clé censé crypter un message mais à mon avis elle est beaucoup trop longue";
            // On retaille la clé pour qu'elle ne soit pas trop longue
            $cle = substr($cle, 0, $cle_taille);

            // Le message à crypter
            $message = "Voici mon super message que je dois crypter";
            // On le crypte
            $message_crypte = mcrypt_encrypt(MCRYPT_3DES, $cle, $message, MCRYPT_MODE_NOFB, $iv);
            // On le décrypte
            $message_decrypte = mcrypt_decrypt(MCRYPT_3DES, $cle, $message_crypte, MCRYPT_MODE_NOFB, $iv);
     }
     
     function chiffre ($cle,$message){
         // On calcule la taille de la clé pour l'algo triple DES
            $cle_taille = mcrypt_module_get_algo_key_size(MCRYPT_3DES);
            // On calcule la taille du vecteur d'initialisation pour l'algo triple DES et pour le mode NOFB
            $iv_taille = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_NOFB);
            //On fabrique le vecteur d'initialisation, la constante MCRYPT_RAND permet d'initialiser un vecteur aléatoire
            $iv = mcrypt_create_iv($iv_taille, MCRYPT_RAND);
            // On retaille la clé pour qu'elle ne soit pas trop longue
            $cle = substr($cle, 0, $cle_taille);
            // On le crypte
            return  mcrypt_encrypt(MCRYPT_3DES, $cle, $message, MCRYPT_MODE_NOFB, $iv);
    }
    
    function dechiffre ($cle,$messageCrypte){
         // On calcule la taille de la clé pour l'algo triple DES
            $cle_taille = mcrypt_module_get_algo_key_size(MCRYPT_3DES);
            // On calcule la taille du vecteur d'initialisation pour l'algo triple DES et pour le mode NOFB
            $iv_taille = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_NOFB);
            //On fabrique le vecteur d'initialisation, la constante MCRYPT_RAND permet d'initialiser un vecteur aléatoire
            $iv = mcrypt_create_iv($iv_taille, MCRYPT_RAND);
            // On retaille la clé pour qu'elle ne soit pas trop longue
            $cle = substr($cle, 0, $cle_taille);
            // On le décrypte
            return  mcrypt_decrypt(MCRYPT_3DES, $cle, $messageCrypte, MCRYPT_MODE_NOFB, $iv);
     }
 
    /**
     * 
     * @param type $nomFichier ce que nous voulons telecharger
     * @param type $location emplacement sur le serveur
     * @param type $poidsFichier poids en octet du fichier
     */
    function telecharger($nomFichier, $location, $poidsFichier){
        header('Content-Type: application/octet-stream');
        header('Content-Length: '. $poidsFichier);
        header('Content-disposition: attachment; filename='. $nomFichier);
        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        readfile($location);
        exit();
    }
    
    /*Fonction qui est appelee pour afficher la suite d'image pour un slider*/
    function donneesSlider($source, $alt, $description){
//        $nom = 
        echo '<li><img src="'.DOSSIER_IMAGE.$source.'" data-description="'.$description.'">'
                . '<span>'.$alt.'</span></li>';
    }
 
    /*Fonction qui est appelee pour afficher la suite d'image pour un slider*/
    function donneesTyniSlider($source, $alt, $description){
//        $nom = 
        echo '<li><h3>'.$source.'</h3>'
                . '<span>'.DOSSIER_IMAGE.$source.'</span>'
                . '<p>'.$description.'</p>'
//                . '<img src="'.DOSSIER_IMAGE.$source.'" alt="'.$alt.'">'
                . '</li>';
    }
    
    function executeRequette ($requette){
        $con = connexion();
        $con -> query($requette);
        $con -> close();
    }
    
    function resultatRequette ($requette) {
        $con = connexion();
        $resultat = $con -> query($requete);
//        $valeur = $resultat ->
        $con -> close();
    }
    
    function lire_csv($nom_fichier, $separateur =";"){
        $row = 0;
        $donnee = array();    
        $f = fopen ($nom_fichier,"r");
        $taille = filesize($nom_fichier)+1;
        while ($donnee = fgetcsv($f, $taille, $separateur)) {
            $result[$row] = $donnee;
            $row++;
        }
        fclose ($f);
        return $result;
    }
 
    function requete_insert($donnees_csv, $table){
        $insert = array(); 
        $i = 0;      
        while (list($key, $val) = @each($donnees_csv)){
        /*On ajoute une valeur vide ' ' en début pour le champs d'auto-incrémentation  s'il existe, sinon enlever cette valeur*/
              // if ($i>0){
                    $separateur = ($val instanceof integer || $val instanceof double)? "":"'";
                    $insert[$i] = "INSERT into ".$table." VALUES($separateur" ;
                     
                    $insert[$i] .= implode("$separateur,$separateur", $val);
                    $insert[$i] .= "$separateur)";                      
                //}
                $i++;
            }       
        return $insert;
    }
    
    function formatDate_FR_To_En($date, $separateurEntre, $separateurSortie){
        $tab1 = explode($separateurEntre, $date);
        $tab2 = array_reverse($tab1);
        $dateRetour = implode($separateurSortie,$tab2);
        return $dateRetour;
    }
    
    function formatDate_EN_To_FR($date, $separateurEntre, $separateurSortie){
        $tab1 = explode($separateurEntre, $date);
        $tab2 = array_reverse($tab1);
        $dateRetour = implode($separateurSortie,$tab2);
        return $dateRetour;
    }
    
    function HTMLPage_To_Print($requete){
       
    }