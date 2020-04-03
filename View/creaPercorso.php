<?php
/**
 * creaPercorso permette di creare un percorso.
 */
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}

include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Creazione Percorso");
if(isset($_GET['errore']) || !isset($_SESSION['docente']) || !isset($_SESSION['scuola'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come docente o scuola per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{

}
?>