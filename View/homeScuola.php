<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";

/**
 * Questa pagina gestisce tutte le operazioni che possono essere effettuate
 * dal responsabile di una scuola (utente di tipo: scuola)
 */

$html = creaHeader("Amministrazione Scuola");
if(isset($_GET['errore']) || !isset($_SESSION['scuola'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come amministratore di una scuola per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $scuola = unserialize($_SESSION['scuola']);
}
$html .= creaFooter();
echo $html;
?>