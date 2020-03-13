<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Classe.php";

class Percorso implements Serializable {
    private $id;
    private $docente;
    private $classe;
    private $dal;
    private $al;

    public function __construct($id, $docente, $classe, $dal, $al) {
        $this->id = $id;
        $this->docente = $docente;
        $this->classe = $classe;
        $this->dal = $dal;
        $this->al = $al;
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

    public function getDal() {
        return $this->dal;
    }

    public function getAl() {
        return $this->al;
    }

    public function serialize() {
        return serialize([$this->id, $this->docente, $this->classe, $this->dal, $this->al]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->docente = $valori[1];
        $this->classe = $valori[2];
        $this->dal = $valori[3];
        $this->al = $valori[4];
    }
}
?>