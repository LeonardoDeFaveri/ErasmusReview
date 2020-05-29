<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Crea Classe");
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "", $_SESSION['tipo_utente'] ?? "");
if(isset($_GET['errore']) && $_GET['errore'] == 1 || !isset($_SESSION['scuola'])){
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come scuola per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/View/login.php">Accedi</a>
    testo;
}else{
    $scuola = unserialize($_SESSION['scuola']);
    if(isset($_GET['errore']) && $_GET['errore'] == 2){
        switch($_GET['errore']){
            case 2:
                $html .=<<<testo
                    <script>
                        alert("Non sono riuscito ad inserire la classe; probabilmente esiste già");
                    </script>
                testo;
            break;
            case 3:
                $html .=<<<testo
                    <script>
                        alert("Non sono riucito ad inserire tutti gli studenti");
                    </script>
                testo;
            break;
        }
    }
    $as = date("Y") - 1;
    $as = $as . "/" . date("Y");
    $html.=<<<testo
            <div>
            <h2>Crea classe</h2>
                <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=crea-classe" id="form-crea-classe" onSubmit="getDati(this)">
                    <fieldset class="form-con-colonne">
                        <legend>Creazione classe</legend>
                        <div class="dati">
                            <div class="riga">
                                <label>Numero sezione</label>
                                <input type="number" name="numero_classe" min="1" autofocus required><br>
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
                            <div class="riga">
                                <label></label>
                                <input type="text" name="id_studenti" id="id_studenti" style="display:none;">
                            </div>
                        </div>
                        <hr>
                        <p>Assegna gli studenti alla classe</p>\n
    testo;
    $studenti = unserialize($_SESSION['studenti']);
    $html .=<<<testo
                        <div class="contenitore-tabella">
                            <table id="tabella-studenti">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Id</th>
                                        <th>Cognome</th>
                                        <th>Nome</th>
                                    </tr>
                                </thead>
                                <tbody>\n
    testo;

    foreach ($studenti as $studente) {
        $html .=<<<testo
        <tr>
            <td></td>
            <td>{$studente->getId()}</td>
            <td>{$studente->getCognome()}</td>
            <td>{$studente->getNome()}</td>
        </tr>\n
        testo;
    }

    $html .=<<<testo
                            
                                </tbody>
                            </table>
                        </div>
                        <input type="submit" name="submit" value="Crea classe">
                    </fieldset>
                </form>
            </div>\n
    testo;
}
$html .= creaFooter();
echo $html;
?>