<?php
if(session_id() == ''){
        session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Agenzia extends Soggetto{
    private $stato;
    private $provincia;
    private $citta;
    private $telefono;
    
    public function __construct($id, $nome, $stato, $provincia, $citta, $telefono) {
        parent::__construct($id,$nome);
        $this->stato = $stato;
        $this->provincia = $provincia;
        $this->citta = $citta;
        $this->telefono = $telefono;
    }
    
    public function getStato() {
        return $this->stato;
    }

    public function getProvincia() {
        return $this->provincia;
    }

    public function getCitta() {
        return $this->citta;
    }

    public function getTelefono() {
        return $this->telefono;
    }

}

?>