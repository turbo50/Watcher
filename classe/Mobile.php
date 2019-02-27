<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mobile
 *
 * @author LENGUE
 */
class Mobile {
    private $nomUser,$numero,$imeiSim;
    
    function getNomUser() {
        return $this->nomUser;
    }

    function getNumero() {
        return $this->numero;
    }

    function getImeiSim() {
        return $this->imeiSim;
    }

    function setNomUser($nomUser) {
        $this->nomUser = $nomUser;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setImeiSim($imeiSim) {
        $this->imeiSim = $imeiSim;
    }

    function TableListeMobile(){
        echo ' <table id="mobile_grid" class="display" width="100%" cellspacing="0">';
        echo '<thead><tr><th>Nom du détenteur</th><th>Numéro</th><th>Imei de la SIM</th><th>Carte</th><th>Editer</th><th>Historique</th><th>Itin&eacute;raire</th></tr></thead>';
        echo '<tfoot><tr><th>Nom du détenteur</th><th>Numéro</th><th>Imei de la SIM</th><th>Carte</th><th>Editer</th><th>Historique</th><th>Itin&eacute;raire</th></tr></tfoot>';

    }
    
}
