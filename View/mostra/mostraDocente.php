<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusAdvisor";
}
include_once "{$_SESSION['root']}/Model/Soggetti/docente.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$docente = unserialize($_SESSION['docente']);

if(!isset($_SESSION['email_utente'])) {
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso con un account per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}
else{
    $html = creaHeader($docente->getNome()." ".$docente->getCognome());
    $html .= creaBarraMenu($_SESSION['email_utente']);
    $html .= <<<testo
        <div>
            <ul>
                <li>Nome: {$docente->getNome()}</li>
                <li>Cognome: {$docente->getCognome()}</li>
                <li>Email: {$docente->getEmail()}</li>
            </ul>
        </div>
    testo;
}

$html .= creaFooter();
echo $html;
?>