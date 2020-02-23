<?php

class ConnessioneDB {

    private $connessione;

    public function __construct() {
        $this->connessione = new mysqli("localhost", "root", "");
        if ($this->connessione->connect_errno != 0) {
            die("Errore di connessione con db");
        }
    }

    public function getListaStudenti() {
        $query = "SELECT * FROM utenti";
        $studenti = array();
        $ris = $this->connessione->query($query);
        if($ris){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
            
            foreach ($ris as $studente){
                $studenti[] = new Studente(
                    $studente['cognome'],
                    $studente['data_nascita'],
                    $studente['id'],
                    $studente['nome'],
                    $studente['email_utente']
                );
            }
        }
        return $studenti;
    }
    
    public function verificaCredenziali($email, $password){
        $query = "SELECT tipo_utente FROM utenti WHERE email = '{$email}' AND password = '{$password}'";
        $ris = $this->connessione->query($query);
        
        if($ris != false && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc()['tipo_utente'];
        }
        return $ris;
    }

    public function insert($soggetto) {
        $classe = get_class($soggetto);
        switch ($classe) {
            case 'Agenzia':
                break;
            case 'Azienda':
                break;
            case 'Docente':
                break;
            case 'Famiglia':
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
