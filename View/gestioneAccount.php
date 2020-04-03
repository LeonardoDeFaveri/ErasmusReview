<?php 
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Agenzia.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Azienda.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";

$html = creaHeader("Gestione Account");
$html = $html . creaBarraMenu($_SESSION["email_utente"]);


$soggetto=unserialize($_SESSION[$_SESSION["tipo_utente"]]);

switch($_SESSION["tipo_utente"]){
    case "azienda":
        $html.=<<<testo
        <div id="dati-personali">
            <p><strong>Email: </strong>{$soggetto->getEmail()}</p>
            <p><strong>Nome: </strong>{$soggetto->getNome()}</p>
            <p><strong>Stato: </strong>{$soggetto->getStato()}</p>
            <p><strong>Citt&agrave;: </strong>{$soggetto->getCitta()}</p>
            <p><strong>Indirizzo: </strong>{$soggetto->getIndirizzo()}</p>
            <p><strong>Telefono: </strong>{$soggetto->getTelefono()}</p>
        </div>
    testo;
        break;
    case "agenzia":
        $html.=<<<testo
        <div>
            <p><strong>Email: </strong>{$soggetto->getEmail()}</p>
            <p><strong>Nome: </strong>{$soggetto->getNome()}</p>
            <p><strong>Stato: </strong>{$soggetto->getStato()}</p>
            <p><strong>Citt&agrave;: </strong>{$soggetto->getCitta()}</p>
            <p><strong>Indirizzo: </strong>{$soggetto->getIndirizzo()}</p>
            <p><strong>Telefono: </strong>{$soggetto->getTelefono()}</p>
        </div>
    testo;
        break;
    case "studente":
        $html.=<<<testo
            <div>
                <p><strong>Email: </strong>{$soggetto->getEmail()}</p>
                <p><strong>Nome: </strong>{$soggetto->getNome()}</p>
                <p><strong>Cognome: </strong>{$soggetto->getCognome()}</p>
                <p><strong>Data di nascita: </strong>{$soggetto->getDataNascita()}</p>
            </div>
        testo;
        break;
    case "docente":
        $html.=<<<testo
        <div>
            <p><strong>Email: </strong>{$soggetto->getEmail()}</p>
            <p><strong>Nome: </strong>{$soggetto->getNome()}</p>
            <p><strong>Cognome: </strong>{$soggetto->getCognome()}</p>
        </div>
    testo;
        break; 
    case "admin":
        //da creare la classe per l admin
        $html="";
        break;
}

$html.=<<<testo
    <form method="POST" action="../index.php?comando=cambio-password" onsubmit="return controlloCorrispondezaPassword(this)">
        <fieldset>
            <legend>Modifica password</legend>
            <label>Cambia password:</label><br>
            <input type="password" name="password" required><br>
            <label>Conferma password</label><br>
            <input type="password" name="passwordConferma" required><br>
            <input type="submit">
        </fieldset>
    </form>\n
testo; 

if(isset($_GET["errore"])){
    if($_GET["errore"]==2){
        $html.="<p>Errore generico, non sono riuscito a cambiare la password</p>";
    }
}



$html.=creaFooter();
echo $html;