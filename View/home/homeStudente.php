<?php
/**
 * homeStudente contiene una lista di tutte le esperienze svolte e attive per uno studente.
 */
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Home Studente");
if(isset($_GET['errore']) || !isset($_SESSION['studente'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come studente per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}else{
    $studente = unserialize($_SESSION['studente']);
    $html .= creaBarraMenu($studente->getEmail());

    if(isset($_SESSION['esperienze'])){
        $esperienze = unserialize($_SESSION['esperienze']);
        $inCorso = array();
        $completate = array();

        foreach ($esperienze as $esperienza) {
            if($esperienza->getAl() >= date('Y-m-d')){
                $inCorso[] = $esperienza;
            }else{
                $completate[] = $esperienza;
            }
        }

        //Creazione dei riquadri delle esperienze in corso
        $html .=<<<testo
                <details id="inCorso" open>
                    <summary>In corso..</summary>
                    <div class="contenitore-riquadri">\n
        testo;
        foreach ($inCorso as $esperienza){
            $erasmus = false;
            if($esperienza->getAgenzia()!=null && $esperienza->getFamiglia()!=null){
                $erasmus=true;
            }
            $html .= creaRiquadro($esperienza,false,$erasmus);
        }
        $html .=<<<testo
                    </div>
                </details>\n
        testo;

        //Creazione dei riquadri delle esperiene completate
        $html .=<<<testo
                <details id="completate">
                    <summary>Completate</summary>
                    <div class="contenitore-riquadri">\n
        testo;
        foreach ($completate as $esperienza){
            $erasmus = false;
            if($esperienza->getAgenzia()!=null && $esperienza->getFamiglia()!=null){
                $erasmus=true;
            }
            $html .= creaRiquadro($esperienza, true, $erasmus);
        }
        $html .=<<<testo
                    </div>
                </details>\n
        testo;
    }
}

$html .= creaFooter();
echo $html;

function creaRiquadro($esperienza, $daValutare = false, $erasmus = false) {
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

    if($daValutare){
        $riquadro .=<<<testo
            \t\t\t\t\t<form action="{$_SESSION['web_root']}/index.php?comando=mostra-valutazione-esperienza&id={$esperienza->getId()}" method="POST">
                \t\t\t\t\t<button type="submit">Valutazione</button>
            \t\t\t\t\t</form>\n
        testo;
    }

    $riquadro .=<<<testo
            \t\t\t</div>
        \t\t\t</div>\n
    testo;
    return $riquadro;
}
?>