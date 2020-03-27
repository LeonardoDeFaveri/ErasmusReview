<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . '/../';
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
        <a href="login.php">Accedi</a>
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
                    <summary>Percorsi Futuri</summary>\n
            testo;
            foreach ($futuri as $percorso) {
                $html .= creaRiquadroPercorso($percorso, true);
            }
            $html .= "</details>\n";
        }
        if(count($inCorso) > 0){
            $html .=<<<testo
                <details open>
                    <summary>Percorsi Attivi</summary>\n
            testo;
            foreach ($inCorso as $percorso) {
                $html .= creaRiquadroPercorso($percorso, true);
            }
            $html .= "</details>\n";
        }
        if(count($conclusi) > 0){
            $html .=<<<testo
                <details>
                    <summary>Percorsi Conclusi</summary>\n
            testo;
            foreach ($conclusi as $percorso) {
                $html .= creaRiquadroPercorso($percorso);
            }
            $html .= "</details>\n";
        }
    }

    $html .=<<<testo
                <hr>
                <form method="POST" action="../index.php?comando=crea-percorso">
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
                        <a href="../index.php?comando=mostra-studenti&codice_scuola={$scuola->getId()}">Tutti gli studenti</a><br>
                        <a href="#">Aggiungi Classe</a>
                        <ul>\n
    testo;
    if(count($classi) > 0){
        foreach ($classi as $classe){
            $html .= "<li>{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}</li>\n";
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

function creaRiquadroPercorso($percorso, $modificabile = false){
    $classe = $percorso->getClasse();
    $docente = $percorso->getDocente();
    $html =<<<testo
        <div class="riquadro-percorso">
            <p>{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}</p>
            <p>{$docente->getCognome()} {$docente->getNome()}</p>
            <p>{$percorso->getDal()} - {$percorso->getAl()}</p>\n
    testo;
    if($modificabile){
        $html .=<<<testo
            <form action="../index.php?comando=modifica-percorso&id={$percorso->getId()}" method="POST">
                <button type="submit">Modifica</button>
            </form>\n
        testo;
    }else{
        $html .=<<<testo
            <form action="../index.php?comando=mostra-info-percorso&id={$percorso->getId()}" method="POST">
                <button type="submit">Mostra info</button>
            </form>\n
        testo;
    }
    $html .= "</div>\n";
    return $html;
}
?>