<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . '/../';
}
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Amministrazione Scuola");
if(isset($_GET['errore']) || !isset($_SESSION['scuola'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come amministratore scolastico per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $scuola = unserialize($_SESSION['scuola']);
    $html .= creaBarraMenu($scuola->getEmail());
    $classi = unserialize($_SESSION['classi']);
    $docenti = unserialize($_SESSION['docenti']);
}
$html .= creaFooter();
echo $html;
?>