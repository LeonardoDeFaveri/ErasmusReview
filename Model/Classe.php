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
     * __construct crea una nuova classe.
     *
     * @param  int $id identificativo della classe
     * @param  Scuola $scuola riferimento alla scuola associata alla classe
     * @param  int $numero numero della classe
     * @param  string $sezione sezione della classe
     * @param  string $annoScolastico anno scolastico della classe (anno/anno)
     * @param  Studente[] $studenti array contenente tutit gli studenti della classe
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