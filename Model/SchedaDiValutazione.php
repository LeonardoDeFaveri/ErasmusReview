<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/..";
}
include_once "{$_SESSION['root']}/Model/Esperienza.php";
include_once "{$_SESSION['root']}/Model/Valutazione.php";

class SchedaDiValutazione implements Serializable {
    private $id;
    private $tipoRecensore;
    private $idRecensore;
    private $tipoRecensito;
    private $idRecensito;
    private $esperienza;
    private $dataOra;
    private $valutazioni;
    
    public function __construct($id, $tipoRecensore, $idRecensore, $tipoRecensito, $idRecensito, $esperienza, $dataOra, $valutazioni = array()) {
        $this->id = $id;
        $this->idRecensore = $idRecensore;
        $this->idRecensito = $idRecensito;
        $this->esperienza = $esperienza;
        $this->dataOra = $dataOra;
        $this->valutazioni = $valutazioni;
    }
    
    public function getId() {
        return $this->id;
    }

    public function gettipoRecensore() {
        return $this->tipoRecensore;
    }

    public function getIdRecensore() {
        return $this->idRecensore;
    }

    public function gettipoRecensito() {
        return $this->tipoRecensito;
    }

    public function getIdRecensito() {
        return $this->idRecensito;
    }

    public function getEsperienza() {
        return $this->esperienza;
    }

    public function getDataOra() {
        return $this->dataOra;
    }

    public function getValutazioni(){
        return $this->valutazioni;
    }

    public function serialize() {
        return serialize([$this->id, $this->tipoRecensore, $this->idRecensore,
         $this->tipoRecensito, $this->idRecensito, $this->esperienza,
         $this->dataOra, $this->valutazioni]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->tipoRecensore = $valori[1];
        $this->idRecensore = $valori[2];
        $this->tipoRecensito = $valori[3];
        $this->idRecensito = $valori[4];
        $this->esperienza = $valori[5];
        $this->dataOra = $valori[6];
        $this->valutazioni = $valori[7];
    }
}
?>