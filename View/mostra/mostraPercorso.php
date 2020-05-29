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
if(isset($_GET['errore']) || !isset($_SESSION['docente'])){
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come docente per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}else{
    
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
            </div>
        testo;
        $docente=$percorso->getDocente();
        $classe=$percorso->getClasse();
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
            </main>\n
        testo;

        foreach ($esperienze as $esperienza){
            if($esperienza->getFamiglia()!=null){
                if($esperienza->getAgenzia()!=null){
                    $html.=creaRiquadro($esperienza,true);
                }
            }
            $html.=creaRiquadro($esperienza);
        }
    }
}
$html .= creaFooter();
echo $html;


function creaRiquadro($esperienza, $erasmus = false) {
    $classe = $esperienza->getPercorso()->getClasse();
    $scuola = $classe->getScuola();
    $azienda = $esperienza->getAzienda();
    $agenzia = $esperienza->getAgenzia();
    $famiglia = $esperienza->getFamiglia();
    $riquadro = $erasmus ? "\t\t\t<div class=\"riquadro erasmus\">\n<strong><em>Erasmus</em></strong><br>\n" : "\t\t\t<div class=\"riquadro pcto\">\n<strong><em>Pcto</em></strong><br>";
    $riquadro.=<<<testo
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
    $riquadro .= "\t\t\t\t\t<div class='contenitore-bottoni-riquadro'>\n";
    return $riquadro;
}
?>
