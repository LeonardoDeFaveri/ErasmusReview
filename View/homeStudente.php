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

    if(isset($_SESSION['esperienze']) && isset($_SESSION['percorsi'])){
        $esperienze = unserialize($_SESSION['esperienze']);
        $percorsi = unserialize($_SESSION['percorsi']);

        $html .=<<<testo
                <div id="inCorso" class="riquadroEsperienza">
                    <details open>
                        <summary>
                            <h3>In corso..</h3>
                        </summary>
        testo;

        $primoRiquadro = true;
        foreach ($esperienze as $esperienza) {
            $azienda = $esperienza->getAzienda();
            $agenzia = $esperienza->getAgenzia() != NULL ? $esperienza->getAgenzia() : "";
            $famiglia = $esperienza->getFamiglia() != NULL ? $esperienza->getFamiglia() : "";
            if($esperienza->getAl() >= date('Y-m-d')){
                $html.=<<<testo
                <div class='riquadroEsperienza'>
                    <label>Azienda: </label><a href='../index.php?comando=mostra-azienda&id={$azienda->getId()}'>{$azienda->getNome()}</a>
                    <p>Dal: {$esperienza->getDal()} Al: {$esperienza->getAl()}</p>
                testo;
                    if($famiglia != ""){
                        $html.= <<<testo
                        <label>Responsabile Famiglia: </label><a href='../index.php?comando=mostra-famiglia&id={$famiglia->getId()}'>{$famiglia->getCognome()} {$famiglia->getNome()}</a><br>
                        testo;
                    }
                    if($agenzia !=""){
                        $html.=<<<testo
                        <label>Agenzia: </label><a href='../index.php?comando=mostra-agenzia&id={$agenzia->getId()}'>{$agenzia->getNome()}</a><br>
                        testo;
                    }
                    $html.=<<<testo
                        <a href='../index.php?comando=mostra-esperienza&id={$esperienza->getId()}'>Visualizza esperienza</a><br>
                        </div><br>\n
                    testo;
            }else{
                if($primoRiquadro){ 
                    //se è la prima esperienza che viene stampata scrivo il paragrafo
                    //sennò non serve perchè è già stato scritto 
                    $html.=<<<testo
                        </details>
                        <details>
                            <summary>
                                <h3>Completate:</h3>
                            </summary>\n
                    testo;
                    $primoRiquadro = false;
                }
                $html.=<<<testo
                    <div class='riquadroEsperienza'>
                        <label>Azienda: </label><a href='../index.php?comando=mostra-azienda&id={$azienda->getId()}'>{$azienda->getNome()}</a>
                        <p>Dal: {$esperienza->getDal()} Al: {$esperienza->getAl()}</p>
                testo;
                    if($famiglia != ""){
                        $html.= <<<testo
                        <label>Responsabile Famiglia: </label><a href='../index.php?comando=mostra-famiglia&id={$famiglia->getId()}'>{$famiglia->getCognome()} {$famiglia->getNome()}</a><br>
                        testo;
                    }
                    if($agenzia != ""){
                        $html.=<<<testo
                        <label>Agenzia: </label><a href='../index.php?comando=mostra-agenzia&id={$agenzia->getId()}'>{$agenzia->getNome()}</a><br>
                        testo;
                    }
                    $html.=<<<testo
                        <a href='../index.php?comando=mostra-esperienza&id={$esperienza->getId()}'>Visualizza esperienza</a><br>
                        </div><br>\n
                    testo;
                $html.="</details>";
            }
        }
    }
}
$html .= creaFooter();
echo $html;
?>