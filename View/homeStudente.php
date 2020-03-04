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
        
        $html.="<p>in corso:</p>\n<br>\n";
        $primoRiquadro = true;

        foreach ($esperienze as $esperienza) {
            $agenzia = $esperienza->getAgenzia() != NULL ? $esperienza->getAgenzia()->getNome() : "";
            $famiglia = $esperienza->getFamiglia() != NULL ? $esperienza->getFamiglia()->getCognome() : "";
            if($esperienza->getAl() >= date('Y-m-d')){
                
                $html.=<<<testo
                <div class='riquadroEsperienza'>
                    <a href='?comando=azienda-{$esperienza->getAzienda()->getId()}'>{$esperienza->getAzienda()->getNome()}</a>
                    <p>dal:{$esperienza->getDal()} al {$esperienza->getAl()}</p>
                    <a href='?comando=famiglia-{$esperienza->getFamiglia()->getId()}'>{$famiglia} {$esperienza->getFamiglia()->getNome()}</a><br>
                    <a href='?comando=agenzia-{$esperienza->getAgenzia()->getId()}'>{$agenzia}</a><br>
                    <a href='?comando=esperienza-{$esperienza->getId()}'>visualizza esperienza</a><br>
                </div>\n
                testo;
            }else{
                if($primoRiquadro){ //se è la prima esperienza che viene stampata scrivo il paragrafo sennò non serve perchè è gia stato scritto 
                    $html.="<p>completate:</p>\n";
                    $primoRiquadro = false;
                }
                $html.=<<<testo
                <div class='riquadroEsperienza'>
                    <a href='?comando=azienda-{$esperienza->getAzienda()->getId()}'>{$esperienza->getAzienda()->getNome()}</a>
                    <p>dal: {$esperienza->getDal()} al: {$esperienza->getAl()}</p>
                    <a href='?comando=famiglia-{$esperienza->getFamiglia()->getId()}'>{$famiglia} {$esperienza->getFamiglia()->getNome()}</a><br>
                    <a href='?comando=agenzia-{$esperienza->getAgenzia()->getId()}'>{$agenzia}</a><br>
                    <a href='?comando=esperienza-{$esperienza->getId()}'>visualizza esperienza</a><br>
                </div>\n
                testo;
            }
        }
    }
}
$html .= creaFooter();
echo $html;
?>