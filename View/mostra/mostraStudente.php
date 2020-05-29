<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/Model/Valutazione.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Studente");
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
            $html .= "<h2>Lo studente selezionato non esiste</h2>";
        break;
    }
    $html .= creaFooter();
    echo $html;
    return;
}

$studente = unserialize($_SESSION['studente']);
$classi = unserialize($_SESSION['classi_studente']);
$valutazioni = unserialize($_SESSION['valutazioni_medie_studente']);
$html .=<<<testo
    <div class="contenitore-centrato">
        <div>
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
testo;

if(count($valutazioni) == 0){
    $html .= "<h3>Questo studente non è ancora stato valutato</h3>\n";
}else{
    $html .=<<<testo
            <table>
                <thead>
                    <tr>
                        <th>Aspetto</th>
                        <th>Voto medio</th>
                    </tr>
                </thead>
                <tbody>
    testo;
    foreach($valutazioni as $valutazione){
        $html.=<<<testo
            <tr>
                <td>{$valutazione->getAspetto()->getNome()}</td>
                <td>{$valutazione->getVoto()}</td>
            </tr>
        testo;
    }
    $html .=<<<testo
                </tbody>
            </table>
        </div>
    </div>
    testo;
}

$html .= creaFooter();
echo $html;
?>