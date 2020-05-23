<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Azienda.php";

$html = creaHeader("Azienda");
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "", $_SESSION['tipo_utente'] ?? "");
if(!isset($_SESSION['email_utente'])){
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
    $html .= creaFooter();
    echo $html;
    return;
}

if(isset($_GET['errore']) ){
    switch($_GET['errore']){
        case 3:
            $html .= "<h2>L'azienda selezionata non esiste</h2>";
        break;
    }
    $html .= creaFooter();
    echo $html;
    return;
}

$aspetti = unserialize($_SESSION['valutazioni_medie']);
$azienda = unserialize($_SESSION['azienda']);
$html .=<<<testo
    <div class="contenitore-centrato">
        <div class="riquadro">
            <b>Dati dell' azienda</b><br>
            <hr>
            <strong>Nome: </strong>{$azienda->getNome()}<br>
            <strong>Email: </strong>{$azienda->getEmail()}<br> 
            <strong>Stato: </strong>{$azienda->getStato()}<br>
            <strong>Citta: </strong>{$azienda->getCitta()}<br>
            <strong>Indirizzo: </strong>{$azienda->getIndirizzo()}<br>
            <strong>Telefono: </strong>{$azienda->getTelefono()}<br>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th>Aspetto</th>
                        <th>Voto medio</th>
                    </tr>
                </thead>
                <tbody>
    testo;
    foreach($aspetti as $aspetto){
        $html.=<<<testo
            <tr>
                <td>{$aspetto->getAspetto()->getNome()}</td>
                <td>{$aspetto->getVoto()}</td>
            </tr>
        testo;
    }
    $html .=<<<testo
                </tbody>
            </table>
        </div>
    </div>
    testo;
$html .= creaFooter();
echo $html;
?>