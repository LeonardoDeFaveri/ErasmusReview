<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Agenzia.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Azienda.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Famiglia.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";

class ContenitoreSoggettoDate {
    private $soggetto;
    private $dal;
    private $al;

    public function __construct($soggetto, $dal, $al) {
        $this->soggetto = $soggetto;
        $this->dal = $dal;
        $this->al = $al ?? "";
    }

    public function getSoggetto() {
        return $this->soggetto;
    }

    public function getDal() {
        return $this->dal;
    }

    public function getAl() {
        return $this->al;
    }

    public function serialize() {
        return serialize([$this->soggetto, $this->dal, $this->al]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->soggetto = $valori[0];
        $this->dal = $valori[1];
        $this->al = $valori[2];
    }
}
?>