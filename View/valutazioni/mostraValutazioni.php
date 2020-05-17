<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/SchedaDiValutazione.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Valutazioni");
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "");
if(!isset($_SESSION['email_utente'])){
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
    $html .= creaFooter();
    echo $html;
    return;
}
if(isset($_GET['errore'])){
    if($_GET['errore'] == 1){
        $html .=<<<testo
            <h2>Il tuo tipo di account non è autorizzato ad accedere a questa pagina</h2>
            <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
        testo;
        $html .= creaFooter();
        echo $html;
        return;
    }
}

$esperienza = unserialize($_SESSION['esperienza']);
$schedeDiValutazione = unserialize($_SESSION['schede_di_valutazione']);

$html .=<<<testo
        <h2>Schede di valutazione per l'esperienza</h2>
        <div class="contenitore-centrato">\n
testo;
$html .= creaRiquadro($esperienza);
switch($_SESSION['tipo_utente']){
    case 'studente':

    break;
    case 'azienda':

    break;
    case 'agenzia':
    
    break;
}

$html .= "</div>";
$html .= creaFooter();
echo $html;
return;

function creaRiquadro($esperienza) {
    $classe = $esperienza->getPercorso()->getClasse();
    $scuola = $classe->getScuola();
    $tutor = $esperienza->getPercorso()->getDocente();
    $azienda = $esperienza->getAzienda();
    $agenzia = $esperienza->getAgenzia();
    $famiglia = $esperienza->getFamiglia();
    $riquadro =<<<testo
        \t\t\t<div class="riquadro">
            \t\t\t{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}<br>
            \t\t\t{$scuola->getNome()}
            \t\t\t{$tutor->getNome()}
            \t\t\t<hr>
            \t\t\t<b>Dati dell'esperienza</b><br>
            \t\t\t{$esperienza->getDal()} {$esperienza->getAl()}<br>
            \t\t\t<a href="#">{$azienda->getNome()}</a><br>\n
    testo;
    if($agenzia != null){
        $riquadro .= "\t\t\t\t\t<a href='#'>Agenzia {$agenzia->getNome()}</a><br>\n";
    }
    if($famiglia != null){
        $riquadro .= "\t\t\t\t\t<a href='#'>Famiglia {$famiglia->getCognome()}</a>\n";
    }

    $riquadro .=<<<testo
        \t\t\t</div>\n
    testo;
    return $riquadro;
}
?>
?>