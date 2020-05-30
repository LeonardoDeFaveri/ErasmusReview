<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Modifica Esperienza");
if(isset($_GET['errore']) || !isset($_SESSION['email_utente'])){
    $html .= creaBarraMenu("","");
    if($_GET["errore"] == 1 || !isset($_SESSION['email_utente'])){
        $html .=<<<testo
            <h2>Devi aver eseguito l'accesso come scuola o docente per poter vedere questa pagina</h2>
            <a href="{$_SESSION['web_root']}/View/login.php">Accedi</a>
        testo;
    }else if($_GET["errore"] == 2){
        $html .=<<<testo
            <script>
                alert("Qualcosa &egrave; andato storto nella modifica");
            </script>
        testo;
    }
}else{
    if(isset($_GET['successo'])){
        $html .=<<<testo
            <script>
                alert("Modifica effettuata con successo");
            </script>
        testo;
    }
    $aziende = unserialize($_SESSION['aziende']);
    $agenzie = unserialize($_SESSION['agenzie']);
    $famiglie = unserialize($_SESSION['famiglie']);
    $dal = unserialize($_SESSION['dal']);
    $al = unserialize($_SESSION['al']);
    
    $html .=<<<testo
        <div>
            <h2>Crea Esperienza</h2>
                <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-esperienza" onSubmit="return controllaEsperienza()">
                    <fieldset class="form-con-colonne">
                        <legend>Creazione Esperienza</legend>
                        <div class="dati">
    testo;
    $html .=<<<testo
                        <div class="riga">
                            <label for="id_azienda">Seleziona Azienda:</label>
                            <select name='id_azienda' required>\n
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
                            <select id="id_agenzia" name="id_agenzia">
                            \t<option value ="null" selected></option>\n
    testo;
    foreach($agenzie as $agenzia){
        $html.=<<<testo
                                \t<option value ='{$agenzia->getId()}'>{$agenzia->getNome()}</option>\n
        testo;
    }
    $html.=<<<testo
                                </select>
                            </div>\n
        testo;
    $html .=<<<testo
                        <div class="riga">
                            <label for="id_famiglia">Seleziona Famiglia:</label>
                            <select id="id_famiglia" name="id_famiglia">
                                <option value="null" selected></option>\n 
    testo;
    foreach($famiglie as $famiglia){
    $html.=<<<testo
                                <option value ='{$famiglia->getId()}'>{$famiglia->getNome()} {$famiglia->getCognome()}, {$famiglia->getStato()}</option>\n
    testo;
    }
    $html.=<<<testo
                            </select>
                        </div>
                        <div class="riga">
                            <label for="dataDal">Dal:</label>
                            <input type="date" id="dataDal" name="dataDal">
                        </div>
                        <div class="riga">
                            <label for="dataAl">Al:</label>
                            <input type="date" id="dataAl" name="dataAl">
                        </div>
                        <span class="suggerimento">Se non specificate, le date di inizio e fine dell'esperienza
                        corrisponderanno con quelle del percorso</span>
                    </div>
                    <input type="submit" name="submit">
                    </fieldset>
                </form>
        </div>\n
    testo;
}
$html.=creaFooter();
echo $html;
?>

