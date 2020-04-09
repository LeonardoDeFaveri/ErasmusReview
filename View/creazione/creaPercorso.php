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

$html = creaHeader("Creazione Percorso");
if(isset($_GET['errore']) || (!isset($_SESSION['docente']) && !isset($_SESSION['scuola']))){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come docente o scuola per poter visualizzare questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
}else{
    if(isset($_SESSION['docente'])){ // accesso effettuato come docente
        $docente = unserialize($_SESSION['docente']);
        $classiDocente = unserialize($_SESSION['classiDocente']);
        $html .= creaBarraMenu($docente->getEmail());

        $html.=<<<testo
            <div>
            <h2>Crea Percorso</h2>
                <fieldset id="form-creazione-classe">
                    <legend>Creazione Percorso</legend>
                    <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-percorso">
                        <div class="dati">
                            <div class="riga">
                                <label>Seleziona Classe:</label>
                                <select name ='idClasse' required>
        testo;
        foreach($classiDocente as $classe){
            $html.=<<<testo
                                <option value ='{$classe->getId()}'>{$classe->getNumero()} {$classe->getSezione()} {$classe->getAnnoScolastico()}</option>
                                </select>
                            </div>
            testo;
        }
        $html.=<<<testo
                            <div class="riga">
                                <label>Dal:</label>
                                <input type=date name="dal" reqiured><br>
                            </div>
                            <div class="riga">
                                <label>Al</label>
                                <input type=date name="al" required><br>
                            </div>
                        </div>
                        <input type="submit" value="Crea Percorso">
                    </form>
                </fieldset>
            </div>
        testo;
    }else{ // accesso effettuato come scuola
        $scuola = unserialize($_SESSION['scuola']);
        $classiScuola = unserialize($_SESSION['classiScuola']);
        $html .= creaBarraMenu($scuola->getEmail());
    }
    $html .= creaFooter();
    echo $html;
}
?>