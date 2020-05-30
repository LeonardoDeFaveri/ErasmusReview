<?php
/**
 * homeDocente contiene una lista di tutti i percorsi in cui ha partecipato un docente.
 */
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Percorso");
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "", $_SESSION['tipo_utente'] ?? "");
if(!isset($_SESSION['email_utente'])){
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/View/login.php">Accedi</a>
    testo;
    $html .= creaFooter();
    echo $html;
    return;
}

if(isset($_GET['errore']) ){
    switch($_GET['errore']){
        case 3:
            $html .= "<h2>Il percorso selezionato non esiste</h2>";
        break;
    }
    $html .= creaFooter();
    echo $html;
    return;
}

$percorso = unserialize($_SESSION['percorso']);
$esperienze=unserialize($_SESSION['esperienze']);

if(count($esperienze) == 0){
    $html .= "<p>Non è stato ancora definita nessuna esperienza</p>\n";
}
else{
    $html .=<<<testo
    <main class="pagina-con-barra-laterale">
        <div class="contenuto">
            <h2>Tutte le esperienze</h2>\n
    testo;
    $docente=$percorso->getDocente();
    $classe=$percorso->getClasse();
    $html.="<div class=contenitore-riquadri>\n";
    foreach ($esperienze as $esperienza){
        if($esperienza->getFamiglia()!=null){
            if($esperienza->getAgenzia()!=null){
                $html.=creaRiquadro($esperienza,true);
            }
        }
        else{
            $html.=creaRiquadro($esperienza);
        }
    }
    $html .=<<<testo
            </div>
        </div>\n
    testo;
    //creazione barra laterale
    $html .=<<<testo
            <div class="barra-laterale">
                <summary><strong>Dati del percorso</strong></summary>
                <hr>
                <strong>Docente: </strong>{$docente->getNome()}{$docente->getCognome()}<br>
                <strong>Classe: </strong>{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}<br>
                <strong>Dal: </strong>{$percorso->getDal()}<br>
                <strong>Al: </strong>{$percorso->getAl()}<br>
            </div>
    
    testo;
    $html.="</main>";
}
$html .= creaFooter();
echo $html;


function creaRiquadro($esperienza, $erasmus = false) {
    $classe = $esperienza->getPercorso()->getClasse();
    $scuola = $classe->getScuola();
    $azienda = $esperienza->getAzienda();
    $agenzia = $esperienza->getAgenzia();
    $famiglia = $esperienza->getFamiglia();
    $riquadro = "";
    if($erasmus){
        $riquadro .=<<<testo
            \t\t<div class="riquadro erasmus">
                <strong><em>Erasmus</em></strong><br>\n
        testo;
    }else{
        $riquadro .=<<<testo
            \t\t<div class="riquadro pcto">\n
                <strong><em>Pcto</em></strong><br>\n
        testo;
    }
    $riquadro .=<<<testo
            \t\t\t<strong>Classe: </strong>{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}<br>
            \t\t\t<strong>Scuola: </strong><a href="{$_SESSION['web_root']}/index.php?comando=mostra-scuola&codice_meccanografico={$scuola->getId()}">{$scuola->getNome()}</a>
            \t\t\t<hr>
            \t\t\t<b>Dati dell'esperienza</b><br>
            \t\t\t<strong>Dal: </strong>{$esperienza->getDal()} <strong>Al: </strong>{$esperienza->getAl()}<br>
            \t\t\t<strong>Azienda: </strong><a href="{$_SESSION['web_root']}/index.php?comando=mostra-azienda&id={$azienda->getId()}">{$azienda->getNome()}</a><br>\n
    testo;
    if($agenzia != null){
        $riquadro .= "\t\t\t\t\t<strong>Agenzia: </strong><a href='{$_SESSION['web_root']}/index.php?comando=mostra-agenzia&id={$agenzia->getId()}'>{$agenzia->getNome()}</a><br>\n";
    }
    if($famiglia != null){
        $riquadro .= "\t\t\t\t\t<strong>Famiglia: </strong><a href='{$_SESSION['web_root']}/index.php?comando=mostra-famiglia&id={$famiglia->getId()}'>{$famiglia->getCognome()}</a>\n";
    }
    $riquadro .=<<<testo
            \t\t\t<div class="contenitore-bottoni-riquadro">
                \t\t\t<form action="{$_SESSION['web_root']}/index.php?comando=modifica-esperienza&id={$esperienza->getId()}" method="POST">
                    \t\t\t<button type="submit">Modifica</button>
                \t\t\t</form>
            \t\t\t</div>
        \t\t\t</div>\n
    testo;
    return $riquadro;
}
?>
