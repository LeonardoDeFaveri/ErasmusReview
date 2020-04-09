<?php

if (session_id() == '') {
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
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

        switch ($comando) {
            case 'login':
                if (!isset($_POST['login'])) {
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
                session_destroy();
                session_unset();
                header('Location: View/login.php');
                exit();
            break;

            case 'cerca':
                $cercato = $_POST['cerca'];
            break;

            case 'home-admin':
                $scuole = $this->modello->getScuole(); 
                $_SESSION["scuole"]=serialize($scuole);
                header('Location: View/homeAdmin.php');
                exit();
            break;

            case 'home-studente':
                $studente = $this->modello->getStudenteDaEmail($_SESSION['email_utente']);
                if ($studente == null) {
                    header('Location: View/homeStudente.php?errore=1');
                    exit();
                }
                $_SESSION['esperienze'] = serialize($this->modello->getEsperienzeDaStudente($studente));
                $_SESSION['studente'] = serialize($studente);
                header('Location: View/homeStudente.php');
                exit();
            break;
            
            case 'home-docente':
                $docente = $this->modello->getDocenteDaEmail($_SESSION['email_utente']);
                if ($docente == null) {
                    header('Location: View/homeDocente.php?errore=1');
                    exit();
                }
                $_SESSION['classi'] = serialize($this->modello->getClassiDaDocente($docente));
                $_SESSION['percorsi'] = serialize($this->modello->getPercorsiDaDocente($docente));
                $_SESSION['docente'] = serialize($docente);
                header('Location: View/homeDocente.php');
                exit();
            break;
            case 'home-agenzia':
                $agenzia = $this->modello->getAgenziaDaEmail($_SESSION['email_utente']);
                if ($agenzia == null){
                    header('Location: View/homeAgenzia.php?errore=1');
                    exit();
                }
                $_SESSION ['esperienze']= serialize($this->modello->getEsperienzeDaAgenzia($agenzia));
                $_SESSION['agenzia'] = serialize($agenzia);
                header('Location: View/homeAgenzia.php');
                break;
            case 'home-azienda':
                $azienda = $this->modello->getAziendaDaEmail($_SESSION['email_utente']);
                if ($azienda == null){
                    header('Location: View/homeAzienda.php?errore=1');
                    exit();
                }
                $_SESSION['esperienze'] = serialize($this->modello->getEsperienzeDaAzienda($azienda));
                $_SESSION['azienda'] = serialize($azienda);
                header('Location: View/homeAzienda.php');
                exit();
            break;
            case 'home-scuola':
                $scuola = $this->modello->getScuolaDaEmail($_SESSION['email_utente']);
                if ($scuola == null){
                    header('Location: View/homeScuola.php?errore=1');
                    exit();
                }
                $_SESSION['classi'] = serialize($this->modello->getClassiDaScuola($scuola));
                $_SESSION['docenti'] = serialize($this->modello->getDocentiDaScuola($scuola));
                $_SESSION['percorsi'] = serialize($this->modello->getPercorsiDaScuola($scuola));
                $_SESSION['scuola'] = serialize($scuola);
                header('Location: View/homeScuola.php');
            break;

            case 'mostra-studenti':
                $studenti = $this->modello->getStudentiDaScuola($_GET['codice_scuola']);
                $_SESSION['studenti'] = serialize($studenti);
                header('Location: View/mostraStudenti.php');
                exit();
            break;
            case 'mostra-azienda':
                $id = $_GET['id'] ?? -1;
                /* $id = $_GET['id'] ?? -1; controlla se l'id è settato e diverso da null.
                 * Nel caso in cui $_GET[id] non sia settato o sia null, assegno un lavore -1,
                 * che rappresenta un id che nel db non esiste di conseguenza la query mi darà null.
                 */
                $azienda = $this->modello->getAziendaDaId($id);
                if ($azienda == null) {
                    header('Location: View/mostraAzienda.php?errore=1');
                    exit();
                }
                $_SESSION['azienda'] = serialize($azienda);
                header('Location: View/mostraAzienda.php');
                exit();
            break;
            case 'mostra-famiglia':
                $id = $_GET['id'] ?? -1;
                $famiglia = $this->modello->getFamigliaDaId($id);
                if ($famiglia == null) {
                    header('Location: View/mostraFamiglia.php?errore=1');
                    exit();
                }
                $_SESSION['famiglia'] = serialize($famiglia);
                header('Location: View/mostraFamiglia.php');
                exit();
            break;
            case 'mostra-agenzia':
                $id = $_GET['id'] ?? -1;
                $agenzia = $this->modello->getAgenziaDaId($id);
                if ($agenzia == null) {
                    header('Location: View/mostraAgenzia.php?errore=1');
                    exit();
                }
                $_SESSION['agenzia'] = serialize($agenzia);
                header('Location: View/mostraAgenzia.php');
                exit();
            break;
            case 'mostra-esperienza':
                $id = $_GET['id'] ?? -1;
                $esperienza = $this->modello->getEsperienzaDaId($id);
                if ($esperienza == null) {
                    header('Location: View/mostraEsperienza.php?errore=1');
                    exit();
                }
                $_SESSION['esperienza'] = serialize($esperienza);
                header('Location: View/mostraEsperienza.php');
                exit();
            break;

            case 'valutazione-esperienza':
                $id = $_GET['id'] ?? -1;
                $esperienza = $this->modello->getEsperienzaDaId($id);
                if ($esperienza == null) {
                    header('Location: View/mostraEsperienza.php?errore=1');
                    exit();
                }
            break;

            case 'crea-percorso':
                $docente = $this->modello->getDocenteDaEmail($_SESSION['email_utente']);
                $scuola = $this->modello->getScuolaDaEmail($_SESSION['email_utente']);
                if ($docente != null) { //se l'utente loggato è un docente
                    if(isset($_POST['submit'])){
                        $percorsoDaInserire = new Percorso(0,$docente->getId(),$_POST['idClasse'],$_POST['dal'],$_POST['al']);
                        if($this->modello->insertPercorso($percorsoDaInserire)){
                            //query riuscita
                        }else{
                            //errore nella query
                        }
                    }else{ //mando alla pagina di inserimento percorso
                        $classiDocente = $this->modello->getClassiDaDocente($docente); //ottengo tutte le classi assegnate a un docente
                        $_SESSION['classiDocente'] = serialize($classiDocente);
                        $_SESSION['docente'] = serialize($docente);
                        header('Location: View/creaPercorso.php');
                        exit();
                    }
                }else{
                    if($scuola != null){ //se l'utente loggato è una scuola
                        if(isset($_POST['submit'])){
                            $percorsoDaInserire = new Percorso(0,$_POST['idDocente'],$_POST['idClasse'],$_POST['dal'],$_POST['al']);
                            if($this->modello->insertPercorso($percorsoDaInserire)){
                                echo "inserito";
                                //query riuscita
                            }else{
                                //errore nella query
                            }
                        }else{ //mando alla pagina di inserimento percorso
                            $classiScuola =$this->modello->getClassiDaScuola($scuola); //ottengo tutte le classi presenti in una scuola
                            $docentiScuola = $this->modello->getDocentiDaScuola($scuola);
                            $_SESSION['classiScuola'] = serialize($classiScuola); 
                            $_SESSION['docentiScuola'] = serialize($docentiScuola); 
                            $_SESSION['scuola'] = serialize($scuola);
                            header('Location: View/creaPercorso.php');
                            exit();
                        }
                    }
                    //se l'utente loggato non è ne scuola ne docente
                    header('Location: View/creaPercorso.php?errore=1');
                    exit();
                }
            break;

            case 'modifica-percorso':
                $id = $_GET['id'] ?? -1;
                $percorso = $this->modello->getPercorsoDaId($id);
                if ($percorso == null){
                    header('Location: View/modificaPercorso.php?errore=1');
                    exit();
                }
            break;
            case 'mostra-info-percorso':
                $id = $_GET['id'] ?? -1;
                $percorso = $this->modello->getPercorsoDaId($id);
                if ($percorso == null){
                    header('Location: View/mostraPercorso.php?errore=1');
                    exit();
                }
            break;
            case 'crea-classe':
                $scuola = unserialize($_SESSION['scuola']);
                $studenti = $this->modello->getStudentiDaScuola($scuola->getId());
                $_SESSION['studenti'] = serialize($studenti);
                if(isset($_POST['Crea classe'])){
                    $this->modello->insertClasse($scuola->getId());
                }else{
                    header('Location: View/creaClasse.php');
                    exit();
                }
            break;
            
            case 'gestione-account':
                header('Location: View/gestioneAccount.php');
                exit();
            break;
            case 'cambio-password':
                $digest = hash('sha256', $_POST["password"]);
                if(!$this->modello->modificaPassword($_SESSION['email_utente'], $digest)){
                    header('Location: View/gestioneAccount.php?errore=2');
                    exit();
                }
                header('Location: View/gestioneAccount.php?successo=true');
                exit();
            break; 

            case 'cambio-email':
                if(!$this->modello->modificaEmail($_SESSION['email-utente'], $_POST["email"])){
                    header('Location: View/gestioneAccount.php?errore=2');
                    exit();
                }
                header('Location: View/gestioneAccount.php?successo=true');
                exit();
            break;   
            
            case 'aggiungi-scuola':
                if(!isset($_POST['submit'])){
                    header('Location: View/aggiungiScuola.php');
                    exit();
                }
                $scuola=new Scuola(
                    $_POST["codice_meccanografico"],
                    $_POST["nome"],
                    $_POST["email"],
                    $_POST["citta"],
                    $_POST["indirizzo"]
                );
                if(!$this->modello->insertScuola($scuola)){
                    header('Location: View/homeAdmin.php?errore=2');
                    exit();                    
                }
                header('Location: View/homeAdmin.php?successo=true');
                exit();
            break;   
            
            case 'modifica-account-scuole':
                $scuola=$this->modello->getScuolaDaCodice($_GET["codice_meccanografico"]);
                $_SESSION["scuola"]=serialize($scuola);
                header('Location: View/modificaScuola.php');
                exit();
            break;
            
            case 'invio-modifica-dati-scuola':
                $scuola=new Scuola(
                    $_POST["codiceMeccanografico"],
                    $_POST["nome"],
                    "",//l'email non è impostata, ma in questo caso non serve
                    $_POST["citta"],
                    $_POST["indirizzo"]
                );
                if($this->modello->modificaScuola($scuola)!=true){
                    header('Location: View/modificaScuola.php?errore=2');
                    exit();
                }else{
                    header('Location: View/modificaScuola.php?successo=true');
                    exit();
                }
            break;
            
            case 'invio-modifica-credenziali-scuola':
                if(isset($_POST["password"])){
                    if( $this->modello->modificaPassword($_POST["vecchiaEmail"],hash('sha256',$_POST["password"]))){
                        header('Location: View/modificaScuola.php?errore=2');
                        exit();
                    }
                }else if(isset($_POST["email"])){
                    if($this->modello->modificaEmail($_POST["vecchiaEmail"],$_POST["email"])){
                        header('Location: View/modificaScuola.php?errore=2');
                        exit();
                    }else{
                        header('Location: View/modificaScuola.php?successo=true');
                        exit();                        
                    }
                }
            break;
            
            default:
                header('Location: View/errore.php');
            break;
        }
    }
}
/*
In alcuni casi di errore si viene reindirizzati alla pagina di "origine" con un parametro del
tipo (?errore=1) il numero rappresenta un tipo di errore, la lista che associa il numero con
l'errore è sulla wiki di github al seguente link:
(https://github.com/LeonardoDeFaveri/ErasmusAdvisor/wiki/Struttura-del-sito)
*/
?>