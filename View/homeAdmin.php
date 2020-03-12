<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}

$html = creaHeader("Amministrazione");
if(isset($_GET['errore']) || !isset($_SESSION['admin'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come admin per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $admin = unserialize($_SESSION['admin']);
    $html .= creaBarraMenu($admin->getEmail());
}
$html .= creaFooter();
echo $html;
?>