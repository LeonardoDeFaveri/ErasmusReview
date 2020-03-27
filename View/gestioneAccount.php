<?php 
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Gestione Account");
$html = $html . creaBarraMenu($_SESSION["email_utente"]);


$soggetto=unserialize($_SESSION[$_SESSION["tipo_utente"]]);

switch($_SESSION["tipo_utente"]){
    case "azienda":
        break;
    case "agenzie":
        break;
    case "studente":
        break;
    case "docente":
        break; 
    case "admin":
        break;
}

$html.=<<<testo
    <form method="POST" action="../index.php?comando=cambio-password" onsubmit="return controlloCorrispondezaPassword(this)">
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

if(isset($_GET["errore"])){
    if($_GET["errore"]==2){
        $html.="<p>Errore generico, non sono riuscito a cambiare la password</p>";
    }
}



$html.=creaFooter();
echo $html;