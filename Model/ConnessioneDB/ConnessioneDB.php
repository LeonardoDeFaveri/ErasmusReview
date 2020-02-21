<?php
class ConnessioneDB{
    private $connessione;
    
    public function __construct() {
        $this->connessione=new mysqli("localhost","root","");
        if($this->connessione->connect_errno!=0){
            die("Errore di connessione con db");
        }
    }
    
    public function select() {
        
    }
    public function insert($arrayCampi,$arrayValori) {   
        $query="INSERT INTO ";
        
        
        return $valore;
    }            
            
}