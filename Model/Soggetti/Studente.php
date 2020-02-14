<?php

class Studente extends Soggetto {
    private $cognome;
    private $dataNascita;
    private $scuola;
    private $classe;

    public function __construct($id, $nome, $cognome, $dataNascita, $scuola, $classe) {
        parent::__construct($id, $nome);
        $this->cognome = $cognome;
        $this->dataNascita = $dataNascita;
        $this->scuola = $scuola;
        $this->classe = $classe;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getDataNascita() {
        return $this->dataNascita;
    }

    public function getScuola() {
        return $this->scuola;
    }

    public function getClasse() {
        return $this->classe;
    }
}
?>