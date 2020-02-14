<?php

class Valutazione {
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
}

?>
