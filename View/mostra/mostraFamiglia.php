<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Famiglia.php";
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/Model/Valutazione.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Famiglia");
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "", $_SESSION['tipo_utente'] ?? "");
if(!isset($_SESSION['email_utente'])) {
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
    $html .= creaFooter();
    echo $html;
    return;
}

if(isset($_GET['errore'])){
    switch($_GET['errore']){
        case 3:
            $html .= "<h2>La famiglia selezionata non esiste</h2>";
        break;
    }
    $html .= creaFooter();
    echo $html;
    return;
}
$valutazioni = unserialize($_SESSION['valutazioni_medie_famiglia']);
$famiglia = unserialize($_SESSION['famiglia']);
$html .=<<<testo
    <h2>Dati della famiglia</h2>
    <div class="contenitore-centrato">
        <div>
            <div class="riquadro">
                <strong>Dati della famiglia</strong><br>
                <hr>
                <strong>Cognome: </strong>{$famiglia->getCognome()}<br>
                <strong>Nome: </strong>{$famiglia->getNome()}<br> 
                <strong>Citta: </strong>{$famiglia->getCitta()}<br>
                <strong>Indirizzo: </strong>{$famiglia->getIndirizzo()}<br>
            </div>
            <hr>
testo;

if(count($valutazioni) == 0){
    $html .= "<h3>Questa famiglia non è ancora stata valutata</h3>\n";
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
