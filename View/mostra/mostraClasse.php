<?php 
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusAdvisor";
}
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$classe = unserialize($_SESSION['classe']);
$docenti = unserialize($_SESSION['docenti']);

$html = creaHeader("{$classe->getNumero()}.{$classe->getSezione()}.{$classe->getAnnoscolastico()}");
$html .= creaBarraMenu($_SESSION['email_utente']);

$html.=<<<testo
    <p><strong>Classe:</strong> {$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoscolastico()}</p>
    <div class="contenitore-centrato">
        <p><strong>Studenti:</strong></p> 
        <table>
            <thead>
                <tr>
                    <td>Nome</td>
                    <td>Cognome</td>
                    <td>Email</td>
                    <td>Data di nascita</td>
                </tr>
            </thead>
            <tbody>
testo;

$studenti = $classe->getStudenti();

foreach($studenti as $elemento){
    $html .=<<<testo
        <tr>
            <td>{$elemento->getNome()}</td>
            <td>{$elemento->getCognome()}</td>
            <td><a href="{$_SESSION['web_root']}/index.php?comando=mostra-studente&id={$elemento->getId()}">{$elemento->getEmail()}</a></td>
            <td>{$elemento->getDataNascita()}</td>
        </tr>
    testo;
}
$html .=<<<testo
        </tbody>
    </table>
testo;

$html .=<<<testo
    <p><strong>Docenti:</strong></p>
    <table>
        <thead>
            <tr>
                <td>Nome</td>
                <td>Cognome</td>
                <td>Email</td>
            </tr>
        </thead>
        <tbody>
testo;

foreach($docenti as $elemento){
    $html.=<<<testo
        <tr>
            <td>{$elemento->getNome()}</td>
            <td>{$elemento->getCognome()}</td>
            <td><a href="{$_SESSION['web_root']}/index.php?comando=mostra-docente&id={$elemento->getId()}">{$elemento->getEmail()}</a></td>
        </tr>
    testo;
}

$html.=<<<testo
        </tbody>
    </table>
testo;

$html.=creaFooter();

echo $html;