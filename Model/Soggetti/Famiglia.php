<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Famiglia extends Soggetto {
    private $cognome;
    private $stato;
    private $citta;
    private $indirizzo;
    
    public function __construct($id, $nome, $cognome, $stato, $citta, $indirizzo) {
        parent::__construct($id, $nome);
        $this->cognome = $cognome;
        $this->stato = $stato;
        $this->citta = $citta;
        $this->indirizzo = $indirizzo;
    }

    public function getCognome() {
        return $this->cognome;
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

    public function serialize() {
        return serialize([$this->id, $this->nome, $this->cognome, $this->stato,
         $this->citta, $this->indirizzo]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->nome = $valori[1];
        $this->cognome = $valori[2];
        $this->stato = $valori[3];
        $this->citta = $valori[4];
        $this->indirizzo = $valori[5];
    }
}
?>