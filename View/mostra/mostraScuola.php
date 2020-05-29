<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Scuola");
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "", $_SESSION['tipo_utente'] ?? "");
if(!isset($_SESSION['email_utente'])) {
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/View/login.php">Accedi</a>
    testo;
    $html .= creaFooter();
    echo $html;
    return;
}

if(isset($_GET['errore']) ){
    switch($_GET['errore']){
        case 3:
            $html .= "<h2>La scuola selezionata non esiste</h2>";
        break;
    }
    $html .= creaFooter();
    echo $html;
    return;
}

$scuola = unserialize($_SESSION['scuola']);
$html.=<<<testo
    <div class="contenitore-centrato">
        <div class="riquadro">
            <strong>Dati dell' azienda</strong><br>
            <hr>
            <span><strong>Codice meccanografico: </strong>{$scuola->getId()}</span><br>
            <span><strong>Nome: </strong>{$scuola->getNome()}</span><br>
            <span><strong>Email: </strong>{$scuola->getEmail()}</span><br> 
            <span><strong>Citta: </strong>{$scuola->getCitta()}</span><br>
            <span><strong>Indirizzo: </strong>{$scuola->getIndirizzo()}</span><br>
        </div>
    </div>
testo;

$html .= creaFooter();
echo $html;
?>