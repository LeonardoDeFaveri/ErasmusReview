<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/..";
}

class ModelloSchedaDiValutazione implements Serializable {
    private $id;
    private $tipoRecensore;
    private $tipoRecensito;
    private $aspetti;

    public function __construct($id, $tipoRecensore, $tipoRecensito, $aspetti = array()) {
        $this->id = $id;
        $this->tipoRecensore = $tipoRecensore;
        $this->tipoRecensito = $tipoRecensito;
        $this->aspetti = $aspetti;
    }

    public function getId() {
        return $this->id;
    }

    public function getTipoRecensore() {
        return $this->tipoRecensore;
    }

    public function getTipoRecensito() {
        return $this->tipoRecensito;
    }

    public function getAspetti() {
        return $this->aspetti;
    }

    public function serialize() {
        return serialize([$this->id, $this->tipoRecensore, $this->tipoRecensito, $this->aspetti]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->tipoRecensore = $valori[1];
        $this->tipoRecensito = $valori[2];
        $this->aspetti = $valori[3];
    }
}
?>