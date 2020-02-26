<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";

class Classe{
    private $id;
    private $codiceScuola;
    private $numero;
    private $sezione;
    private $annoScolastico;
    private $studenti;

    public function __construct($id, $codiceScuola, $numero, $sezione, $annoScolastico, $studenti = array()){
        $this->id = $id;
        $this->codiceScuola = $codiceScuola;
        $this->numero = $numero;
        $this->sezione = $sezione;
        $this->annoScolastico = $annoScolastico;
        $this->studenti = $studenti;
    }

    public function getId(){
        return $this->id;
    }

    public function getCodiceScuola(){
        return $this->codiceScuola;
    }

    public function getNumero(){
        return $this->numero;
    }

    public function getSezione(){
        return $this->sezione;
    }

    public function getAnnoScolastico(){
        return $this->annoScolastico;
    }

    public function getStudenti(){
        return $this->studenti;
    }
}
?>