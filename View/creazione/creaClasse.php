<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusAdvisor";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Crea Classe");
if(isset($_GET['errore']) || !isset($_SESSION['scuola'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come scuola per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/View/login.php">Accedi</a>
    testo;
}else{
    $scuola = unserialize($_SESSION['scuola']);
    $html .= creaBarraMenu($scuola->getEmail());
    $as = date("Y") - 1;
    $as = $as . "/" . date("Y");
    $html.=<<<testo
            <div>
            <h2>Crea classe</h2>
                <fieldset class="form-con-colonne">
                    <legend>Creazione classe</legend>
                    <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-classe">
                        <div class="dati">
                            <div class="riga">
                                <label>Numero sezione</label>
                                <input type="number" name="numero_classe" min="1" required><br>
                            </div>
                            <div class="riga">
                                <label>Sezione</label>
                                <input type=text name="sezione_classe" required><br>
                            </div>
                            <div class="riga">
                                <label>Inizio anno scolastico</label>
                                <input type="date" name="as_inizio" required>
                            </div>
                            <div class="riga">
                                <label>Fine anno scolastico</label>
                                <input type="date" name="as_fine" required>
                            </div>
                        </div>
                        <hr>
                        <p>Assegna gli studenti alla classe</p>
                        <div class="lista-checkbox">  
    testo;
    $studenti = unserialize($_SESSION['studenti']);
    foreach($studenti as $studente){
        $email = $studente->getEmail();
        $html .=<<<testo
            <label>
                <input type="checkbox" name="studenti[]" value="{$email}">
                {$studente->getCognome()} {$studente->getNome()}
            </label>
        testo;
    }
    $html .=<<<testo
                        </div>
                        <input type="submit" value="Crea classe">
                    </form>
                </fieldset>
            </div>\n
    testo;
}
$html .= creaFooter();
echo $html;
?>