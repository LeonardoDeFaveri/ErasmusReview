<?php

class SchedaValutazione {
    private $id;
    private $tabellaRecensore;
    private $idRecensore;
    private $tabellaRecensito;
    private $idRecensito;
    private $percorso;
    private $dataOra;
    
    public function __construct($id, $tabellaRecensore, $idRecensore, $tabellaRecensito, $idRecensito, $idPercorso, $dataOra) {
        $this->id = $id;
        $this-$idRecensore = $idRecensore;
        $this->idRecensito = $idRecensito;
        $this->percorso = $percorso;
        $this->data = $data;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTabellaRecensore(){
        return $this->tabellaRecensore;
    }

    public function getIdRecensore() {
        return $this->idRecensore;
    }

    public function getTabellaRecensito(){
        return $this->tabellaRecensito;
    }

    public function getIdRecensito() {
        return $this->idRecensito;
    }

    public function getIdPercorso() {
        return $this->idPercorso;
    }

    public function getDataOra() {
        return $this->dataOra;
    }
}
?>