<?php
/**
 * homeDocente contiene una lista di tutti i percorsi in cui ha partecipato un docente.
 */
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Home");
if(isset($_GET['errore']) || !isset($_SESSION['docente'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come docente per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $docente = unserialize($_SESSION['docente']);
    $html .= creaBarraMenu($docente->getEmail());

    if(isset($_SESSION['percorsi'])){
        $percorsi = unserialize($_SESSION['percorsi']);
        $inCorso = array();
        $completati = array();

        foreach ($percorsi as $percorso) {
            if($percorso->getAl() >= date('Y-m-d')){
                $inCorso[] = $percorso;
            }else{
                $completati[] = $percorso;
            }
        }

        //Creazione dei riquadri dei percorsi
        $html .=<<<testo
                <details id="inCorso" open>
                    <summary>In corso..</summary>
                    <div class="contenitore-riquadri">\n
        testo;
        foreach ($inCorso as $percorso){
            $html .= creaRiquadro($percorso);
        }
        $html .=<<<testo
                    </div>
                </details>\n
        testo;

        //Creazione dei riquadri dei percorsi completati
        $html .=<<<testo
                <details id="completate" open>
                    <summary>Completati</summary>
                    <div class="contenitore-riquadri">\n
        testo;
        foreach ($completati as $percorso){
            $html .= creaRiquadro($percorso, true);
        }
        $html .=<<<testo
                    </div>
                </details>\n
        testo;
    }
}
$html .= creaFooter();
echo $html;

function creaRiquadro($percorso, $daValutare = false) {
    $classe = $percorso->getClasse();
    $scuola = $classe->getScuola();
    $riquadro =<<<testo
        \t\t\t<div class="riquadro-esperienza">
            \t\t\t<a href="#">{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}</a><br>
            \t\t\t<a href="#">{$scuola->getNome()}</a>
            \t\t\t<hr>
            \t\t\t<a href="#">{$percorso->getDal()} {$percorso->getAl()}</a><br>\n
    testo;
    $riquadro .= "\t\t\t\t</div>\n";
    return $riquadro;

}
?>