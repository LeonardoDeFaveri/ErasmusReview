<?php
    if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Esperienze");
if(isset($_GET['errore']) || !isset($_SESSION['agenzia'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come agenzia per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $agenzia = unserialize($_SESSION['agenzia']);
    $html .= creaBarraMenu($agenzia->getEmail());

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
            $html .= creaRiquadro($esperienza);
        }
        $html .=<<<testo
                    </div>
                </details>\n
        testo;

        //Creazione dei riquadri delle esperiene completate
        $html .=<<<testo
                <details id="completate" open>
                    <summary>Completate</summary>
                    <div class="contenitore-riquadri">\n
        testo;
        foreach ($completate as $esperienza){
            $html .= creaRiquadro($esperienza, true);
        }
        $html .=<<<testo
                    </div>
                </details>\n
        testo;
    }
}
$html .= creaFooter();
echo $html;

function creaRiquadro($esperienza, $daValutare = false) {
    $classe = $esperienza->getPercorso()->getClasse();
    $scuola = $classe->getScuola();
    $azienda = $esperienza->getAzienda();
    $agenzia = $esperienza->getAgenzia();
    $famiglia = $esperienza->getFamiglia();
    $riquadro =<<<testo
        \t\t\t<div class="riquadroEsperienza">
            \t\t\t<a href="#">{$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}</a><br>
            \t\t\t<a href="#">{$scuola->getNome()}</a>
            \t\t\t<hr>
            \t\t\t<a href="#">{$esperienza->getDal()} {$esperienza->getAl()}</a><br>
            \t\t\t<a href="#">{$azienda->getNome()}</a><br>\n
    testo;
    if($famiglia != null){
        $riquadro .= "\t\t\t\t\t<a href='#'>Famiglia {$famiglia->getCognome()}</a>\n";
    }

    if($daValutare){
        $riquadro .=<<<testo
            \t\t\t\t<form action="../index.php?comando=valutazione-esperienza&id={$esperienza->getId()}" method="POST">
                \t\t\t\t<button type="submit">Valutazione</button>
            \t\t\t\t</form>\n
        testo;
    }

    $riquadro .= "\t\t\t\t</div>\n";
    return $riquadro;
}
?>

