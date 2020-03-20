<?php 
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Gestione Account");
$html = $html . creaBarraMenu($_SESSION["email_utente"]);

$html.=<<<testo
    <form action="?azione=cambio-password" method="POST" onsubmit="return controlloCorrispondezaPassword(this)">
        <fieldset>
            <legend>Modifica password</legend>
            <label>Cambia password:</label><br>
            <input type="password" name="password" required><br>
            <label>Conferma password</label><br>
            <input type="password" name="passwordConferma" required><br>
            <input type="submit">
        </fieldset>
    </form>\n
testo; 

$html.=creaFooter();
echo $html;