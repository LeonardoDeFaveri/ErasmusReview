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
$html = creaBarraMenu($_SESSION['email_utente'] ?? "");
if(isset($_GET['errore'])){
    $html .= "<h2>Devi selezionare un'azienda per poter accedere a questa pagina</h2>";
}else{
    $html .=<<<testo
        
    testo;
}

$html .= creaFooter();
echo $html;
?>