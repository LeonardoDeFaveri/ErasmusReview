<?php 
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Gestione Account");
$html = $html . creaBarraMenu($_SESSION["email_utente"]);

$html.="<form action=\"?azione=cambio-password\" method=\"POST\" onsubmit=\"return controlloCorrispondezaPassword(this)\">\n
    <fieldset>
    <legend>Modifica password</legend>
    <label>Cambia password:</label><br>\n
    <input type=\"password\" name=\"password\" required><br>\n
    <label>Conferma password</label><br>\n
    <input type=\"password\" name=\"passwordConferma\" required><br>\n
    <input type=\"submit\">\n
    </fieldset>
</form>\n"; 

$html.=creaFooter();
echo $html;