<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Azienda extends Soggetto {
    private $email;
    private $stato;
    private $citta;
    private $indirizzo;
    private $telefono;
    
    public function __construct($id, $nome, $email, $stato, $citta, $indirizzo, $telefono) {
        parent::__construct($id, $nome);
        $this->email = $email;
        $this->stato = $stato;
        $this->citta = $citta;
        $this->indirizzo = $indirizzo;
        $this->telefono = $telefono;
    }

    public function getEmail() {
        return $this->email;
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

    public function serialize() {
        return serialize([$this->id, $this->nome, $this->email, $this->stato,
         $this->citta, $this->indirizzo, $this->telefono]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->nome = $valori[1];
        $this->email = $valori[2];
        $this->stato = $valori[3];
        $this->citta = $valori[4];
        $this->indirizzo = $valori[5];
        $this->telefono = $valori[6];
    }
}
?>