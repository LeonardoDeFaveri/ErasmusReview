<?php
/**
 * creaPercorso permette di creare un percorso.
 */
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusAdvisor";
}

include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";
include_once "{$_SESSION['root']}/Model/Classe.php";

$html = creaHeader("Creazione Esperienza");
if(isset($_GET['errore']) || (!isset($_SESSION['docente']) && !isset($_SESSION['scuola']))){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come docente o scuola per poter visualizzare questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}else{
    $html .= creaBarraMenu($_SESSION['email_utente']);
    $studenti = unserialize($_SESSION['studenti']);
    $html .=<<<testo
        <div>
            <h2>Crea Esperienza</h2>
                <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-esperienza">
                    <fieldset>
                        <legend>Creazione Esperienza</legend>
                            <div class="dati">\n
                            <div class="riga">
                                <label for="id_studente">Seleziona Studente:</label>
                                <select name="id_studente" autofocus required>\n
    testo;
    foreach($studenti as $studente){
        $html.=<<<testo
                                \t<option value ='{$studente->getId()}'>{$studente->getNome()} {$studente->getCognome()}</option>\n
        testo;
    }
    $html.=<<<testo
                                </select>
                            </div>\n
        testo;
    $html .=<<<testo
                            <div class="riga">
                                <label for="id_azienda">Seleziona Azienda:</label>
                                <select name ='id_azienda' required>\n
    testo;
    foreach($aziende as $azienda){
        $html.=<<<testo
                                \t\t<option value ='{$azienda->getId()}'>{$azienda->getNome()}</option>\n
        testo;
    }
    $html.=<<<testo
                                </select>
                            </div>\n
        testo;
    $html .=<<<testo
                            <div class="riga">
                                <label for="id_agenzia">Seleziona Agenzia:</label>
                                <select name ='id_agenzia' required>\n
    testo;
    foreach($agenzie as $agenzia){
        $html.=<<<testo
                                \t\t<option value ='{$azienda->getId()}'>{$azienda->getNome()}</option>\n
        testo;
    }
    $html.=<<<testo
                                </select>
                            </div>\n
        testo;
}

$html .= creaFooter();
echo $html;
?>