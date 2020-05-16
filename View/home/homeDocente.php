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
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Home Docente");
if(isset($_GET['errore']) || !isset($_SESSION['docente'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come docente per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}else{
    $docente = unserialize($_SESSION['docente']);
    $html .= creaBarraMenu($docente->getEmail());
    $classi = unserialize($_SESSION['classi']);
    $percorsi = unserialize($_SESSION['percorsi']);

    $html .=<<<testo
        <main class="pagina-con-barra-laterale">
            <div class="contenuto">
                <h2>Tutti i percorsi</h2>\n
    testo;

    if(count($percorsi) == 0){
        $html .= "<p>Non è stato ancora definito nessun percorso</p>\n";
    }else{
        $futuri = array();
        $inCorso = array();
        $conclusi = array();

        foreach ($percorsi as $percorso) {
            if($percorso->getDal() > date('Y-m-d')){
                $futuri[] = $percorso;
            }else if($percorso->getAl() > date('Y-m-d')){
                $inCorso[] = $percorso;
            }else{
                $conclusi[] = $percorso;
            }
        }

        if(count($futuri) > 0){
            $html .=<<<testo
                <details open>
                    <summary>Percorsi Futuri</summary>
                    <div class="contenitore-riquadri">\n
            testo;
            foreach ($futuri as $percorso) {
                $html .= creaRiquadroPercorso($percorso);
            }
            $html .=<<<testo
                    </div>
                </details>\n
            testo;
        }
        if(count($inCorso) > 0){
            $html .=<<<testo
                <details open>
                    <summary>Percorsi Attivi</summary>
                    <div class="contenitore-riquadri">\n
            testo;
            foreach ($inCorso as $percorso) {
                $html .= creaRiquadroPercorso($percorso);
            }
            $html .=<<<testo
                    </div>
                </details>\n
            testo;
        }
        if(count($conclusi) > 0){
            $html .=<<<testo
                <details>
                    <summary>Percorsi Conclusi</summary>
                    <div class="contenitore-riquadri">\n
            testo;
            foreach ($conclusi as $percorso) {
                $html .= creaRiquadroPercorso($percorso, true);
            }
            $html .=<<<testo
                    </div>
                </details>\n
            testo;
        }
    }

    $html.=<<<testo
                <hr>
                <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-percorso">
                    <button type="submit" id="crea-percorso">Crea Percorso</button>
                </form>
                <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-esperienza">
                    <button type="submit" id="crea-percorso">Crea Esperienza</button>
                </form>
            </div>
    testo;

    //creazione barra laterale
    $html .=<<<testo
            <div class="barra-laterale">
                <details open>
                    <summary>Le mie Classi</summary>
                    <div>
                        <ul>\n
    testo;
    if(count($classi) > 0){
        foreach ($classi as $classe){
            $html .= "<li><a href='{$_SESSION['web_root']}/index.php?comando=mostra-classe&id={$classe->getId()}'>{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}<a/></li>\n";
        }
    }
    $html .=<<<testo
                        </ul>
                    </div>
                </details>
            </div>
        </main>\n
    testo;
}

$html .= creaFooter();
echo $html;

function creaRiquadroPercorso($percorso, $terminato = false) {
    $classe = $percorso->getClasse();
    $scuola = $classe->getScuola();
    $html =<<<testo
        \t\t\t<div class="riquadro">
            \t\t\t{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}<br>
            \t\t\t{$scuola->getNome()}
            \t\t\t<hr>
            \t\t\t{$percorso->getDal()} {$percorso->getAl()}<br>
            <div class="contenitore-bottoni-riquadro">\n
    testo;
    if($terminato){
        $html .=<<<testo
            <form action="{$_SESSION['web_root']}/index.php?comando=valutazione-percorso&id={$percorso->getId()}" method="POST">
                <button type="submit">Valutazione</button>
            </form>\n
        testo;
    }else{
        $html .=<<<testo
            <form action="{$_SESSION['web_root']}/index.php?comando=modifica-percorso&id={$percorso->getId()}" method="POST">
                <button type="submit">Modifica</button>
            </form>\n
        testo;
    }
    $html .=<<<testo
                <form action="{$_SESSION['web_root']}/index.php?comando=mostra-percorso&id={$percorso->getId()}" method="POST">
                    <button type="submit">Mostra info</button>
                </form>
            </div>
        </div>
    testo;
    return $html;
}
?>