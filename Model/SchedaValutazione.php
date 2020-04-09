<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/..";
}
include_once "{$_SESSION['root']}/Model/Percorso.php";

class SchedaValutazione implements Serializable {
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

    public function getTabellaRecensore() {
        return $this->tabellaRecensore;
    }

    public function getIdRecensore() {
        return $this->idRecensore;
    }

    public function getTabellaRecensito() {
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

    public function serialize() {
        return serialize([$this->id, $this->tabellaRecensore, $this->idRecensore,
         $this->tabellaRecensito, $this->idRecensito, $this->idPercorso, $this->dataOra]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->tabellaRecensore = $valori[1];
        $this->idRecensore = $valori[2];
        $this->tabellaRecensito = $valori[3];
        $this->idRecensito = $valori[4];
        $this->idPercorso = $valori[5];
        $this->dataOra = $valori[6];
    }
}
?>