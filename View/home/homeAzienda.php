<?php
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

$html = creaHeader("Home Azienda");
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "", $_SESSION['tipo_utente'] ?? "");
if(isset($_GET['errore']) || !isset($_SESSION['azienda'])){
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come azienda per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}else{
    $azienda = unserialize($_SESSION['azienda']);
    
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
                <details id="completate">
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
    $studente=$esperienza->getStudente();
    $periodo = $esperienza->getPercorso();
    $tutor = $esperienza->getPercorso()->getDocente();
    $scuola = $esperienza->getPercorso()->getClasse()->getScuola();
    $azienda = $esperienza->getAzienda();
    $riquadro =<<<testo
        \t\t\t<div class="riquadro">
            \t\t\t<strong><a href="{$_SESSION['web_root']}/index.php?comando=mostra-studente&id={$studente->getId()}">{$studente->getCognome()} {$studente->getNome()}</a></strong><br>
            \t\t\t{$studente->getEmail()}<br>
            \t\t\t<hr>
            \t\t\t<strong>Dal: </strong>{$esperienza->getDal()} <strong>Al: </strong>{$esperienza->getAl()}<br>
            \t\t\t<strong>Scuola: </strong><a href="{$_SESSION['web_root']}/index.php?comando=mostra-scuola&codice_meccanografico={$scuola->getId()}">{$scuola->getNome()}</a><br>
            \t\t\t<strong>Docente: </strong><a href="{$_SESSION['web_root']}/index.php?comando=mostra-docente&id={$tutor->getId()}">{$tutor->getCognome()} {$tutor->getNome()}</a><br>\n
            \t\t\t<div class="contenitore-bottoni-riquadro">\n
    testo;

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


