<?php

abstract class Soggetto implements Serializable {
    protected $id;
    protected $nome;
    
    function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    /**
     * serialize serializza l'oggetto.
     *
     * @return string oggetto serializzato
     */
    public abstract function serialize();

    /**
     * unserialize deserializza l'oggetto e crea una nuova istanza.
     *
     * @param  string $stringa oggetto serializzato
     *
     * @return Soggetto nuovo oggetto
     */
    public abstract function unserialize($stringa);
}
?>