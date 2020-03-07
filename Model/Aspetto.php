<?php

class Aspetto implements Serializable {
    private $id;
    private $nome;
    
    public function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function serialize() {
        return serialize([$this->id, $this->nome]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->nome = $valori[1];
    }
}
?>