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
if(isset($_GET['errore'])){
    $html .= creaBarraMenu("");
    if($_GET["errore"]==1 || !isset($_SESSION['email_utente'])){
        $html .=<<<testo
            <h2>Devi aver eseguito l'accesso come scuola per poter vedere questa pagina</h2>
            <a href="login.php">Accedi</a>
        testo;
    }else if($_GET["errore"]==2){
        $html.="<p>Errore nella modifica</p>\n";
    }    
}else{
    $scuola = unserialize($_SESSION['scuola']);
    $html .= creaBarraMenu($_SESSION["email_utente"]);
    $html.=<<<testo
        <form aciotn="../index.php?comando=invio-modifica-dati-scuola" method="POST">
            <fieldset>
                <legend>Modifica Scuola</legend>
                <label>Codice meccanografico</label>
                <input type="text" name="codiceMeccanografico" placeholder="{$scuola->getId()}" readonly><br>
                <label>Nome</label>
                <input type="text" name="nome" value="{$scuola->getNome()}" required><br>
                <label>Citt&agrave;</label>
                <input type="text" name="citta" value="{$scuola->getCitta()}" required><br>
                <label>Indirizzo</label>
                <input type="text" name="indirizzo" value="{$scuola->getIndirizzo()}" required><br>
                <input type="submit">
            </fieldset>
        </form>
        <form action="../index.php?comando=invio-modifica-credenziali-scuola" method="POST" onSubmit="return controlloCorrispondezaPassword(this)">
            <fieldset>
                <legend>Modifica Credenziali</legend>
                <label>Vecchia Email</label>
                <input type="email" name="vecchiaEmail" placeholder="{$scuola->getEmail()}" readonly><br>
                <label>Email</label>
                <input type="email" name="email" value="{$scuola->getEmail()}" required><br>
                <label>Nuova password</label>
                <input type="password" name="nuovaPassowrd"><br>
                <label>Conferma Nuova password</label>
                <input type="password" name="confermaNuovaPassowrd"><br>
                <input type="submit">
            </fieldset>
        </form>
    testo;

}

$html.=creaFooter();
echo $html;