<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Agenzia extends Soggetto {
    private $email;
    private $stato;
    private $citta;
    private $telefono;
    private $indirizzo;
    
    public function __construct($id, $nome, $email, $stato, $citta, $telefono, $indirizzo) {
        parent::__construct($id, $nome);
        $this->email = $email;
        $this->stato = $stato;
        $this->citta = $citta;
        $this->telefono = $telefono;
        $this->indirizzo = $indirizzo;
    }

    public function getEmail(){
        return $this->email;
    }
    
    public function getStato() {
        return $this->stato;
    }

    public function getCitta() {
        return $this->citta;
    }

    public function getTelefono() {
        return $this->telefono;
    }
    
    public function getIndirizzo() {
        return $this->indirizzo;
    }

    public function serialize() {
        return serialize([$this->id, $this->nome, $this->email, $this->stato,
         $this->citta, $this->telefono, $this->indirizzo]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->nome = $valori[1];
        $this->email = $valori[2];
        $this->stato = $valori[3];
        $this->citta = $valori[4];
        $this->telefono = $valori[5];
        $this->indirizzo = $valori[6];
    }
}
?>