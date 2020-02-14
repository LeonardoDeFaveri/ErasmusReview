<?php

class Azienda extends Soggetto{
    private $stato;
    private $citta;
    private $indirizzo;
    private $telefono;
    
    public function __construct($id, $nome, $stato, $citta, $indirizzo, $telefono) {
        parent::__construct($id, $nome);
        $this->id = $id;
        $this->nome = $nome;
        $this->stato = $stato;
        $this->citta = $citta;
        $this->indirizzo = $indirizzo;
        $this->telefono = $telefono;
    }

    public function getStato() {
        return $this->stato;
    }

    public function getCitta() {
        return $this->citta;
    }

    public function getIndirizzo() {
        return $this->indirizzo;
    }

    public function getTelefono() {
        return $this->telefono;
    }

}

?>