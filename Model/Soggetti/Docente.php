<?php
if(session_id() == ''){
        session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Docente extends Soggetto{
    private $cognome;
    private $scuola;
    
    public function __construct($id, $nome, $cognome, $scuola) {
        parent::__construct($id, $nome);
        $this->cognome = $cognome;
        $this->scuola = $scuola;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getScuola(){
        return $this->scuola;
    }
}

?>