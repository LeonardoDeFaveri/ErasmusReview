<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/..";
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
        $this->connessione = new mysqli("localhost", "root", "", "erasmus_review");
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
     * @param  int $id id dell'azienda da estrarre
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
                $ris['telefono'],
                $ris['indirizzo']
            );
        }
        return $agenzia;
    }

    /**
     * getAgenziaDaEmail estrae dal database l'agenzia associata all'email specificata.
     *
     * @param  string $email email dell'agenzia da estrarre
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
                $ris['telefono'],
                $ris['indirizzo']
            );
        }
        return $agenzia;
    }
    /**
     * getAziendaDaid estrae dal database l'azienda associata all'id specificato.
     *
     * @param  int $id id dell'azienda da estrarre
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
     * @param  string $email email dell'azienda da estrarre
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
     * @param  int $id id del docente da estrarre
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
     * @param  string $email email del docente da estrarre
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
     * @param  Scuola $scuola scuola della quale estrarre gli studenti
     * @return Docente[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getDocentiDaScuola($scuola) {
        $query =<<<testo
        SELECT D.* FROM docenti D
            INNER JOIN docenti_scuole DS
            ON DS.id_docente = D.id
        WHERE DS.codice_scuola = '{$scuola->getId()}'
        ORDER BY D.cognome, D.nome
        testo;
        $ris = $this->connessione->query($query);
        $docenti = array();
        if ($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * @param  int $id id dello studente da estrarre
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
     * @param  string $email email dello studente da estrarre
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
     * @param  int $idClasse id della classe dalla quale estrarre gli studenti
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
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * @param  string $codiceMeccanografico codice meccanografico della scuola
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
        ORDER BY S.cognome, S.nome
        testo;
        $ris = $this->connessione->query($query);
        $studenti = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * @param  int $id id della classe da estrarre
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
     * @param  Scuola $scuola scuola per la quale estrarre le classi
     * @return Classe[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getClassiDaScuola($scuola) {
        $query = "SELECT * FROM classi WHERE codice_scuola = '{$scuola->getId()}' ORDER BY anno_scolastico DESC";
        $ris = $this->connessione->query($query);
        $classi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * @param  Docente $docente docente per il quale estrarre le classi
     * @return Classe[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getClassiDaDocente($docente) {
        $query =<<<testo
        SELECT C.* FROM classi C
            INNER JOIN classi_docenti CD
            ON CD.id_classe = C.id
        WHERE CD.id_docente = {$docente->getId()}
        ORDER By C.anno_scolastico DESC
        testo;
        $ris = $this->connessione->query($query);
        $classi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
            foreach ($ris as $classe){
                $classi[] = new Classe(
                    $classe['id'],
                    $this->getScuolaDaCodice($classe['codice_scuola']),
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
     * @param  string $codiceMeccanografico codice meccanografico della scuola da estrarre
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
     * @param  string $email email del responsabile della scuola da estrarre
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
     * getScuole estrae dal database tutte le scuole.
     *
     * @return Scuola[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getScuole(){
        $query = "SELECT * FROM scuole";
        $ris = $this->connessione->query($query);
        $scuole = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
            foreach($ris as $scuola){
                $scuole[] = new Scuola(
                    $scuola["codice_meccanografico"],
                    $scuola["nome"],
                    $scuola["email_utente"],
                    $scuola["citta"],
                    $scuola["indirizzo"]
                );
            }
        }
        return $scuole;
    }

    /**
     * getEsperienzaDaId estrae dal database l'esperienza associata all'id dato.
     * 
     * @param  int $id id dell'esperienza da estrarre
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
     * getEsperienzeDaAgenzia estrae dal database tutte le esperienze
     * associate ad un'agenzia.
     * 
     * @param  Agenzia $agenzia agenzia per la quale estrarre le esperienze
     * @return Agenzia[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getEsperienzeDaAgenzia($agenzia){
        $query="SELECT * FROM esperienze WHERE id_agenzia = {$agenzia->getId()} ORDER BY dal DESC";
        $ris = $this->connessione->query($query);
        $esperienze = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * @param  Studente $studente studente del quale estrarre le esperienze
     * @return Esperienza[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getEsperienzeDaStudente($studente) {
        $query = "SELECT * FROM esperienze WHERE id_studente = {$studente->getId()} ORDER BY dal DESC";
        $ris = $this->connessione->query($query);
        $esperienze = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * @param  Azienda $azienda azienda della quale estrarre le esperienze
     * @return Esperienza[] se ne sono state trovate, altrimenti un array vuoto
     */
    public function getEsperienzeDaAzienda($azienda) {
        $query = "SELECT * FROM esperienze WHERE id_azienda = {$azienda->getId()} ORDER BY dal DESC";
        $ris = $this->connessione->query($query);
        $esperienze = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * @param  int $id id del percorso da estrarre
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
     * PCTO ed Erasmus associati a un Docente.
     *
     * @param  Docente $docente docente per il quale estrarre i percorsi
     * @return Percorso[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getPercorsiDaDocente($docente) {
        $query = "SELECT * FROM percorsi WHERE id_docente = {$docente->getId()} ORDER BY dal DESC";
        $ris = $this->connessione->query($query);
        $percorsi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * @param  Studente $studente studente per il quale estrarre i percorsi
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
        ORDER BY P.dal DESC
        testo;
        $ris = $this->connessione->query($query);
        $percorsi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * @param  Scuola $scuola scuola perla quale estrarre i percorsi
     * @return Percorso[] se ne sono stati trovati, altrimenti un array vuoto
     */
    public function getPercorsiDaScuola($scuola) {
        $query =<<<testo
        SELECT P.* FROM percorsi P
            INNER JOIN classi C
            ON C.id = P.id_classe
        WHERE C.codice_scuola = '{$scuola->getId()}'
        ORDER BY P.dal DESC
        testo;
        $ris = $this->connessione->query($query);
        $percorsi = array();
        if($ris && $ris->num_rows > 0){
            $ris = $ris->fetch_all(MYSQLI_ASSOC);
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
     * verificaCredenziali verifica che la coppia email e password sia valida.
     *
     * @param  string $email indirizzo email
     * @param  string $password password
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
     * modificaPassword modifica la password di un utente.
     *
     * @param  string $email email associate all'utente del quale cambiare la password
     * @param  string $password digest della password modificata
     * @return bool true se la modifica è andata a buon fine, altrimenti false
     */
    public function modificaPassword($email, $password) {
        $query = "UPDATE utenti SET password='{$password}' WHERE email='$email'";
        return $this->connessione->query($query);
    }
        
    /**
     * modificaEmail modifica l'email associata ad un utente.
     *
     * @param  string $vecchiaEmail email associata all'utente del quale cambiare l'email
     * @param  string $nuovaEmail nuova email da associare
     * @return bool true se la modifica è andata a buon fine, altrimenti false
     */
    public function modificaEmail($vecchiaEmail, $nuovaEmail) {
        $query = "UPDATE utenti SET email='{$nuovaEmail}' WHERE email='{$vecchiaEmail}'";
        return $this->connessione->query($query);
    }
    
    public function modificaScuola($scuola) {
        $query =<<<testo
            UPDATE 
                scuola 
            SET 
                nome = "{$scuola->getNome()}",
                citta = "{$scuola->getCitta()}",     
                indirizzo = "{$scuola->getIndirizzo()}",     
            WHERE codice_meccanografico = "{$scuola->getId()}";
        testo;
        return $this->connessione->query($query);
    }

    /**
     * insertAgenzia inserisce un'agenzia nel database.
     *
     * @param  Agenzia $agenzia istanza della classe agenzia da inserire
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertAgenzia($agenzia) {
        $query =<<<testo
        INSERT INTO agenzie (nome, email_utente, stato, citta, indirizzo, telefono) VALUES (
            "{$agenzia->getNome()}",
            "{$agenzia->getEmail()}",
            "{$agenzia->getStato()}",
            "{$agenzia->getCitta()}",
            "{$agenzia->getIndirizzo()}",
            "{$agenzia->getTelefono()}"
        testo;
        return $this->connessione->query($query);
    }

    /**
     * insertAzienda inserisce un'azienda nel database.
     *
     * @param  Azienda $azienda istanza della classe azienda da inserire
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertAzienda($azienda) {
        $query =<<<testo
        INSERT INTO agenzie (nome, email_utente, stato, citta, indirizzo, telefono) VALUES (
            "{$azienda->getNome()}",
            "{$azienda->getEmail()}",
            "{$azienda->getStato()}",
            "{$azienda->getCitta()}",
            "{$azienda->getIndirizzo()}",
            "{$azienda->getTelefono()}"
        )
        testo;
        return $this->connessione->query($query);
    }

    /**
     * insertDocente inserisce un docente nel database.
     *
     * @param  Docente $docente istanza della classe docente da inserire
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertDocente($docente) {
        $query =<<<testo
        INSERT INTO agenzie (nome, cognome, email_utente) VALUES (
            "{$docente->getNome()}",
            "{$docente->getCognome()}",
            "{$docente->getEmail()}"
        )
        testo;
        return $this->connessione->query($query);
    }

    /**
     * insertFamiglia inserisce una famiglia nel database.
     *
     * @param  Famiglia $famiglia istanza della classe famiglia da inserire
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertFamiglia($famiglia) {
        $query =<<<testo
        INSERT INTO agenzie (nome, cognome, stato, citta, indirizzo) VALUES (
            "{$famiglia->getNome()}",
            "{$famiglia->getCognome()}",
            "{$famiglia->getStato()}",
            "{$famiglia->getCitta()}",
            "{$famiglia->getIndirizzo()}"
        )
        testo;
        return $this->connessione->query($query);
    }

    /**
     * insertStudente inserisce uno studente nel database.
     *
     * @param  Studente $studente istanza della classe studente da inserire
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertStudente($studente) {
        $query =<<<testo
        INSERT INTO agenzie (nome, cognome, email_utente, data_nascita) VALUES (
            "{$studente->getNome()}",
            "{$studente->getCognome()}",
            "{$studente->getEmail()}",
            "{$studente->getDataNascita()}"
        )
        testo;
        return $this->connessione->query($query);
    } 
    
    /**
     * insertScuola inserisce una scuola nel database.
     *
     * @param  Scuola $scuola istanza della classe scuola da inserire
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertScuola($scuola) {
        $digest=hash('sha256',$scuola->getNome());
        
        //password di default: nome della scuola, bisogna fare in modo che al primo accesso venga cambiata 
        $query =<<<testo
        START TRANSACTION;
        INSERT INTO utenti (email,password,tipo_utente) VALUES (
            "{$scuola->getEmail()}",
            "$digest",
            "scuola"
        );
        INSERT INTO scuole (codice_meccanografico, email_utente, nome, citta, indirizzo ) VALUES (
            "{$scuola->getId()}",
            "{$scuola->getEmail()}",
            "{$scuola->getNome()}",
            "{$scuola->getCitta()}",
            "{$scuola->getIndirizzo()}"
        );
        COMMIT;
        testo;
        
        $ris = $this->connessione->multi_query($query);

        do{
            // Prende un risultato
            if (!$result = $this->connessione->store_result()) {
                return false;
            }
            // Prende il prossimo risultato
        } while ($this->connessione->next_result());
        return true;
    }

    /**
     * insertUtenteScuola inserisce l'utente scuola nella tabella utenti del db
     * @param email email dell'utente
     * @param password la password dell'utente
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertUtente($email,$password,$tipoUtente) {
        $query ="INSERT INTO utenti (email,password,tipo_utente) VALUES (\"$email\",\"$password\",\"$tipoUtente\")";
        return $this->connessione->query($query);
    }    
    /**
     * 
     * @param $cod_scuola codice della scuola
     * @return bool true se l'inserimento è andato a buon fine
     */
    public function insertClasse($classe){
        //echo gettype($classe->getAnnoScolastico());
        $query="INSERT INTO classi (codice_scuola,numero,sezione,anno_scolastico) VALUES ("
                . "'{$classe->getScuola()}',{$classe->getNumero()},'{$classe->getSezione()}',"
                . "'{$classe->getAnnoScolastico()}');";
        //echo $query;
        $ris=$this->connessione->query($query);
        if($ris){
            $query="SELECT id FROM classi WHERE codice_scuola='{$classe->getScuola()}' "
            . "AND numero='{$classe->getNumero()}'"
            . "AND sezione='{$classe->getSezione()}'"
            . "AND anno_scolastico='{$classe->getAnnoScolastico()}';";
            $ris=$this->connessione->query($query);
            if($ris && $ris->num_rows==1){
                //$id_classe=$ris->fetch_row()[0];
                $query="START TRANSACTION";
                $query.="INSERT INTO classi_studenti (id_studente,id_classe,dal,al) VALUES ";
                foreach($classe->getStudenti() as $studente){
                    $query.="('{$studente->getId()}','{$classe->getId()}','{$_POST["as_inizio"]}',"
                    . "'{$_POST["as_fine"]}')";
                }
                /*foreach($_POST['studenti'] as $studente){
                    $query .="('{$studente->getId()}','{$id_classe}','{$_POST['as_dal']}',"
                    . "'{$_POST['as_al']}')";
                }*/
                $query.="COMMIT";
                echo $query;
                $ris=$this->connessione->query($query);
            }   
        } 
        return $ris;
    }
    public function insertStudenteInClasse($id_classe,$id_studente){
        $query="INSERT INTO classi_studenti (id_studente,id_classe,dal,al) VALUES "
                . "('{$id_studente}','{$id_classe}','{$_POST['as_dal']}',"
                . "'{$_POST['as_al']}');";
        return $this->connessione->query($query);        
    }

    /**
     * insertPercorso inserisce un percorso nel database.
     *
     * @param  Percorso $percorso istanza della classe percorso da inserire
     * @return bool true se l'inserimento è andato a buon fine, altrimenti false
     */
    public function insertPercorso($percorso) {
        $query =<<<testo
        INSERT INTO percorsi (id_docente, id_classe, dal, al) VALUES (
            "{$percorso->getDocente()->getId()}",
            "{$percorso->getClasse()->getId()}",
            "{$percorso->getDal()}",
            "{$percorso->getAl()}"
        )
        testo;
        return $this->connessione->query($query);
    }
}
?>