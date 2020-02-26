<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Azienda.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Famiglia.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";

class Esperienza{
    private $id;
    private $studente;
    private $percorso;
    private $azienda;
    private $famiglia;
    private $dal;
    private $al;

    public function __construct($id, $studente, $percorso, $azienda, $famiglia, $dal, $al){
        $this->id = $id;
        $this->studente = $studente;
        $this->percorso = $percorso;
        $this->azienda = $azienda;
        $this->famiglia = $famiglia;
        $this->dal = $dal;
        $this->al = $al;
    }

    public function getId(){
        return $this->id;
    }

    public function getStudente(){
        return $this->studente;
    }

    public function getPercorso(){
        return $this->percorso;
    }

    public function getAzienda(){
        return $this->azienda;
    }

    public function getFamiglia(){
        return $this->famiglia;
    }

    public function getDal(){
        return $this->dal;
    }

    public function getAl(){
        return $this->al;
    }
}
?>