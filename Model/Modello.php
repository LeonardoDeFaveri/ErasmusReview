<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Agenzia.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Azienda.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Famiglia.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Aspetto.php";
include_once "{$_SESSION['root']}/Model/Valutazione.php";
include_once "{$_SESSION['root']}/Model/SchedaValutazione.php";

class Modello {
    private $connessione;

    public function __construct() {
        $this->connessione = new mysqli("localhost", "root", "", "erasmus_advisor");
        if ($this->connessione->connect_errno != 0) {
            die("<h2>Errore nella connessione al server</h2>");
        }
        if ($this->connessione->errno != 0) {
            die("<h2>Errore nella connessione al database</h2>");
        }
    }

    /**
     * getListaStudenti restituisce la lista di tutti gli studenti.
     *
     * @return Studente[] lista di studenti
     */
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
    
    /**
     * verificaCredenziali verifica che le coppia email e password siano valide.
     *
     * @param  string $email indirizzo email
     * @param  string $password password
     *
     * @return string tipo di utente identificato, altrimenti false
     */
    public function verificaCredenziali($email, $password) {
        $query = "SELECT tipo_utente FROM utenti WHERE email = '{$email}' AND password = '{$password}'";
        $ris = $this->connessione->query($query);

        if($ris != false && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc()['tipo_utente'];
        }else{
            $ris = false;
        }
        return $ris;
    }

    /**
     * insertAgenzia inserisce un'agenzia nel database.
     *
     * @param Agenzia $agenzia istanza di classe Agenzia da inserire
     *
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertAgenzia($agenzia){
        $query = "INSERT INTO agenzie (nome, email_utente, stato, provincia, citta, telefono) VALUES (";
        $query .= "{$agenzia->getNome()}, ";
        $query .= "{$agenzia->getEmail()}, ";
        $query .= "{$agenzia->getStato()}, ";
        $query .= "{$agenzia->getProvincia()}, ";
        $query .= "{$agenzia->getCitta()}, ";
        $query .= "{$agenzia->getTelefono()})";

        $ris = $this->connessione->query($query);
        return $ris;
    }

    /**
     * insertAzienda inserisce un'azienda nel database.
     *
     * @param Azienda $azienda istanza di classe Azienda da inserire
     *
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertAzienda($azienda){
        $query = "INSERT INTO agenzie (nome, email_utente, stato, citta, indirizzo, telefono) VALUES (";
        $query .= "{$azienda->getNome()}, ";
        $query .= "{$azienda->getEmail()}, ";
        $query .= "{$azienda->getStato()}, ";
        $query .= "{$azienda->getCitta()}, ";
        $query .= "{$azienda->getIndirizzo()}, ";
        $query .= "{$azienda->getTelefono()})";

        $ris = $this->connessione->query($query);
        return $ris;
    }

    /**
     * insertDocente inserisce un docente nel database.
     *
     * @param Docente $docente istanza di classe Docente da inserire
     *
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertDocente($docente){
        $query = "INSERT INTO agenzie (nome, cognome, email_utente) VALUES (";
        $query .= "{$docente->getNome()}, ";
        $query .= "{$docente->getCognome()}";
        $query .= "{$docente->getEmail()})";
        
        $ris = $this->connessione->query($query);
        return $ris;
    }

    /**
     * insertFamiglia inserisce una famiglia nel database.
     *
     * @param Famiglia $famiglia istanza di classe Famiglia da inserire
     *
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertFamiglia($famiglia){
        $query = "INSERT INTO agenzie (nome, cognome, stato, citta, indirizzo) VALUES (";
        $query .= "{$famiglia->getNome()}, ";
        $query .= "{$famiglia->getCognome()}";
        $query .= "{$famiglia->getStato()}, ";
        $query .= "{$famiglia->getCitta()}, ";
        $query .= "{$famiglia->getIndirizzo()})";
        
        $ris = $this->connessione->query($query);
        return $ris;
    }

    /**
     * insertStudente inserisce uno studente nel database.
     *
     * @param Studente $studente istanza di classe Studente da inserire
     *
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertStudente($studente){
        $query = "INSERT INTO agenzie (nome, cognome, email_utente, data_nascita) VALUES (";
        $query .= "{$studente->getNome()}, ";
        $query .= "{$studente->getCognome()}";
        $query .= "{$studente->getEmail()}, ";
        $query .= "{$studente->getDataNascita()})";
        
        $ris = $this->connessione->query($query);
        return $ris;
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
?>