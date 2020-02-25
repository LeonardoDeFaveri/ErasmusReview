<?php
if(session_id() == ''){
        session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Studente extends Soggetto {
    private $cognome;
    private $dataNascita;
    private $scuola;
    private $classe;

    public function __construct(int $id, string $nome, string $cognome, string $dataNascita, string $scuola, string $classe) {
        parent::__construct($id, $nome);
        $this->cognome = $cognome;
        $this->dataNascita = $dataNascita;
        $this->scuola = $scuola;
        $this->classe = $classe;
    }

    public function getCognome(): string {
        return $this->cognome;
    }

    public function getDataNascita(): string {
        return $this->dataNascita;
    }

    public function getScuola(): string {
        return $this->scuola;
    }

    public function getClasse(): string {
        return $this->classe;
    }
}
?>