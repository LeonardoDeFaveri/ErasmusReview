<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusAdvisor";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$studente = unserialize($_SESSION['studente']);

if(!isset($_SESSION['email_utente'])) {
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso con un account per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}
else{
    $html = creaHeader($studente->getNome()." ".$studente->getCognome());
    $html .= creaBarraMenu($_SESSION['email_utente']);
    $html .= <<<testo
        <div>
            <ul>
                <li>Nome: {$studente->getNome()}</li>
                <li>Cognome: {$studente->getCognome()}</li>
                <li>Email: {$studente->getEmail()}</li>
                <li>Data di nascita: {$studente->getDataNascita()}</li>
            </ul>
        </div>
    testo;
}

$html .= creaFooter();
echo $html;
?>