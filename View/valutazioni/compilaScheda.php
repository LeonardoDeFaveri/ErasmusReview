<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/ModelloSchedaDiValutazione.php";
include_once "{$_SESSION['root']}/Model/SchedaDiValutazione.php";

$html = creaHeader("Compila scheda");
if(!isset($_SESSION['email_utente'])) {
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso con un account per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}else{
    $html.=creaBarraMenu($_SESSION['email_utente']); 
    $modelloScheda=unserialize($_SESSION['modello_scheda']);
    $aspetti=$modelloScheda->getAspetti();
    $html.=<<<testo
        <form action="{$_SESSION['web_root']}/index.php?comando=inserisci-scheda-compilata" method="POST">
            <fieldset>
                <legend>Compila scheda di valutazione</legend>
    testo;
    foreach($aspetti as $aspetto){     
        $html.=<<<testo
            <label>{$aspetto->getNome()}</label><br>
            <input type="number" name="{$aspetto->getId()}" min="1" max="5" required>
        testo;   
    }
    $html.=<<<testo
                <input type="submit">
            </fieldset>
        </form>
    testo;
    
}
$html.=creaFooter();

echo $html;

?>