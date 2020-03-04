<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Agenzia.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Azienda.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Famiglia.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Aspetto.php";
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";
include_once "{$_SESSION['root']}/Model/Valutazione.php";
include_once "{$_SESSION['root']}/Model/SchedaValutazione.php";

class Modello {
    private $connessione;

    public function __construct(){
        $this->connessione = new mysqli("localhost", "root", "", "erasmus_advisor");
        if ($this->connessione->connect_errno != 0) {
            throw new Exception("Server non raggungibile");
        }
        if ($this->connessione->errno != 0) {
            throw new Exception("Database non raggiungibile");
        }
    }

    /**
     * getAziendaDaId estrae dal database l'azienda associata all'id specificato.
     *
     * @param int $id id dell'azienda da estrarre
     *
     * @return Azienda se è stata trovata, altirmenti null
     */
    public function getAgenziaDaId($id) {
        $query = "SELECT * FROM agenzie WHERE id = {$id}";
        $ris = $this->connessione->query($query);
        $agenzia = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $agenzia = new Agenzia(
                $id,
                $ris['nome'],
                $ris['email_utente'],
                $ris['stato'],
                $ris['citta'],
                $ris['telefono']
            );
        }
        return $agenzia;
    }

    /**
     * getAgenziaDaEmail estrae dal database l'agenzia associata all'email specificata.
     *
     * @param string $email email dell'agenzia da estrarre
     *
     * @return Agenzia se è stata trovata, altirmenti null
     */
    public function getAgenziaDaEmail($email) {
        $query = "SELECT * FROM agenzie WHERE email_utente = '{$email}'";
        $ris = $this->connessione->query($quey);
        $agenzia = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $agenzia = new Agenzia(
                $ris['id'],
                $ris['nome'],
                $email,
                $ris['stato'],
                $ris['provincia'],
                $ris['citta'],
                $ris['telefono']
            );
        }
        return $agenzia;
    }

    /**
     * getAziendaDaid estrae dal database l'azienda associata all'id specificato.
     *
     * @param int $id id dell'azienda da estrarre
     *
     * @return Azienda se è stata trovata, altirmenti null
     */
    public function getAziendaDaId($id) {
        $query = "SELECT * FROM aziende WHERE id = {$id}";
        $ris = $this->connessione->query($query);
        $azienda = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $azienda = new Azienda(
                $id,
                $ris['nome'],
                $ris['email_utente'],
                $ris['stato'],
                $ris['citta'],
                $ris['indirizzo'],
                $ris['telefono']
            );
        }
        return $azienda;
    }

    /**
     * getAziendaDaEmail estrae dal database l'azienda associata all'email specificata.
     *
     * @param string $email email dell'azienda da estrarre
     *
     * @return Azienda se è stata trovata, altirmenti null
     */
    public function getAziendaDaEmail($email) {
        $query = "SELECT * FROM aziende WHERE email_utente = '{$email}'";
        $ris = $this->connessione->query($quey);
        $azienda = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $azienda = new Azienda(
                $ris['id'],
                $ris['nome'],
                $email,
                $ris['stato'],
                $ris['citta'],
                $ris['indirizzo'],
                $ris['telefono']
            );
        }
        return $azienda;
    }

    /**
     * getDocenteDaId estrae dal database il docente associato all'id specificato.
     *
     * @param int $id id del docente da estrarre
     *
     * @return Docente se è stato trovato, altrimenti null
     */
    public function getDocenteDaId($id) {
        $query = "SELECT * FROM docenti WHERE id = {$id}";
        $ris = $this->connessione->query($query);
        $docente = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $docente = new Docente(
                $id,
                $ris['nome'],
                $ris['cognome'],
                $ris['email_utente']
            );
        }
    }

    /**
     * getDocenteDaEmail estrae dal database il docente associato all'email specificata.
     *
     * @param string $email email del docente da estrarre
     *
     * @return Docente se è stato trovato, altrimenti null
     */
    public function getDocenteDaEmail($email) {
        $query = "SELECT * FROM docenti WHERE email_utente = '{$email}'";
        $ris = $this->connessione->query($query);
        $docente = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $docente = new Docente(
                $ris['id'],
                $ris['nome'],
                $ris['cognome'],
                $email
            );
        }
    }

    /**
     * getFamigliaDaId estrae dal database la famiglia associato all'id specificato.
     *
     * @param  int $id id della famiglia da estrarre
     *
     * @return Famiglia se è stata trovata, altirmenti null
     */
    public function getFamigliaDaId($id) {
        $query = "SELECT * FROM famiglie WHERE id = {$id}";
        $ris = $this->connessione->query($query);
        $famiglia = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $famiglia = new Famiglia(
                $id,
                $ris['nome'],
                $ris['cognome'],
                $ris['stato'],
                $ris['citta'],
                $ris['indirizzo']
            );
        }
        return $famiglia;
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
                    $studente['id'],
                    $studente['nome'],
                    $studente['cognome'],
                    $studente['email_utente'],
                    $studente['data_nascita']
                );
            }
        }
        return $studenti;
    }

    /**
     * getStudenteDaId estrae dal database lo studente associato all'id specificato.
     *
     * @param int $id id dello studente da estrarre
     *
     * @return Studente se è stato trovato, altirmenti null
     */
    public function getStudenteDaId($id) {
        $query = "SELECT * FROM studenti WHERE id = $id";
        $ris = $this->connessione->query($query);
        $studente = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $studente = new Studente(
                $id,
                $ris['nome'],
                $ris['cognome'],
                $ris['email_utente'],
                $ris['data_nascita']
            );
        }
        return $studente;
    }

    /**
     * getStudenteDaEmail estrae dal database lo studente associato all'email specificata.
     *
     * @param string $email email dello studente da estrarre
     *
     * @return Studente se è stato trovato, altirmenti null
     */
    public function getStudenteDaEmail($email) {
        $query = "SELECT * FROM studenti WHERE email_utente = '{$email}'";
        $ris = $this->connessione->query($query);
        $studente = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $studente = new Studente(
                $ris['id'],
                $ris['nome'],
                $ris['cognome'],
                $email,
                $ris['data_nascita']
            );
        }
        return $studente;
    }

    /**
     * getStudentiClasse estrae dal database tutti gli studenti di una classe.
     *
     * @param int $idClasse id della classe dalla quale estrarre gli studenti
     *
     * @return Studente[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getStudentiClasse($idClasse) {
        $query =<<<testo
            SELECT S.* FROM classi_studenti CS
                INNER JOIN studenti S
                    ON CS.id_studente = S.id
            WHERE CS.id_classe = {$idClasse}
            ORDER BY S.cognome, S.nome;
        testo;
        $ris = $this->connessione->query($query);
        $studenti = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach ($ris as $studente) {
                $studenti[] = new Studente(
                    $studente['id'],
                    $studente['nome'],
                    $studente['cognome'],
                    $studente['email_utente'],
                    $studente['data_nascita']
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
     * getClasseDaId estrae dal database una classe e i relativi studenti.
     *
     * @param int $id id della classe da estrarre
     *
     * @return Classe se è stata trovata, altrimenti null
     */
    public function getClasseDaId($id) {
        $query = "SELECT * FROM classi WHERE id = {$id}";
        $ris = $this->connessione->query($query);
        $classe = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $classe = new Classe(
                $id,
                $ris['codice_scuola'],
                $ris['numero'],
                $ris['sezione'],
                $ris['anno_scolastico'],
                $this->getStudentiClasse($ris['id'])
            );
        }
    }

    /**
     * getEsperienze estrae dal database tutte le esperienze associate a uno studente.
     *
     * @param Studente $studente studente del quale estrarre le esperienze
     *
     * @return Esperienza[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getEsperienze($studente) {
        $query = "SELECT * FROM esperienze WHERE id_studente = {$studente->getId()} ORDER BY dal DESC";
        $ris_esperienze = $this->connessione->query($query);
        $esperienze = array();
        if($ris_esperienze && $ris_esperienze->num_rows > 0){
            $ris_esperienze = $ris_esperienze->fetch_all(MYSQLI_BOTH);
            foreach ($ris_esperienze as $esperienza) {
                $esperienze[] = new Esperienza(
                    $esperienza['id'],
                    $studente,
                    $this->getPercorso($esperienza['id_percorso']),
                    $this->getAziendaDaId($esperienza['id_azienda']),
                    $this->getAgenziaDaId($esperienza['id_agenzia']),
                    $this->getFamigliaDaId($esperienza['id_famiglia']),
                    $esperienza['dal'],
                    $esperienza['al']
                );
            }
        }
        return $esperienze;
    }

    /**
     * getPercorso estrae dal database il percorso associato all'id specificato.
     *
     * @param int $id id del percorso da estrarre
     *
     * @return Percorso se è stato trovato, altrimenti null
     */
    public function getPercorso($id) {
        $query = "SELECT * FROM percorsi WHERE id = {$id}";
        $ris = $this->connessione->query($query);
        $percorso = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $percorso = new Percorso(
                $id,
                $this->getDocenteDaId($ris['id_docente']),
                $this->getClasseDaId($ris['id_classe'])
            );
        }
        return $percorso;
    }
    
    /**
     * getPercorsiStudente estrae dal database tutti i percorsi di 
     * PCTO ed Erasmus ai quali ha pertecipato uno studente.
     *
     * @param Studente $studente studente per il quale estrarre i percorsi
     * @return Percorso[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getPercorsiStudente($studente){
        $query =<<<testo
        SELECT P.* FROM studenti S
            INNER JOIN classi_studenti CS
                ON S.id = CS.id_studente
            INNER JOIN classi C
                ON CS.id_classe = C.id
            INNER JOIN percorsi P
                ON CS.id_classe = P.id_classe
        WHERE S.id = 1
        testo;
        $ris = $this->connessione->query($query);
        $percorsi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach ($ris as $percorso) {
                $percorsi[] = new Percorso(
                    $percorso['id'],
                    $this->getDocenteDaId($percorso['id_docente']),
                    $this->getClasseDaId($percorso['id_classe'])
                );
            }
        }
        return $percorsi;
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