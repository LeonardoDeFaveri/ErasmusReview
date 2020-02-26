<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Classe.php";

class Percorso{
    private $id;
    private $docente;
    private $classe;
    private $esperienze;

    public function __construct($id, $docente, $classe, $esperienze = array()){
        $this->id = $id;
        $this->docente = $docente;
        $this->classe = $classe;
        $this->esperienze = $esperienze;
    }

    public function getId(){
        return $this->id;
    }

    public function getDocente(){
        return $this->docente;
    }

    public function getClasse(){
        return $this->classe;
    }

    public function getEsperienze(){
        return $this->esperienze;
    }
}
?>