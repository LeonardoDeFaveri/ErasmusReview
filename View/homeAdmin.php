<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}

$html = creaHeader("Amministrazione");
if(isset($_GET['errore']) || !isset($_SESSION['email_utente'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come admin per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $admin = $_SESSION['email_utente'];
    $html .= creaBarraMenu($admin);
    
}
$html .= creaFooter();
echo $html;
?>