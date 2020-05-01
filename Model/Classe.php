<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/..";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";

class Classe implements Serializable {
    private $id;
    private $scuola;
    private $numero;
    private $sezione;
    private $annoScolastico;
    private $studenti;

    /**
     * @param id  
     * @param scuola istanza della classe Scuola
     * @param numero 
     * @param  sezione 
     * @param string $annoScolastico 
     * @param Studente[] $studenti array di istanze della classe Studente
     */
    public function __construct($id, $scuola, $numero, $sezione, $annoScolastico, $studenti = array()) {
        $this->id = $id;
        $this->scuola = $scuola;
        $this->numero = $numero;
        $this->sezione = $sezione;
        $this->annoScolastico = $annoScolastico;
        $this->studenti = $studenti;
    }

    public function getId() {
        return $this->id;
    }

    public function getScuola() {
        return $this->scuola;
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
        return serialize([$this->id, $this->scuola, $this->numero, $this->sezione,
         $this->annoScolastico, $this->studenti]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->scuola = $valori[1];
        $this->numero = $valori[2];
        $this->sezione = $valori[3];
        $this->annoScolastico = $valori[4];
        $this->studenti = $valori[5];
    }
}
?>