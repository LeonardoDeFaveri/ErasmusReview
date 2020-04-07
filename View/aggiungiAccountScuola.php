<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}

include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Scuola.php";

$html = creaHeader("Aggiungi scuola");
if(isset($_GET['errore']) || !isset($_SESSION['email_utente'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come scuola per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $html .= creaBarraMenu($_SESSION["email_utente"]);
    $html.=<<<testo
        <div>
            <form action="../index.php?comando=invio-dati-nuova-scuola" method="POST">
                <fieldset>
                    <legend>Nuova Scuola</legend>
                    <label>Codice meccanografico</label>
                    <input type="text" name="codice_meccanografico" required><br>
                    <label>Email</label>
                    <input type="email" name="email" required><br>
                    <label>Nome</label>
                    <input type="text" name="nome" required><br>
                    <label>Citt&agrave;</label>
                    <input type="text" name="citta" required><br>
                    <label>Indirizzo</label>
                    <input type="text" name="indirizzo" required><br>
                    <input type="submit">
                </fieldset>
            </form>
        </div>
    testo;

}

$html .= creaFooter();
echo $html;
?>