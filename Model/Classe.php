<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";

class Classe implements Serializable {
    private $id;
    private $codiceScuola;
    private $numero;
    private $sezione;
    private $annoScolastico;
    private $studenti;

    public function __construct($id, $codiceScuola, $numero, $sezione, $annoScolastico, $studenti = array()) {
        $this->id = $id;
        $this->codiceScuola = $codiceScuola;
        $this->numero = $numero;
        $this->sezione = $sezione;
        $this->annoScolastico = $annoScolastico;
        $this->studenti = $studenti;
    }

    public function getId() {
        return $this->id;
    }

    public function getCodiceScuola() {
        return $this->codiceScuola;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getSezione() {
        return $this->sezione;
    }

    public function getAnnoScolastico() {
        return $this->annoScolastico;
    }

    public function getStudenti() {
        return $this->studenti;
    }

    public function serialize() {
        return serialize([$this->id, $this->codiceScuola, $this->numero, $this->sezione,
         $this->annoScolastico, $this->studenti]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->codiceScuola = $valori[1];
        $this->numero = $valori[2];
        $this->sezione = $valori[3];
        $this->annoScolastico = $valori[4];
        $this->getStudenti = $valori[5];
    }
}
?>