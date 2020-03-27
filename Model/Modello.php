<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Agenzia.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Azienda.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Famiglia.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";
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
     * @return Agenzia se è stata trovata, altrimenti null
     */
    public function getAgenziaDaEmail($email) {
        $query = "SELECT * FROM agenzie WHERE email_utente = '{$email}'";
        $ris = $this->connessione->query($query);
        $agenzia = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $agenzia = new Agenzia(
                $ris['id'],
                $ris['nome'],
                $email,
                $ris['stato'],
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
        $ris = $this->connessione->query($query);
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
        return $docente;
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
        return $docente;
    }
    
    /**
     * getDocentiDaScuola estrae dal database tutti i docenti di una scuola.
     *
     * @param Scuola $scuola scuola della quale estrarre gli studenti
     * @return Docente[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getDocentiDaScuola($scuola) {
        $query =<<<testo
        SELECT D.* FROM docenti D
            INNER JOIN docenti_scuole DS
            ON DS.id_docente = D.id
        WHERE DS.codice_scuola = '{$scuola->getId()}'
        testo;
        $ris = $this->connessione->query($query);
        $docenti = array();
        if ($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach($ris as $docente){
                $docenti[] = new Docente(
                    $docente['id'],
                    $docente['nome'],
                    $docente['cognome'],
                    $docente['email_utente']
                );
            }
        }
        return $docenti;
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
     * getStudentiDaClasse estrae dal database tutti gli studenti di una classe.
     *
     * @param int $idClasse id della classe dalla quale estrarre gli studenti
     *
     * @return Studente[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getStudentiDaClasse($idClasse) {
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
     * getStudentiDaScuola estrae dal database tutti gli studenti di una scuola.
     *
     * @param string $codiceMeccanografico codice meccanografico della scuola
     * per la quale estrarre gli studenti
     * @return Studente[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getStudentiDaScuola($codiceMeccanografico) {
        $query =<<<testo
        SELECT S.* FROM studenti S
            INNER JOIN classi_studenti CS
            ON CS.id_studente = S.id
            INNER JOIN classi C
            ON C.id = CS.id_classe
            INNER JOIN scuole SC
            ON SC.codice_meccanografico = C.codice_scuola
        WHERE SC.codice_meccanografico = '{$codiceMeccanografico}'
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
                $this->getScuolaDaCodice($ris['codice_scuola']),
                $ris['numero'],
                $ris['sezione'],
                $ris['anno_scolastico'],
                $this->getStudentiDaClasse($ris['id'])
            );
        }
        return $classe;
    }

    /**
     * getClassiDaScuola restitusice tutte le classi di una scuola.
     *
     * @param Scuola $scuola scuola per la quale estrarre le classi
     * @return Classe[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getClassiDaScuola($scuola) {
        $query = "SELECT * FROM classi WHERE codice_scuola = '{$scuola->getId()}' ORDER BY anno_scolastico DESC";
        $ris = $this->connessione->query($query);
        $classi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach ($ris as $classe){
                $classi[] = new Classe(
                    $classe['id'],
                    $scuola,
                    $classe['numero'],
                    $classe['sezione'],
                    $classe['anno_scolastico'],
                    $this->getStudentiDaClasse($classe['id'])
                );
            }
        }
        return $classi;
    }

    /**
     * getClassiDaDocente restitusice tutte le classi di un docente.
     *
     * @param Docente $docente docente per la quale estrarre le classi
     * @return Classe[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getClassiDaDocente($docente) {
        $query = "SELECT * FROM classi WHERE codice_scuola = '{$docente->getId()}' ORDER BY anno_scolastico DESC";
        $ris = $this->connessione->query($query);
        $classi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach ($ris as $classe){
                $classi[] = new Classe(
                    $classe['id'],
                    $scuola,
                    $classe['numero'],
                    $classe['sezione'],
                    $classe['anno_scolastico'],
                    $this->getStudentiDaClasse($classe['id'])
                );
            }
        }
        return $classi;
    }
    
    /**
     * getScuolaDaCodice estrae dal database una scuola.
     *
     * @param string $codiceMeccanografico codice meccanografico della scuola da estrarre
     * @return Scuola se è stata trovata, altrimenti null
     */
    public function getScuolaDaCodice($codiceMeccanografico) {
        $query = "SELECT * FROM scuole WHERE codice_meccanografico = '{$codiceMeccanografico}'";
        $ris = $this->connessione->query($query);
        $scuola = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $scuola = new Scuola(
                $codiceMeccanografico,
                $ris['nome'],
                $ris['email_utente'],
                $ris['citta'],
                $ris['indirizzo']
            );
        }
        return $scuola;
    }

    /**
     * getScuolaDaEmail estrae dal database una scuola.
     *
     * @param string $email email del responsabile della scuola da estrarre
     * @return Scuola se è stata trovata, altrimenti null
     */
    public function getScuolaDaEmail($email) {
        $query = "SELECT * FROM scuole WHERE email_utente = '{$email}'";
        $ris = $this->connessione->query($query);
        $scuola = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $scuola = new Scuola(
                $ris['codice_meccanografico'],
                $ris['nome'],
                $email,
                $ris['citta'],
                $ris['indirizzo']
            );
        }
        return $scuola;
    }

    /**
     * getEsperienzaDaId estrae dal database l'esperienza associata all'id dato.
     * 
     * @param int $id id dell'esperienza da estrarre
     * 
     * @return Esperienza se è stata trovata, altrimenti null
     */
    public function getEsperienzaDaId($id) {
        $query = "SELECT * FROM esperienze WHERE id = {$id}";
        $ris = $this->connessione->query($query);
        $esperienza = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $esperienza = new Esperienza(
                $id, 
                $this->getStudenteDaId($ris['id_studente']), 
                $this->getPercorsoDaId($ris['id_percorso']), 
                $this->getAziendaDaId($ris['id_azienda']), 
                $this->getAgenziaDaId($ris['id_agenzia']),
                $this->getFamigliaDaId($ris['id_famiglia']),
                $ris['dal'],
                $ris['al']
            );
        }
        return $esperienza;
    }
    
    /**
     * getEsperienzeDaAgenzia estrae dal database i dati delle esperienze con un id di un agenzia specificato
     * 
     * @param Agenzia $agenzia è l'agenzia per la quale voglio estrarre le esperienze
     */
    public function getEsperienzeDaAgenzia($agenzia){
        $query="SELECT * FROM esperienze WHERE id_agenzia = {$agenzia->getId()}";
        $ris = $this->connessione->query($query);
        $esperienze = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach($ris as $esperienza){
                $esperienze[] = new Esperienza(
                    $esperienza['id'],
                    $this->getStudenteDaId($esperienza['id_studente']),
                    $this->getPercorsoDaId($esperienza['id_percorso']),
                    $this->getAziendaDaId($esperienza['id_azienda']),
                    $agenzia,
                    $this->getFamigliaDaId($esperienza['id_famiglia']),
                    $esperienza['dal'],
                    $esperienza['al']
                );
            }
        } 
        return $esperienze;
    }

    /**
     * getEsperienzeDaStudente estrae dal database tutte le esperienze associate a uno studente.
     *
     * @param Studente $studente studente del quale estrarre le esperienze
     *
     * @return Esperienza[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getEsperienzeDaStudente($studente) {
        $query = "SELECT * FROM esperienze WHERE id_studente = {$studente->getId()} ORDER BY dal DESC";
        $ris = $this->connessione->query($query);
        $esperienze = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach ($ris as $esperienza) {
                $esperienze[] = new Esperienza(
                    $esperienza['id'],
                    $studente,
                    $this->getPercorsoDaId($esperienza['id_percorso']),
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
     * getEsperienzeDaAzienda estrae dal database tutte le esperienze associate ad un'azienda.
     *
     * @param Azienda $azienda azienda della quale estrarre le esperienze
     *
     * @return Esperienza[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getEsperienzeDaAzienda($azienda) {
        $query = "SELECT * FROM esperienze WHERE id_azienda = {$azienda->getId()} ORDER BY dal DESC";
        $ris = $this->connessione->query($query);
        $esperienze = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach ($ris as $esperienza) {
                $esperienze[] = new Esperienza(
                    $esperienza['id'],
                    $this->getStudenteDaId($esperienza['id_studente']),
                    $this->getPercorsoDaId($esperienza['id_percorso']),
                    $azienda,
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
     * getPercorsoDaId estrae dal database il percorso associato all'id specificato.
     *
     * @param int $id id del percorso da estrarre
     *
     * @return Percorso se è stato trovato, altrimenti null
     */
    public function getPercorsoDaId($id) {
        $query = "SELECT * FROM percorsi WHERE id = {$id}";
        $ris = $this->connessione->query($query);
        $percorso = null;
        if($ris && $ris->num_rows == 1){
            $ris = $ris->fetch_assoc();
            $percorso = new Percorso(
                $id,
                $this->getDocenteDaId($ris['id_docente']),
                $this->getClasseDaId($ris['id_classe']),
                $ris['dal'],
                $ris['al']
            );
        }
        return $percorso;
    }

    /**
     * getPercorsiDaDocente estrae dal database tutti i percorsi di 
     * PCTO ed Erasmus di un Docente.
     *
     * @param Docente $docente docente per il quale estrarre i percorsi
     * @return Percorso[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getPercorsiDaDocente($docente) {
        $query = "SELECT * FROM percorsi WHERE id_docente = {$docente->getId()}";
        $ris = $this->connessione->query($query);
        $percorsi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach ($ris as $percorso) {
                $percorsi[] = new Percorso(
                    $percorso['id'],
                    $docente,
                    $this->getClasseDaId($percorso['id_classe']),
                    $percorso['dal'],
                    $percorso['al']
                );
            }
        }
        return $percorsi;
    }
    
    /**
     * getPercorsiStudente estrae dal database tutti i percorsi di 
     * PCTO ed Erasmus ai quali ha pertecipato uno studente.
     *
     * @param Studente $studente studente per il quale estrarre i percorsi
     * @return Percorso[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getPercorsiDaStudente($studente) {
        $query =<<<testo
        SELECT P.* FROM studenti S
            INNER JOIN classi_studenti CS
                ON S.id = CS.id_studente
            INNER JOIN classi C
                ON CS.id_classe = C.id
            INNER JOIN percorsi P
                ON CS.id_classe = P.id_classe
        WHERE S.id = {$studente->getId()}
        testo;
        $ris = $this->connessione->query($query);
        $percorsi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach ($ris as $percorso) {
                $percorsi[] = new Percorso(
                    $percorso['id'],
                    $this->getDocenteDaId($percorso['id_docente']),
                    $this->getClasseDaId($percorso['id_classe']),
                    $ris['dal'],
                    $ris['al']
                );
            }
        }
        return $percorsi;
    }
    
    /**
     * getPercorsiDaScuola estrae tutti i percorsi effettuati dalle classe di una scuola.
     *
     * @param Scuola $scuola scuola perla quale estrarre i percorsi
     * @return Percorso[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getPercorsiDaScuola($scuola) {
        $query =<<<testo
        SELECT P.* FROM percorsi P
            INNER JOIN classi C
            ON C.id = P.id_classe
        WHERE C.codice_scuola = 'TVTF007017'
        testo;
        $ris = $this->connessione->query($query);
        $percorsi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_BOTH);
            foreach ($ris as $percorso) {
                $percorsi[] = new Percorso(
                    $percorso['id'],
                    $this->getDocenteDaId($percorso['id_docente']),
                    $this->getClasseDaId($percorso['id_classe']),
                    $percorso['dal'],
                    $percorso['al']
                );
            }
        }
        return $percorsi;
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
    public function insertAgenzia($agenzia) {
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
    public function insertAzienda($azienda) {
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
    public function insertDocente($docente) {
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
    public function insertFamiglia($famiglia) {
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
    public function insertStudente($studente) {
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
    
    public function modificaPassword($digest) {
        $query = "UPDATE utenti SET password='{$digest}' WHERE email='{$_SESSION["email_utente"]}'";
        $ris=$this->connessione->query($query);
        if($ris!=true){
            $ris=false;    
        }
        return $ris;
    }
}
?>