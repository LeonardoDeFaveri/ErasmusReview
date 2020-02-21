<?php

class ConnessioneDB {

    private $connessione;

    public function __construct() {
        $this->connessione = new mysqli("localhost", "root", "");
        if ($this->connessione->connect_errno != 0) {
            die("Errore di connessione con db");
        }
    }

    public function select() {
        
    }

    public function insert($soggetto) {
        $classe = get_class($soggetto);
        switch ($classe) {
            case 'Agenzia':
                break;
            case 'Azienda':
                break;
        }



        $query = "INSERT INTO $tabella (";
        foreach ($arrayCampi as $elemento) {
            $query .= "$elemento, ";
        }
        $query = substr($query, 0, (strlen($query) - 2));
        $query .= ") VALUES (";
        foreach ($arrayValori as $elemento) {
            $query .= "$elemento, ";
        }
        $query = substr($query, 0, (strlen($query) - 2));

        $valore = $this->connessione->query($query);
        return $valore;
    }

    public function update($tabella, $arrayCampi, $arrayValori, $arrayClausole) {
        $query = "UPDATE $tabella SET ";
        for ($i = 0; count($arrayCampi); $i++) {
            $query .= $arrayCampi[$i] . "=" . $arrayValori[$i];
            $query .= ", ";
        }
        $query = substr($query, 0, (strlen($query) - 2));

        $query .= ") VALUES (";
        foreach ($arrayValori as $elemento) {
            $query .= "$elemento, ";
        }
        $query = substr($query, 0, (strlen($query) - 2));

        $valore = $this->connessione->query($query);
        return $valore;
    }

}
