<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/..";
}

class ModelloSchedaValutazione implements Serializable {
    private $id;
    private $tipoRecensore;
    private $tipoRecensito;
    private $aspetti;

    public function _construct($id, $tipoRecensore, $tipoRecensito, $aspetti = array()) {
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
}
?>