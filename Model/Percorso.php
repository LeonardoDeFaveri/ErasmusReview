<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

class Percorso implements Serializable {
    private $id;
    private $docente;
    private $classe;
    private $esperienze;

    public function __construct($id, $docente, $classe, $esperienze = array()) {
        $this->id = $id;
        $this->docente = $docente;
        $this->classe = $classe;
        $this->esperienze = $esperienze;
    }

    public function getId() {
        return $this->id;
    }

    public function getDocente() {
        return $this->docente;
    }

    public function getClasse() {
        return $this->classe;
    }

    public function getEsperienze() {
        return $this->esperienze;
    }

    public function serialize() {
        return serialize([$this->id, $this->docente, $this->classe, $this->esperienze]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->docente = $valori[1];
        $this->classe = $valori[2];
        $this->esperienze = $valori[3];
    }
}
?>