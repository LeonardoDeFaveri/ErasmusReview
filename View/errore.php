<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Errore");
if(isset($_SESSION['email_utente'])){
    $html .= creaBarraMenu($_SESSION['email_utente']);
}else{
    $html .= creaBarraMenu("");
}

$codiceErrore = $_GET['errore'] ?? 404;
$html .= "<h2 class='errore'>Errore {$codiceErrore}</h2>";
switch ($codiceErrore) {
    case 404:
        $html .= "<p>La pagina che stai cercando non esiste</p>";
    break;
    case 503:
        $msg_errore = $_SESSION['msg_errore'] ?? "Servizio non disponibile";
        $html .= "<p>{$msg_errore}</p>";
    
    default:
        //In futuro controlli per altri errori
        break;
}

$html .= creaFooter();
echo $html;
?>