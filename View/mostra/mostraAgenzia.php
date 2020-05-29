<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}

include_once "{$_SESSION['root']}/Model/Soggetti/Agenzia.php";
include_once "{$_SESSION['root']}/Model/Valutazione.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Agenzia");
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
            $html .= "<h2>L'agenzia selezionata non esiste</h2>";
        break;
    }
    $html .= creaFooter();
    echo $html;
    return;
}

$valutazioni = unserialize($_SESSION['valutazioni_medie_agenzia']);
$agenzia = unserialize($_SESSION['agenzia']);
$html .=<<<testo
    <div class="contenitore-centrato">
        <div>
            <div class="riquadro">
                <b>Dati dell'agenzia</b><br>
                <strong>Nome: </strong>{$agenzia->getNome()}<br>
                <strong>Email: </strong>{$agenzia->getEmail()}<br>
                <strong>Stato: </strong>{$agenzia->getStato()}<br>
                <strong>Citt&agrave;: </strong>{$agenzia->getCitta()}<br>
                <strong>Indirizzo: </strong>{$agenzia->getIndirizzo()}<br>
                <strong>Telefono: </strong>{$agenzia->getTelefono()}<br>
            </div>
            <hr>
testo;

if(count($valutazioni) == 0){
    $html .= "<h3>Questa agenzia non è ancora stata valutata</h3>\n";
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

$html .=<<<testo
        </div>
    </div>
testo;

$html .= creaFooter();
echo $html;
?>