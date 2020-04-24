<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusAdvisor";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Amministrazione Scuola");
if(isset($_GET['errore']) || !isset($_SESSION['scuola'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come amministratore scolastico per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}else{
    $scuola = unserialize($_SESSION['scuola']);
    $html .= creaBarraMenu($scuola->getEmail());
    $classi = unserialize($_SESSION['classi']);
    $docenti = unserialize($_SESSION['docenti']);
    $percorsi = unserialize($_SESSION['percorsi']);
    
    $html .=<<<testo
        <main class="pagina-con-barra-laterale">
            <div class="contenuto">
                <h2>Tutti i percorsi</h2>
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

    $html .=<<<testo
                <hr>
                <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-percorso">
                    <button type="submit" id="crea-percorso">Crea percorso</button>
                </form>
            </div>
            <div class="barra-laterale">
                <details open>
                    <summary>Docenti</summary>
                    <div>
                        <a href="#">Aggiungi Docente</a>
                        <ul>\n
    testo;
    if(count($docenti) > 0){
        foreach ($docenti as $docente) {
            $html .= "<li>{$docente->getCognome()} {$docente->getNome()}</li>\n";
        }
    }
    $html .=<<<testo
                        </ul>
                    </div>
                </details>
                <details open>
                    <summary>Classi e studenti</summary>
                    <div>
                        <a href="{$_SESSION['web_root']}/index.php?comando=mostra-studenti&codice_scuola={$scuola->getId()}">Tutti gli studenti</a><br>
                        <a href="{$_SESSION['web_root']}/index.php?comando=crea-classe&codice_scuola={$scuola->getId()}">Aggiungi Classe</a>
                        <ul>\n
    testo;
    if(count($classi) > 0){
        foreach ($classi as $classe){
            $html .= "<li><a href=\"{$_SESSION['web_root']}/index.php?comando=mostra-classe&id={$classe->getId()}\">{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}</a></li>\n";
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
            \t\t\t<a href="#">{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}</a><br>
            \t\t\t<a href="#">{$scuola->getNome()}</a>
            \t\t\t<hr>
            \t\t\t<a href="#">{$percorso->getDal()} {$percorso->getAl()}</a><br>
            <div class="contenitore-bottoni-riquadro">\n
    testo;
    if(!$terminato){
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