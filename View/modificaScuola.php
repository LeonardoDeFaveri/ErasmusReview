<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Modifica Scuola");
if(isset($_GET['errore']) || !isset($_SESSION['scuola'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come scuola per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $scuola = unserialize($_SESSION['scuola']);
    $html .= creaBarraMenu($scuola->getEmail());
    $html.=<<<testo
        <form aciotn="invio-dati-modifica-scuola" method="POST" onclick="return controlloCorrispondezaPassword(this)">
            <fieldset>
                <legend>Modifica Scuola</legend>
                <label>Codice meccanografico</label>
                <input type="text" name="codice_meccanografico" value="{$scuola->getId()}" required><br>
                <label>Email</label>
                <input type="email" name="email" value="{$scuola->getEmail()}" required><br>
                <label>Nome</label>
                <input type="text" name="nome" value="{$scuola->getNome()}" required><br>
                <label>Citt&agrave;</label>
                <input type="text" name="citta" value="{$scuola->getCitta()}" required><br>
                <label>Indirizzo</label>
                <input type="text" name="indirizzo" value="{$scuola->getIndirizzo()}" required><br>
                <label>Nuova password</label>
                <input type="passsword" name="nuovaPassowrd"><br>
                <label>Conferma Nuova password</label>
                <input type="passsword" name="confermaNuovaPassowrd"><br>
                <input type="submit">
            </fieldset>
        </form>
    testo;

}
echo $html;