<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusAdvisor";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

if(!isset($_SESSION['email_utente'])) {
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso con un account per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}
else{
    $studente = unserialize($_SESSION['studente']);
    $classi = unserialize($_SESSION['classi_studente']);
    $html = creaHeader($studente->getNome()." ".$studente->getCognome());
    $html .= creaBarraMenu($_SESSION['email_utente']);
    $html .=<<<testo
        <div class="contenitore-centrato">
            <div class="riquadro">
                <b>Dati dello Studente</b><br>
                {$studente->getNome()} {$studente->getCognome()}<br>
                {$studente->getEmail()}<br>
                {$studente->getDataNascita()}
                <hr>
                <b>Classi dello studente</b>
                <ul>\n
    testo;

    foreach ($classi as $classe) {
        $html .=<<<testo
                <li>{$classe->getNumero()}{$classe->getSezione()} - {$classe->getAnnoScolastico()}</li>\n
        testo;
    }

    $html .=<<<testo
                </ul>
            </div>
        </div>
    testo;
}

$html .= creaFooter();
echo $html;
?>