<?php
abstract class Soggetto{
    private $id;
    private $nome;
    
    function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }
    
    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }
    
}
?>

