<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Azienda.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Famiglia.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";

class Esperienza implements Serializable {
    private $id;
    private $studente;
    private $percorso;
    private $azienda;
    private $agenzia;
    private $famiglia;
    private $dal;
    private $al;

    public function __construct($id, $studente, $percorso, $azienda, $agenzia, $famiglia, $dal, $al) {
        $this->id = $id;
        $this->studente = $studente;
        $this->percorso = $percorso;
        $this->azienda = $azienda;
        $this->agenzia = $agenzia;
        $this->famiglia = $famiglia;
        $this->dal = $dal;
        $this->al = $al;
    }

    public function getId() {
        return $this->id;
    }

    public function getStudente() {
        return $this->studente;
    }

    public function getPercorso() {
        return $this->percorso;
    }

    public function getAzienda() {
        return $this->azienda;
    }

    public function getAgenzia() {
        return $this->agenzia;
    }

    public function getFamiglia() {
        return $this->famiglia;
    }

    public function getDal() {
        return $this->dal;
    }

    public function getAl() {
        return $this->al;
    }

    public function serialize() {
        return serialize([$this->id, $this->studente, $this->percorso, $this->azienda, 
         $this->agenzia, $this->famiglia, $this->dal, $this->al]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->studente = $valori[1];
        $this->percorso = $valori[2];
        $this->azienda = $valori[3];
        $this->agenzia = $valori[4];
        $this->famiglia = $valori[5];
        $this->dal = $valori[6];
        $this->al = $valori[7];
    }
}
?>