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
        $comando = 'login';
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
                $_SESSION ['esperienze']= serialize($this->modello->getEsperienzeDaAgenzia($agenzia->getId()));
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
                /* $id = $_GET['id'] ?? -1; controlla se l id è settato e diverso da null.
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
            
            case 'gestione-account':
                header('Location: View/gestioneAccount.php');
                exit();
            break; 
            
            case 'cambio-password':
                $digest=hash('sha256', $_POST["password"]);
                //modificaPassword restituisce true o false
                if(!$this->modello->modificaPassword($digest)){
                    header('Location: View/gestioneAccount.php?errore=2');
                    exit();
                }
                header('Location: View/gestioneAccount.php?successo=true');
                exit();
            break;
            
            default:
                header('Location: View/errore.php');
            break;
        }
    }
}
/*
In alcuni casi di errore si viene reindirizzati alla pagina di "origine" con un parmetro del tipo ?errore=1
il numero rappresenta un tipo di errore, la lista che associa il numero con l'errore è sulla wiki di github
(https://github.com/LeonardoDeFaveri/ErasmusAdvisor/wiki/Struttura-del-sito)
*/
?>