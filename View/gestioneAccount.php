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

if(!isset($_SESSION['email_utente'])) {
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso con un account per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else if($_SESSION["tipo_utente"]!="admin"){
    $soggetto = unserialize($_SESSION[$_SESSION["tipo_utente"]]);
    $html .= creaBarraMenu($_SESSION["email_utente"]);

    if(isset($_GET["errore"])){
        if($_GET["errore"]==2){
            $html .= "<h2>Errore generico, non sono riuscito a cambiare la password</h2>\n";
        }
    }
    
    $html .=<<<testo
        <h2>Gestione account</h2>
        <div id="gestione-account">
            <div>
                <h3>I tuoi dati</h3>
    testo;

    switch($_SESSION["tipo_utente"]){
        case 'azienda':
            $html.=<<<testo
                    <p><strong>Email: </strong>{$soggetto->getEmail()}</p>
                    <p><strong>Nome: </strong>{$soggetto->getNome()}</p>
                    <p><strong>Stato: </strong>{$soggetto->getStato()}</p>
                    <p><strong>Citt&agrave;: </strong>{$soggetto->getCitta()}</p>
                    <p><strong>Indirizzo: </strong>{$soggetto->getIndirizzo()}</p>
                    <p><strong>Telefono: </strong>{$soggetto->getTelefono()}</p>\n
            testo;
        break;
        case 'agenzia':
            $html.=<<<testo
                    <p><strong>Email: </strong>{$soggetto->getEmail()}</p>
                    <p><strong>Nome: </strong>{$soggetto->getNome()}</p>
                    <p><strong>Stato: </strong>{$soggetto->getStato()}</p>
                    <p><strong>Citt&agrave;: </strong>{$soggetto->getCitta()}</p>
                    <p><strong>Indirizzo: </strong>{$soggetto->getIndirizzo()}</p>
                    <p><strong>Telefono: </strong>{$soggetto->getTelefono()}</p>\n
            testo;
        break;
        case 'studente':
            $html.=<<<testo
                    <p><strong>Email: </strong>{$soggetto->getEmail()}</p>
                    <p><strong>Nome: </strong>{$soggetto->getNome()}</p>
                    <p><strong>Cognome: </strong>{$soggetto->getCognome()}</p>
                    <p><strong>Data di nascita: </strong>{$soggetto->getDataNascita()}</p>\n
            testo;
        break;
        case 'docente':
            $html.=<<<testo
                    <p><strong>Email: </strong>{$soggetto->getEmail()}</p>
                    <p><strong>Nome: </strong>{$soggetto->getNome()}</p>
                    <p><strong>Cognome: </strong>{$soggetto->getCognome()}</p>\n
            testo;
        break;
        case 'scuola':
            $html .=<<<testo
                    <p><strong>Email: </strong>{$soggetto->getEmail()}</p>
                    <p><strong>Codice Meccanografico: </strong>{$soggetto->getId()}</p>
                    <p><strong>Nome: </strong>{$soggetto->getNome()}</p>
                    <p><strong>Citt&agrave;: </strong>{$soggetto->getCitta()}</p>
                    <p><strong>Indirizzo: </strong>{$soggetto->getIndirizzo()}</p>\n
            testo;
        break;
        case 'admin':
            //da creare la classe per l admin
            $html="";
        break;
    }
    
    $html.=<<<testo
        </div>
        <fieldset>
        <legend>Modifica password</legend>
            <form method="POST" action="../index.php?comando=cambio-password" onsubmit="return controlloCorrispondezaPassword(this)">           
                <label>Cambia password:</label><br>
                <input type="password" name="password" required><br>
                <label>Conferma password</label><br>
                <input type="password" name="passwordConferma" required><br>
                <input type="submit">
            </form>
        </fieldset>
        </div>\n
    testo; 
}else{
    $html.=<<<testo

        </div>
    testo;
}

$html.=creaFooter();
echo $html;


function creaForm(){
    $html=<<<testo
    </div class="contenitore-centrato">
    <fieldset>
    <legend>Modifica password</legend>
        <form method="POST" action="../index.php?comando=cambio-password" onsubmit="return controlloCorrispondezaPassword(this)">           
            <label>Cambia password:</label><br>
            <input type="password" name="password" required><br>
            <label>Conferma password</label><br>
            <input type="password" name="passwordConferma" required><br>
            <input type="submit">
        </form>
    </fieldset>
    </div>\n
    <div>
    <fieldset>
    <legend>Modifica email</legend>
        <form method="POST" action="../index.php?comando=cambio-email">           
            <label>Cambia email:</label><br>
            <input type="email" name="password" required><br>
            <label>Conferma email:</label><br>
            <input type="email" name="passwordConferma" required><br>
            <input type="submit">
        </form>
    </fieldset>
    
    </div>
    testo;
}