<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/Model/SchedaValutazione.php";
include_once "{$_SESSION['root']}/Model/Aspetto.php";

class Valutazione implements Serializable {
    private $id;
    private $schedaValutazione;
    private $voto;
    private $aspetto;
    
    public function __construct($id, $schedaValutazione, $voto, $aspetto) {
        $this->id = $id;
        $this->schedaValutazione = $schedaValutazione;
        $this->voto = $voto;
        $this->aspetto = $aspetto;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getSchedaValutazione() {
        return $this->schedaValutazione;
    }

    public function getVoto() {
        return $this->voto;
    }

    public function getAspetto() {
        return $this->aspetto;
    }

    public function serialize() {
        return serialize([$this->id, $this->schedaValutazione, $this->voto, $this->aspetto]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->schedaValutazione = $valori[1];
        $this->voto = $valori[2];
        $this->aspetto = $valori[3];
    }
}
?>