<?php
/**
 * homeStudente contiene una lista di tutte le esperienze svolte e attive per uno studente.
 */
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Esperienze");
if(isset($_GET['errore']) || !isset($_SESSION['studente'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come utente per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $studente = unserialize($_SESSION['studente']);
    $html .= creaBarraMenu($studente->getEmail());

    if(isset($_SESSION['esperienze'])){
        $esperienze = unserialize($_SESSION['esperienze']);
        $percorsi = unserialize($_SESSION['percorsi']);
        
        $html .=<<<testo
                <div id="inCorso" class="riquadroEsperienza">
                    <h3>In corso..</h3>
                    <i class='fas fa-angle-down'></i>
        testo;
        for ($i = 0; $i < count($percorsi); $i++){
            if($percorsi->getAl() >= date('Y-m-d')){
                
            }
        } 

        foreach ($esperienze as $esperienza) {
            $azienda = $esperienza->getAzienda();
            $agenzia = $esperienza->getAgenzia() != NULL ? $esperienza->getAgenzia() : "";
            $famiglia = $esperienza->getFamiglia() != NULL ? $esperienza->getFamiglia() : "";
            if($esperienza->getAl() >= date('Y-m-d')){
                $html.=<<<testo
                <div class='riquadroEsperienza'>
                    <a href='../index.php?comando=mostra-azienda&id={$azienda->getId()}'>{$azienda->getNome()}</a>
                    <p>Dal:{$esperienza->getDal()} Al {$esperienza->getAl()}</p>
                    <a href='../index.php?comando=mostra-famiglia&id={$famiglia->getId()}'>{$famiglia->getCognome()} {$famiglia->getNome()}</a><br>
                    <a href='../index.php?comando=mostra-agenzia&id={$agenzia->getId()}'>{$agenzia->getNome()}</a><br>
                    <a href='../index.php?comando=mostra-esperienza&id={$esperienza->getId()}'>visualizza esperienza</a><br>
                </div>\n
                testo;
            }else{
                if($primoRiquadro){ 
                    //se è la prima esperienza che viene stampata scrivo il paragrafo
                    //sennò non serve perchè è già stato scritto 
                    $html.="<p>Completate:</p>\n";
                    $primoRiquadro = false;
                }
                /*$html.=<<<testo
                <div class='riquadroEsperienza'>
                    <a href='../index.php?comando=mostra-azienda&id={$azienda->getId()}'>{$azienda->getNome()}</a>
                    <p>Dal:{$esperienza->getDal()} Al {$esperienza->getAl()}</p>
                    <a href='../index.php?comando=mostra-famiglia&id={$famiglia->getId()}'>{$famiglia->getCognome()} {$famiglia->getNome()}</a><br>
                    <a href='../index.php?comando=mostra-agenzia&id={$agenzia->getId()}'>{$agenzia->getNome()}</a><br>
                    <a href='../index.php?comando=mostra-esperienza&id={$esperienza->getId()}'>visualizza esperienza</a><br>
                </div>\n
                testo;*/
                $html .=<<<testo
                <div class="riquadroEsperienza">
                    <p></p>
                </div>
                testo;
            }
        }
    }
}
$html .= creaFooter();
echo $html;
?>