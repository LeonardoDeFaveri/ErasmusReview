<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}

include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";

$html = creaHeader("Aggiungi scuola");
if(isset($_GET['errore']) || !isset($_SESSION['email_utente'])){
    if($_GET['errore'] == 1 || !isset($_SESSION['email_utente'])){
        $html .= creaBarraMenu("");
        $html .=<<<testo
            <h2>Devi aver eseguito l'accesso come scuola per poter vedere questa pagina</h2>
            <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
        testo;
    }else{
        $html .= creaBarraMenu($_SESSION["email_utente"]);
        $html .=<<<testo
        <script>
            alert("Errore nell'inserimento della scuola; controlla i dati e riprova");
        </script>
        testo;
    }
}else{
    if(!$creataBarraMenu){
        $html .= creaBarraMenu($_SESSION["email_utente"]);
    }
    $html.=<<<testo
        <div>
            <form action="{$_SESSION['web_root']}/index.php?comando=crea-scuola" method="POST">
                <fieldset class="form-con-colonne">
                    <legend>Crea Scuola</legend>
                        <div class="dati">
                            <div class="riga">
                                <label>Codice meccanografico</label>
                                <input type="text" name="codice_meccanografico" autofocus required>
                            </div>
                            <div class="riga">
                                <label>Email</label>
                                <input type="email" name="email" required><br>
                            </div>
                            <div class="riga">
                                <label>Nome</label>
                                <input type="text" name="nome" required><br>
                            </div>
                            <div class="riga">
                                <label>Citt&agrave;</label>
                                <input type="text" name="citta" required><br>
                            </div>
                            <div class="riga">
                                <label>Indirizzo</label>
                                <input type="text" name="indirizzo" required><br>
                            </div>
                        </div>
                    <input name="submit" type="submit">
                </fieldset>
            </form>
        </div>
    testo;
}

$html .= creaFooter();
echo $html;
?>