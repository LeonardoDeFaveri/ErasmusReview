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

$html = creaHeader("Modifica Scuola");
if(isset($_GET['errore']) || !isset($_SESSION['email_utente'])){
    $html .= creaBarraMenu("");
    if($_GET["errore"] == 1 || !isset($_SESSION['email_utente'])){
        $html .=<<<testo
            <h2>Devi aver eseguito l'accesso come scuola per poter vedere questa pagina</h2>
            <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
        testo;
    }else if($_GET["errore"] == 2){
        $html .=<<<testo
            <script>
                alert("Qualcosa &egrave; andato storto nella modifica");
            </script>
        testo;
    }    
}else{
    $scuola = unserialize($_SESSION['scuola']);
    $html .= creaBarraMenu($_SESSION["email_utente"]);
    $html.=<<<testo
        <form aciotn="{$_SESSION['web_root']}/index.php?comando=invio-modifica-dati-scuola" method="POST">
            <fieldset class="form-con-colonne">
                <legend>Modifica Scuola</legend>
                <div class="dati">
                    <div class="riga">
                        <label>Codice meccanografico</label>
                        <input type="text" name="codiceMeccanografico" placeholder="{$scuola->getId()}" readonly>
                    </div>
                    <div class="riga">
                        <label>Nome</label>
                        <input type="text" name="nome" value="{$scuola->getNome()}" required>
                    </div>
                    <div class="riga">
                        <label>Citt&agrave;</label>
                        <input type="text" name="citta" value="{$scuola->getCitta()}" required>
                    </div>
                    <div class="riga">
                        <label>Indirizzo</label>
                        <input type="text" name="indirizzo" value="{$scuola->getIndirizzo()}" required>
                    </div>
                </div>
                <input type="submit">
            </fieldset>
        </form>
        <form action="{$_SESSION['web_root']}/index.php?comando=invio-modifica-credenziali-scuola" method="POST" onSubmit="return controlloCorrispondezaPassword(this)">
            <fieldset>
                <legend>Modifica Credenziali</legend>
                <div class="dati">
                    <div class="riga">
                        <label>Vecchia Email</label>
                        <input type="email" name="vecchiaEmail" placeholder="{$scuola->getEmail()}" readonly>
                    </div>
                    <div class="riga">
                        <label>Email</label>
                        <input type="email" name="email" value="{$scuola->getEmail()}" required>
                    </div>
                    <div class="riga">
                        <label>Nuova password</label>
                        <input type="password" name="nuovaPassowrd">
                    </div>
                    <div class="riga">
                        <label>Conferma Nuova password</label>
                        <input type="password" name="confermaNuovaPassowrd">
                    </div>
                </div>
                <input type="submit">
            </fieldset>
        </form>
    testo;
}

$html.=creaFooter();
echo $html;