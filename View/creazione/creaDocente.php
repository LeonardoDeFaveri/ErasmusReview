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

$html = creaHeader("Crea Docente");
if(isset($_GET['errore']) && $_GET['errore'] == 1 || !isset($_SESSION['scuola'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come scuola per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/View/login.php">Accedi</a>
    testo;
}else{
    $scuola = unserialize($_SESSION['scuola']);
    $html .= creaBarraMenu($scuola->getEmail());
    if(isset($_GET['errore']) && $_GET['errore'] == 2){
        switch($_GET['errore']){
            case 2:
                $html .=<<<testo
                    <script>
                        alert("Non sono riuscito ad inserire la classe; probabilmente esiste già");
                    </script>
                testo;
            break;
        }
    }
    $html.=<<<testo
        <div>
            <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-docente">
                <fieldset class="form-con-colonne">
                    <legend>Creazione docente</legend>
                    <div class="dati">
                        <div class="riga">
                            <label>Email</label>
                            <input type="email" name="email_docente" required>
                        </div>
                        <div class="riga">
                            <label>Nome</label>
                            <input type="text" name="nome_docente" required>
                        </div>
                        <div class="riga">
                            <label>Cognome</label>
                            <input type="text" name="cognome_docente" required>
                        </div>
                        <div class="riga">
                            <label>Dal</label>
                            <input type="text" name="dal_docente" required>
                        </div>
                        <div class="riga">
                            <label>Al</label>
                            <input type="text" name="al_docente" required>
                        </div>
                    </div>
                        <input type="submit" name="submit" value="Crea docente">
                </fieldset>
            </form>
        </div>\n
    testo;
}
    $html .= creaFooter();
    echo $html;
?>