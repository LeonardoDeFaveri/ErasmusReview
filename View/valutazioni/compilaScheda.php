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
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "", $_SESSION['tipo_utente'] ?? "");
if(!isset($_SESSION['email_utente'])) {
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso con un account per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/View/login.php">Accedi</a>
    testo;
    $html .= creaFooter();
    echo $html;
    return;
}

if(isset($_GET['errore'])){
    switch($_GET['errore']){
        case 2:
            $html .=<<<testo
            <script>
                alert("L'inserimento della scheda non è andato a buon fine");
            </script>
            testo;
        break;
        case 3:
            $html .= "<h2>Il modello specificato non esiste</h2>";
            $html .= creaFooter();
            echo $html;
            return;
        break;
        case 4:
            $html .= "<h2>Il tuo utente non può compilare schede di valutazione</h2>";
            $html .= creaFooter();
            echo $html;
            return;
        break;
    }
}

$esperienza = unserialize($_SESSION['esperienza']);
$modello = unserialize($_SESSION['modello']);
$aspetti = $modello->getAspetti();
//onclick fx js
$html.=<<<testo
    <form action="{$_SESSION['web_root']}/index.php?comando=inserisci-scheda-compilata" method="POST" onsubmit="return confermaInvioValutazione()" >
        <fieldset class="form-con-colonne">
            <legend>Compila scheda di valutazione</legend>
            <div class="dati">
testo;
foreach($aspetti as $aspetto){     
    $html.=<<<testo
        <div class="riga">
            <label>{$aspetto->getNome()}</label><br>
            <select name="aspetti[{$aspetto->getId()}]" required>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
    testo;   
}
$html.=<<<testo
            </div>
            <input type="submit">
        </fieldset>
    </form>
testo;

$html.=creaFooter();
echo $html;
?>