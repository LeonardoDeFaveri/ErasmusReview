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
    $html .= creaBarraMenu($_SESSION['email_utente']);
    $classi = unserialize($_SESSION['classi']);

    $html .=<<<testo
        <div>
            <h2>Crea Percorso</h2>
                <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-percorso">
                    <fieldset>
                        <legend>Creazione Percorso</legend>
                            <div class="dati">\n
    testo;
    if($_SESSION['tipo_utente'] == 'scuola'){
        $docenti = unserialize($_SESSION['docenti']);
        $html .=<<<testo
                            <div class="riga">
                                <label for="id_docente">Seleziona Docente:</label>
                                <select name="id_docente" required>\n
        testo;
        foreach($docenti as $docente){
            $html.=<<<testo
                                    \t<option value ='{$docente->getId()}'>{$docente->getNome()} {$docente->getCognome()}</option>\n
            testo;
        }
        $html.=<<<testo
                                </select>
                            </div>\n
        testo;
    }
    $html .=<<<testo
                            <div class="riga">
                                <label for="id_classe">Seleziona Classe:</label>
                                <select name ='id_classe' required>\n
    testo;
    foreach($classi as $classe){
        $html.=<<<testo
                                \t\t<option value ='{$classe->getId()}'>{$classe->getNumero()} {$classe->getSezione()} {$classe->getAnnoScolastico()}</option>\n
        testo;
    }
    $html .=<<<testo
            </select>
                            </div>
                            <div class="riga">
                                <label>Dal:</label>
                                <input type=date name="dal" required><br>
                            </div>
                            <div class="riga">
                                <label>Al:</label>
                                <input type=date name="al" required><br>
                            </div>
                        </div>
                        <input type="submit" name="submit">
                    </fieldset>
                </form>
            </div>\n
    testo;

    $html .= creaFooter();
    echo $html;
}
?>