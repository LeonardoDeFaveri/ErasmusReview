<?php
if (session_id() == '') {
    session_start();
    $_SESSION['root'] = __DIR__ . "/..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/Model/Modello.php";

class Controller {
    private $modello;

    public function __construct() {
        try {
            $this->modello = new Modello();
        } catch (Exception $e) {
            $_SESSION['msg_errore'] = $e->getMessage();
            header("location: View/errore.php?errore=503");
            exit();
        }
    }

    /**
     * invoca: elabora il comando ricevuto.
     * Il controllore elabora il comando ricevuto e richiama la vista opportuna
     * fornendole i dati necessari.
     */
    public function invoca() {
        $comando = (isset($_SESSION['tipo_utente'])) ? "home-{$_SESSION['tipo_utente']}" : "login" ; 
        if (isset($_GET['comando'])) {
            $comando = $_GET['comando'];
        }

        // Case per la gestione del login e del logout
        switch ($comando) {
            case 'login':
                if(!isset($_POST['submit'])){
                    header('Location: View/login.php');
                    exit();
                }
                $tipoUtente = $this->modello->verificaCredenziali($_POST['email'], hash('sha256', $_POST['password']));
                if (!$tipoUtente) {
                    header('Location: View/login.php?errore=1');
                    exit();
                }
                $_SESSION['email_utente'] = $_POST['email'];
                $_SESSION['tipo_utente'] = $tipoUtente;
                header("Location: index.php?comando=home-{$tipoUtente}");
                exit();
            break;
            case 'logout':
                session_unset();
                session_destroy();
                header('Location: View/login.php');
                exit();
            break;

            case 'cerca':
                $cercato = $_POST['cerca'];
            break;

            // Case per la gestione dell'indirizzamento alle home page degli utenti
            case 'home-admin':
                $scuole = $this->modello->getScuole(); 
                $_SESSION['scuole'] = serialize($scuole);
                header('Location: View/home/homeAdmin.php');
                exit();
            break;
            case 'home-agenzia':
                $agenzia = $this->modello->getAgenziaDaEmail($_SESSION['email_utente']);
                if ($agenzia == null){
                    header('Location: View/home/homeAgenzia.php?errore=1');
                    exit();
                }
                $_SESSION ['esperienze']= serialize($this->modello->getEsperienzeDaAgenzia($agenzia));
                $_SESSION['agenzia'] = serialize($agenzia);
                header('Location: View/home/homeAgenzia.php');
                break;
            case 'home-azienda':
                $azienda = $this->modello->getAziendaDaEmail($_SESSION['email_utente']);
                if ($azienda == null){
                    header('Location: View/home/homeAzienda.php?errore=1');
                    exit();
                }
                $_SESSION['esperienze'] = serialize($this->modello->getEsperienzeDaAzienda($azienda));
                $_SESSION['azienda'] = serialize($azienda);
                header('Location: View/home/homeAzienda.php');
                exit();
            break;
            case 'home-docente':
                $docente = $this->modello->getDocenteDaEmail($_SESSION['email_utente']);
                if ($docente == null) {
                    header('Location: View/home/homeDocente.php?errore=1');
                    exit();
                }
                $_SESSION['classi'] = serialize($this->modello->getClassiDaDocente($docente));
                $_SESSION['percorsi'] = serialize($this->modello->getPercorsiDaDocente($docente));
                $_SESSION['docente'] = serialize($docente);
                header('Location: View/home/homeDocente.php');
                exit();
            break;
            case 'home-scuola':
                $scuola = $this->modello->getScuolaDaEmail($_SESSION['email_utente']);
                if ($scuola == null){
                    header('Location: View/home/homeScuola.php?errore=1');
                    exit();
                }
                $_SESSION['classi'] = serialize($this->modello->getClassiDaScuola($scuola));
                $_SESSION['docenti'] = serialize($this->modello->getDocentiDaScuola($scuola));
                $_SESSION['percorsi'] = serialize($this->modello->getPercorsiDaScuola($scuola));
                $_SESSION['scuola'] = serialize($scuola);
                header('Location: View/home/homeScuola.php');
            break;
            case 'home-studente':
                $studente = $this->modello->getStudenteDaEmail($_SESSION['email_utente']);
                if ($studente == null) {
                    header('Location: View/home/homeStudente.php?errore=1');
                    exit();
                }
                $_SESSION['esperienze'] = serialize($this->modello->getEsperienzeDaStudente($studente));
                $_SESSION['studente'] = serialize($studente);
                header('Location: View/home/homeStudente.php');
                exit();
            break;

            // Case per la visualizzazione di informazioni su soggetti ed entità
            case 'mostra-agenzia':
                /* 
                 * $id = $_GET['id'] ?? -1; controlla se l'id è settato e diverso da null.
                 * Nel caso in cui $_GET[id] non sia settato o sia null, assegno un lavore -1,
                 * che rappresenta, nel db, un id che non esiste, di conseguenza la query mi darà null.
                 */
                $id = $_GET['id'] ?? -1;
                $agenzia = $this->modello->getAgenziaDaId($id);
                if ($agenzia == null) {
                    header('Location: View/mostra/mostraAgenzia.php?errore=3');
                    exit();
                }
                $modello = $this->modello->getModelloDaTipi('studente', 'agenzia');
                $valutazioni = $this->modello->getValutazioniMedieDiAzienda($modello, $agenzia);
                $_SESSION['agenzia'] = serialize($agenzia);
                $_SESSION['valutazioni_medie_agenzia'] = serialize($valutazioni);
                header('Location: View/mostra/mostraAgenzia.php');
                exit();
            break;
            case 'mostra-scuola':
                $codiceMeccanografico = $_GET['codice_meccanografico'] ?? -1;
                $scuola = $this->modello->getScuolaDaCodice($codiceMeccanografico);
                if ($scuola == null){
                    header('Location: View/mostra/mostraPercorso.php?errore=3');
                    exit();
                }
                $_SESSION['scuola'] = serialize($scuola);
                header('Location: View/mostra/mostraScuola.php');
                exit();
                
            break;
            case 'mostra-azienda':
                $id = $_GET['id'] ?? -1;
                $azienda = $this->modello->getAziendaDaId($id);
                if ($azienda == null) {
                    header('Location: View/mostra/mostraAzienda.php?errore=3');
                    exit();
                }
                $modello = $this->modello->getModelloDaTipi('studente', 'azienda');
                $valutazioni = $this->modello->getValutazioniMedieDiAzienda($modello, $azienda);
                $_SESSION['azienda'] = serialize($azienda);
                $_SESSION['valutazioni_medie_azienda'] = serialize($valutazioni);
                header('Location: View/mostra/mostraAzienda.php');
                exit();
            break;
            case 'mostra-esperienza':
                $id = $_GET['id'] ?? -1;
                $esperienza = $this->modello->getEsperienzaDaId($id);
                if ($esperienza == null) {
                    header('Location: View/mostra/mostraEsperienza.php?errore=3');
                    exit();
                }
                $_SESSION['esperienza'] = serialize($esperienza);
                header('Location: View/mostra/mostraEsperienza.php');
                exit();
            break;
            case 'mostra-famiglia':
                $id = $_GET['id'] ?? -1;
                $famiglia = $this->modello->getFamigliaDaId($id);
                if ($famiglia == null) {
                    header('Location: View/mostra/mostraFamiglia.php?errore=3');
                    exit();
                }
                $modello = $this->modello->getModelloDaTipi('studente', 'famiglia');
                $_SESSION['famiglia'] = serialize($famiglia);
                $valutazioni = $this->modello->getValutazioniMedieDiFamiglia($modello, $famiglia);
                $_SESSION['valutazioni_medie_famiglia'] = serialize($valutazioni);
                header('Location: View/mostra/mostraFamiglia.php');
                exit();
            break;
            case 'mostra-percorso':
                $id = $_GET['id'] ?? -1;
                $percorso = $this->modello->getPercorsoDaId($id);
                if ($percorso == null){
                    header('Location: View/mostra/mostraPercorso.php?errore=3');
                    exit();
                }
                $esperienze=$this->modello->getEsperienzeDaPercorso($id);
                $_SESSION['percorso'] = serialize($percorso);
                $_SESSION['esperienze'] = serialize($esperienze);
                header('Location: View/mostra/mostraPercorso.php');
                exit();
            break;
            case 'mostra-studenti':
                $studenti = $this->modello->getStudentiDaScuola($_GET['codice_scuola']);
                $_SESSION['studenti'] = serialize($studenti);
                header('Location: View/mostra/mostraStudenti.php');
                exit();
            break;
            
            case 'mostra-classe':
                $id = $_GET['id'] ?? -1;
                $classe = $this->modello->getClasseDaId($_GET["id"]);
                if($classe == null){
                    header('Location: View/mostra/mostraClasse.php?errore=3');
                    exit();    
                }
                $_SESSION['classe'] = serialize($classe);
                $_SESSION['studenti'] = serialize($this->modello->getContenitoreStudentiDaClasse($id));
                $_SESSION['docenti_classe'] = serialize($this->modello->getDocentiDaClasse($classe->getId()));
                header('Location: View/mostra/mostraClasse.php');
                exit();
            break;
            
            case 'mostra-studente':
                $id = $_GET['id'] ?? -1;
                $studente = $this->modello->getStudenteDaId($id);
                if($studente == null){
                    header('Location: View/mostra/mostraStudente.php?errore=3');
                    exit();
                }
                $_SESSION['classi_studente'] = serialize($this->modello->getClassiDaStudente($studente));
                $_SESSION['studente'] = serialize($studente);
                $modello = $this->modello->getModelloDaTipi('azienda', 'studente');
                $valutazioni = $this->modello->getValutazioniMedieDiStudente($modello, $studente);
                $_SESSION['valutazioni_medie_studente'] = serialize($valutazioni);
                header('Location: View/mostra/mostraStudente.php');
                exit();
            break;  
            
            case 'mostra-docente':
                $id = $_GET['id'] ?? -1;
                $docente = $this->modello->getDocenteDaId($id);
                if($docente == null){
                    header('Location: View/mostra/mostraDocente.php?errore=3');
                    exit();
                }
                $_SESSION['classi_docente'] = serialize($this->modello->getClassiDaDocente($docente));
                $_SESSION['docente'] = serialize($docente);

                header('Location: View/mostra/mostraDocente.php');
                exit();
            break;

            case 'mostra-valutazione-esperienza':
                $id = $_GET['id'] ?? -1;
                $esperienza = $this->modello->getEsperienzaDaId($id);
                if($esperienza == null){
                    header('Location: View/valutazioni/mostraValutazioni.php?errore=3');
                    exit();
                }
                $schedeDiValutazione = array();
                switch($_SESSION['tipo_utente']){
                    case 'studente':
                        $modello = $this->modello->getModelloDaTipi('studente', 'azienda');
                        if($modello != null){
                            $schedeDiValutazione['studente_azienda'] = $this->modello->getSchedaDiValutazioneDaSoggetti(
                                $modello,
                                $esperienza->getStudente()->getId(),
                                $esperienza->getAzienda()->getId(),
                                $esperienza
                            );
                        }
                        if($esperienza->getAgenzia() != null){
                            $modello = $this->modello->getModelloDaTipi('studente', 'agenzia');
                            if($modello != null){
                                $schedeDiValutazione['studente_agenzia'] = $this->modello->getSchedaDiValutazioneDaSoggetti(
                                    $modello,
                                    $esperienza->getStudente()->getId(),
                                    $esperienza->getAgenzia()->getId(),
                                    $esperienza
                                );
                            }    
                        }
                        if($esperienza->getFamiglia() != null){
                            $modello = $this->modello->getModelloDaTipi('studente', 'famiglia');
                            if($modello != null){
                                $schedeDiValutazione['studente_famiglia'] = $this->modello->getSchedaDiValutazioneDaSoggetti(
                                    $modello,
                                    $esperienza->getStudente()->getId(),
                                    $esperienza->getFamiglia()->getId(),
                                    $esperienza
                                );
                            }    
                        }
                        $modello = $this->modello->getModelloDaTipi('azienda', 'studente');
                        if($modello != null){
                            $schedeDiValutazione['azienda_studente'] = $this->modello->getSchedaDiValutazioneDaSoggetti(
                                $modello,
                                $esperienza->getAzienda()->getId(),
                                $esperienza->getStudente()->getId(),
                                $esperienza
                            );
                        }
                    break;
                    case 'azienda':
                        $modello = $this->modello->getModelloDaTipi('azienda', 'studente');
                        if($modello != null){
                            $schedeDiValutazione['azienda_studente'] = $this->modello->getSchedaDiValutazioneDaSoggetti(
                                $modello,
                                $esperienza->getAzienda()->getId(),
                                $esperienza->getStudente()->getId(),
                                $esperienza
                            );
                        }
                        $modello = $this->modello->getModelloDaTipi('studente', 'azienda');
                        if($modello != null){
                            $schedeDiValutazione['studente_azienda'] = $this->modello->getSchedaDiValutazioneDaSoggetti(
                                $modello,
                                $esperienza->getStudente()->getId(),
                                $esperienza->getAzienda()->getId(),
                                $esperienza
                            );
                        }
                    break;
                    case 'agenzia':
                        if($esperienza->getAgenzia() != null){
                            $modello = $this->modello->getModelloDaTipi('studente', 'agenzia');
                            if($modello != null){
                                $schedeDiValutazione['studente_agenzia'] = $this->modello->getSchedaDiValutazioneDaSoggetti(
                                    $modello,
                                    $esperienza->getStudente()->getId(),
                                    $esperienza->getAgenzia()->getId(),
                                    $esperienza
                                );
                            }    
                        }
                        if($esperienza->getFamiglia() != null){
                            $modello = $this->modello->getModelloDaTipi('studente', 'famiglia');
                            if($modello != null){
                                $schedeDiValutazione['studente_famiglia'] = $this->modello->getSchedaDiValutazioneDaSoggetti(
                                    $modello,
                                    $esperienza->getStudente()->getId(),
                                    $esperienza->getFamiglia()->getId(),
                                    $esperienza
                                );
                            }    
                        }
                    break;
                    default:
                        header('Location: View/valutazioni/mostraValutazioni.php?errore=1');
                        exit();
                    break;
                }
                $_SESSION['schede_di_valutazione'] = serialize($schedeDiValutazione);
                $_SESSION['esperienza'] = serialize($esperienza);
                header('Location: View/valutazioni/mostraValutazioni.php');
                exit();
            break;

            case 'compila-scheda':
                $tipoRecensito = $_GET['tipo_recensito'] ?? "";
                $modello = $this->modello->getModelloDaTipi($_SESSION['tipo_utente'], $tipoRecensito);
                if($modello == null){
                    header('Location: View/valutazioni/compilaScheda.php?errore=3');
                    exit();
                }
                $_SESSION['modello'] = serialize($modello);
                header('Location: View/valutazioni/compilaScheda.php');
                exit();
            break;

            case 'inserisci-scheda-compilata':
                $aspetti = $_POST['aspetti'];
                $valutazioni = array();
                foreach ($aspetti as $aspetto => $voto) {
                    $valutazioni[] = new Valutazione(
                        null,
                        $voto,
                        $aspetto
                    );
                }
                $esperienza = unserialize($_SESSION['esperienza']);
                $modello = unserialize($_SESSION['modello']);
                $tipoRecensore = $_SESSION['tipo_utente'];
                $idRecensore = null;
                $tipoRecensito = null;
                $idRecensito = null;
                
                // Popola le informazioni sul recensore
                switch ($tipoRecensore) {
                    case 'studente':
                        $idRecensore = $esperienza->getStudente()->getId();
                    break;
                    case 'azienda':
                        $idRecensore = $esperienza->getAzienda()->getId();
                    break;
                    default:
                        header('Location: View/valutazioni/compilaScheda.php?errore=4');
                        exit();
                    break;
                }
                // Popola le informazioni sul recensito
                switch ($modello->getTipoRecensito()) {
                    case 'studente':
                        $tipoRecensito = 'studente';
                        $idRecensito = $esperienza->getStudente()->getId();
                    break;
                    case 'azienda':
                        $tipoRecensito = 'azienda';
                        $idRecensito = $esperienza->getAzienda()->getId();
                    break;
                    case 'famiglia':
                        $tipoRecensito = 'famiglia';
                        $idRecensito = $esperienza->getFamiglia()->getId();
                    break;
                    case 'agenzia':
                        $tipoRecensito = 'agenzia';
                        $idRecensito = $esperienza->getAgenzia()->getId();
                    break;
                }

                // Crea la scheda di valutazione
                $scheda = new SchedaDiValutazione(
                    null,
                    $tipoRecensore,
                    $idRecensore,
                    $tipoRecensito,
                    $idRecensito,
                    $esperienza,
                    date('Y-m-d h:m:s', time()),
                    $valutazioni
                );
                if(!$this->modello->insertSchedaDiValutazione($scheda, $modello)){
                   header('Location: View/valutazioni/compilaScheda.php?errore=2');
                   exit(); 
                }
                header("Location: index.php?comando=mostra-valutazione-esperienza&id={$esperienza->getId()}");
                exit();
            break;

            // Case per la creazione di nuove istanze di soggetti o entità
            case 'crea-percorso':
                if($_SESSION['tipo_utente'] != 'docente' && $_SESSION['tipo_utente'] != 'scuola'){
                    //se l'utente loggato non è ne scuola ne docente
                    header('Location: View/creazione/creaPercorso.php?errore=1');
                    exit();
                }
                $docente = $this->modello->getDocenteDaEmail($_SESSION['email_utente']);
                if(isset($_POST['submit'])){
                    $percorso = null;
                    if(isset($_POST['id_docente'])){
                        $percorso = new Percorso(
                            null,
                            $this->modello->getDocenteDaId($_POST['id_docente']),
                            $this->modello->getClasseDaId($_POST['id_classe']),
                            $_POST['dal'],
                            $_POST['al']
                        );
                    }else{
                        $percorso = new Percorso(
                            null,
                            $docente,
                            $this->modello->getClasseDaId($_POST['id_classe']),
                            $_POST['dal'],
                            $_POST['al']
                        );
                    }
                    if($this->modello->insertPercorso($percorso)){
                        header('Location: index.php');
                        exit();
                    }else{
                        header('Location: View/creazione/creaPercorso.php?errore=2');
                        exit();
                    }
                }
                if($_SESSION['tipo_utente'] == 'docente'){
                    $_SESSION['classi'] = serialize($this->modello->getClassiDaDocente($docente));
                    $_SESSION['docente'] = serialize($docente);
                }else{
                    $scuola = $this->modello->getScuolaDaEmail($_SESSION['email_utente']);
                    $_SESSION['classi'] = serialize($this->modello->getClassiDaScuola($scuola));
                    $_SESSION['docenti'] = serialize($this->modello->getDocentiAttiviDaScuola($scuola));
                    $_SESSION['scuola'] = serialize($scuola);
                }
                header('Location: View/creazione/creaPercorso.php');
                exit();
            break;
            case 'crea-esperienza':
                if($_SESSION['tipo_utente'] != 'docente' && $_SESSION['tipo_utente'] != 'scuola'){
                    //se l'utente loggato non è ne scuola ne docente
                    header('Location: View/creazione/creaEsperienza.php?errore=1');
                    exit();
                }
                if(isset($_POST['submit'])){
                    $dal = $_POST['dataDal'];
                    $al = $_POST['dataAl'];
                    // Se dal e al non sono stati settati utilizza le stesse date del percorso
                    if($dal == "" && al == ""){
                        $percorso =  $this->modello->getPercorsoDaId($_POST['id_percorso']);
                        $dal = $percorso->getDal();
                        $al = $percorso->getAl();
                    }
                    $esperienza = new Esperienza(
                        null,
                        $_POST['id_studente'],
                        $_POST['id_percorso'],
                        $_POST['id_azienda'],
                        $_POST['id_agenzia'],
                        $_POST['id_famiglia'],
                        $dal,
                        $al
                    );
                    if($this->modello->insertEsperienza($esperienza)){
                        header('Location: index.php');
                        exit();
                    }else{
                        header('Location: View/creazione/creaEsperienza.php?errore=2');
                        exit();
                    }
                }
                if($_SESSION['tipo_utente'] == 'docente'){
                    $docente = $this->modello->getDocenteDaEmail($_SESSION['email_utente']);
                    $_SESSION['studenti'] = serialize($this->modello->getStudentiDaDocente($docente->getId()));
                    $_SESSION['aziende'] = serialize($this->modello->getAziende());
                    $_SESSION['agenzie'] = serialize($this->modello->getAgenzie());
                    $_SESSION['famiglie'] = serialize($this->modello->getFamiglie());
                    $_SESSION['percorsi'] = serialize($this->modello->getPercorsiDaDocente($docente));
                }else{
                    $scuola = $this->modello->getScuolaDaEmail($_SESSION['email_utente']);
                    $_SESSION['studenti'] = serialize($this->modello->getStudentiAttiviDaScuola($scuola->getId()));
                    $_SESSION['aziende'] = serialize($this->modello->getAziende());
                    $_SESSION['agenzie'] = serialize($this->modello->getAgenzie());
                    $_SESSION['famiglie'] = serialize($this->modello->getFamiglie());
                    $_SESSION['percorsi'] = serialize($this->modello->getPercorsiDaScuola($scuola));
                }
                header('Location: View/creazione/creaEsperienza.php');
                exit();
            break;
            case 'crea-classe':
                $scuola = unserialize($_SESSION['scuola']);
                if(isset($_POST['submit'])){
                    $as = substr($_POST['as_inizio'],0,4)."/".substr($_POST['as_fine'],0,4);
                    $classe = new Classe(
                        null,
                        $scuola->getId(),
                        $_POST["numero_classe"],
                        $_POST["sezione_classe"],
                        $as,
                        null
                    );
                    if($idClasse = $this->modello->insertClasse($classe)){
                        if(isset($_POST['id_studenti'])){
                            $studenti = explode(',', $_POST['id_studenti']);
                            $dal = $_POST['as_inizio'];
                            $al = $_POST['as_fine'];
                            $erroreInserimento = false;
                            foreach($studenti as $idStudente){
                                if(!$this->modello->insertStudenteInClasse($idClasse, intval($idStudente), $dal, $al)){
                                    $erroreInserimento = true;
                                }
                            }
                            if($erroreInserimento){
                                header('Location: View/creazione/creaClasse.php?errore=3');
                                exit();
                            }
                        }
                        header('Location: index.php');
                        exit();
                    }
                    header('Location: View/creazione/creaClasse.php?errore=2');
                    exit();
                }else{
                    $studenti = $this->modello->getStudentiAttiviDaScuola($scuola->getId());
                    $_SESSION['studenti'] = serialize($studenti);
                    header('Location: View/creazione/creaClasse.php');
                    exit();
                }
            break;
            case 'crea-docente':
                $scuola = unserialize($_SESSION['scuola']);
                if(isset($_POST['submit'])){
                    $nome = $_POST["nome_docente"];
                    $docente = new Docente(
                        null,
                        $_POST["nome_docente"],
                        $_POST["cognome_docente"],
                        $_POST["email_docente"]
                    );
                    
                    $al = null;
                    if($_POST["al_docente"] != ""){
                        $al = $_POST["al_docente"];
                    }

                    $scuola = unserialize($_SESSION['scuola']);
                    if(!$this->modello->insertDocente($docente, $scuola, $_POST["dal_docente"], $al)){
                        header('Location: View/creazione/creaDocente.php?errore=2');
                        exit();
                    }
                    header('Location: index.php');
                    exit();
                }else{
                    header('Location: View/creazione/creaDocente.php');
                    exit(); 
                }
            break;
            case 'crea-scuola':
                if(!isset($_POST['submit'])){
                    header('Location: View/creazione/creaScuola.php');
                    exit();
                }
                $scuola = new Scuola(
                    $_POST["codice_meccanografico"],
                    $_POST["nome"],
                    $_POST["email"],
                    $_POST["citta"],
                    $_POST["indirizzo"]
                );
                $controllo=$this->modello->insertScuola($scuola);
                if(!$controllo){
                    header('Location: View/creazione/creaScuola.php?errore=2');
                    exit();                    
                }
                header('Location: index.php');
                exit();
            break;
            
            // Case per la gestione dei dati dell'account
            case 'gestione-account':
                header('Location: View/gestioneAccount.php');
                exit();
            break;
            
            case 'cambio-password':
                $password = hash('sha256', $_POST["password"]);
                if(!$this->modello->modificaPassword($_SESSION['email_utente'], $password)){
                    header('Location: View/gestioneAccount.php?errore=2');
                    exit();
                }
                header('Location: View/gestioneAccount.php?successo=true');
                exit();
            break; 
            case 'cambio-email':
                if(!$this->modello->modificaEmail($_SESSION['email_utente'], $_POST["email"])){
                    header('Location: View/gestioneAccount.php?errore=2');
                    exit();
                }
                header('Location: View/gestioneAccount.php?successo=true');
                exit();
            break;
            case 'modifica-account-scuola':
                /*
                 * Questo case viene richiamato quando si tenta di modificare i dati di una scuola.
                 * Estrae l'istanza da modificare e la inserisce nel SESSION serializzata così che
                 * la pagina della view possa accedervi.
                 */
                $scuola = $this->modello->getScuolaDaCodice($_GET["codice_meccanografico"]);
                $_SESSION["scuola"] = serialize($scuola);
                header('Location: View/modifica/modificaScuola.php');
                exit();
            break;
            case 'modifica-dati-scuola':
                $scuola = new Scuola(
                    $_POST["codiceMeccanografico"],
                    $_POST["nome"],
                    null, // L'email non è impostata, ma in questo caso non serve
                    $_POST["citta"],
                    $_POST["indirizzo"]
                );
                if($this->modello->modificaScuola($scuola)){
                    header('Location: View/modifica/modificaScuola.php?successo=true');
                    exit();
                }
                header('Location: View/modifica/modificaScuola.php?errore=2');
                exit();
            break;
            case 'modifica-credenziali-scuola':
                if(isset($_POST["password"])){
                    if(!$this->modello->modificaPassword($_POST["vecchiaEmail"], hash('sha256', $_POST["password"]))){
                        header('Location: View/modifica/modificaScuola.php?errore=2');
                        exit();
                    }
                }
                if(isset($_POST['email'])){
                    if(!$this->modello->modificaEmail($_POST["vecchiaEmail"], $_POST["email"])){
                        header('Location: View/modifica/modificaScuola.php?errore=2');
                        exit();
                    }
                    $_SESSION['scuole'] = serialize($this->modello->getScuole());
                    $_SESSION['scuola'] = serialize($this->modello->getScuolaDaEmail($_POST['email']));
                }
                header('Location: View/modifica/modificaScuola.php?successo=true');
                exit();
            break;
            case 'modifica-percorso':
                if(isset($_POST['submit'])){
                    $percorso = null;
                    $id = $_GET['id'] ?? -1;
                    if($_SESSION['tipo_utente'] == 'docente'){
                        $percorso = new Percorso(
                            $id,
                            $this->modello->getDocenteDaEmail($_SESSION['email_utente']),
                            $this->modello->getClasseDaId($_POST['id_classe']),
                            $_POST['dal'],
                            $_POST['al']
                        );
                    }else{
                        $percorso = new Percorso(
                            $id,
                            $this->modello->getDocenteDaId($_POST['id_docente']),
                            $this->modello->getClasseDaId($_POST['id_classe']),
                            $_POST['dal'],
                            $_POST['al']
                        );
                    }
                    if($this->modello->modificaPercorso($percorso)){
                        header('Location: View/modifica/modificaPercorso.php?successo=true');
                        exit();
                    }
                    header('Location: View/modifica/modificaPercorso.php?errore=2');
                    exit();
                }else{
                    $id = $_GET['id'] ?? -1;
                    $percorso = $this->modello->getPercorsoDaId($id);
                    if ($percorso == null){
                        header('Location: View/modifica/modificaPercorso.php?errore=1');
                        exit();
                    }
                    $_SESSION['percorso'] = serialize($percorso);
                    if($_SESSION['tipo_utente'] == 'scuola'){
                        $scuola = $this->modello->getScuolaDaEmail($_SESSION['email_utente']);
                        $docenti = $this->modello->getDocentiAttiviDaScuola($scuola);
                        $classi = $this->modello->getClassiDaScuola($scuola);
                        $_SESSION['docenti'] = serialize($docenti);
                        $_SESSION['classi'] = serialize($classi);
                        header('Location: View/modifica/modificaPercorso.php');
                        exit();
                    }else{
                        $docente = $this->modello->getDocenteDaEmail($_SESSION['email_utente']);
                        $classi = $this->modello->getClassiDaDocente($docente);
                        $_SESSION['classi'] = serialize($classi);
                        header('Location: View/modifica/modificaPercorso.php');
                        exit();
                    }
                }
            break;
            case 'modifica-esperienza':
                if(isset($_POST['submit'])){
                    $esperienza = null;
                    $id = $_GET['id'] ?? -1;
                    $esperienza = new Esperienza(
                        $id,
                        $this->modello->getStudenteDaEmail($_SESSION['email_utente']),
                        $this->modello->getPercorsiDaDocente($_SESSION['id_percorso']),
                        $this->modello->getAziendaDaId($_SESSION['id_azienda']),
                        $this->modello->getAgenziaDaId($_SESSION['id_agenzia']),
                        $this->modello->getFamigliaDaId($_SESSION['id_famiglia']),
                        $_POST['dataDal'],
                        $_POST['dataAl']        
                    );
                    if($this->modello->modificaEsperienza($esperienza)){
                        header('Location: View/modifica/modificaEsperienza.php?successo=true');
                        exit();
                    }
                    header('Location: View/modifica/modificaEsperienza.php?errore=2');
                    exit();
                }else{
                    $id = $_GET['id'] ?? -1;
                    $esperienza = $this->modello->getEsperienzaDaId($id);
                    if ($esperienza == null){
                        header('Location: View/modifica/modificaEsperienza.php?errore=1');
                        exit();
                    }
                    $_SESSION['esperienza'] = serialize($esperienza);
                    $_SESSION['aziende']= serialize($this->modello->getAziende());
                    $_SESSION['agenzie']= serialize($this->modello->getAgenzie());
                    $_SESSION['famiglie']= serialize($this->modello->getFamiglie());
                    $_SESSION['dal']= serialize($esperienza->getDal());
                    $_SESSION['al']= serialize($esperienza->getAl());
                }
            break;
            case 'associa-docente-classe':
                $classe = $this->modello->getClasseDaId($_GET['id']);
                if($classe == null){
                    header('Location: View/modifica/associaDocenteClasse.php?errore=3a');
                    exit();
                }
                if(isset($_POST['submit'])){
                    $docente = $this->modello->getDocenteDaId($_POST['id_docente']);
                    if($docente == null){
                        header('Location: View/modifica/associaDocenteClasse.php?errore=3b');
                        exit();
                    }
                    $dal = $_POST['dal'] == "" ? date('Y-m-d') : $_POST['dal'];
                    $al = $_POST['al'] == "" ? null : $_POST['al'];
                    if(!$this->modello->insertiDocenteInClasse($classe->getId(), $docente->getId(), $dal, $al)){
                        header('Location: View/modifica/associaDocenteClasse.php?errore=2');
                        exit();
                    }
                    header("Location: index.php?comando=mostra-classe&id={$classe->getId()}");
                    exit();
                }else{
                    $docenti = $this->modello->getDocentiAttiviDaScuola($classe->getScuola());
                    $_SESSION['classe'] = serialize($classe);
                    $_SESSION['possibili_docenti_classe'] = serialize($docenti);
                    header('Location: View/modifica/associaDocenteClasse.php');
                    exit();
                }
            break;
            
            // Questo case viene invocato quando viene invocato l'index con un comando non gestito.
            default:
                header('Location: View/errore.php');
            break;
        }
    }
}
/*
 * In alcuni casi di errore si viene reindirizzati alla pagina di "origine" con un parametro del
 * tipo (?errore=1) il numero rappresenta un tipo di errore, la lista che associa il numero con
 * l'errore è sulla wiki di github al seguente link:
 *(https://github.com/LeonardoDeFaveri/ErasmusReview/wiki/Struttura-del-sito)
 */
?>