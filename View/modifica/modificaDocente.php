<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";

$html = creaHeader("Modifica Docente");
if(isset($_GET['errore']) || !isset($_SESSION['email_utente'])){
    $html .= creaBarraMenu("","");
    if($_GET["errore"] == 1 || !isset($_SESSION['email_utente'])){
        $html .=<<<testo
            <h2>Devi aver eseguito l'accesso come scuola o docente per poter vedere questa pagina</h2>
            <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
        testo;
    }else if($_GET["errore"] == 2){
        $html .=<<<testo
            <script>
                alert("Qualcosa &egrave; andato storto nella modifica");
            </script>
        testo;
    }else if($_GET["errore"]==3){
        $html.=<<<testo
            <p>Errore, il docente che si desidera modificare non esiste</p>
        testo;
    }
}else{
    if(isset($_GET['successo'])){
        $html .=<<<testo
            <script>
                alert("Modifica effettuata con successo");
            </script>
        testo;
    }else{
        $docente=unserialize($_SESSION["docente"]);
        //public function __construct($id, $nome, $cognome, $email)
        $html .= creaBarraMenu($_SESSION["email_utente"],$_SESSION["tipo_utente"]);
        $html.=<<<testo
            <form action="{$_SESSION['web_root']}/index.php?comando=modifica-dati-docente" method="POST">
                <fieldset class="form-con-colonne">
                    <legend>Modifica Docente</legend>
                    <div class="dati">
                        <div class="riga">
                            <label>Nome</label>
                            <input type="text" name="nome" value="{$docente->getNome()}" required>
                        </div>
                        <div class="riga">
                            <label>Cognome</label>
                            <input type="text" name="cognome" value="{$docente->getCognome()}" required>
                        </div>
                    </div>
                    <input type="submit">
                </fieldset>
            </form>
            <form action="{$_SESSION['web_root']}/index.php?comando=modifica-credenziali-docente" method="POST" onSubmit="return controlloPassword()>
                <fieldset>
                    <legend>Modifica Credenziali</legend>
                    <div class="dati">
                        <div class="riga">
                            <label>Vecchia Email</label>
                            <input type="email" name="vecchiaEmail" value="{$docente->getEmail()}" readonly>
                        </div>
                        <div class="riga">
                            <label>Email</label>
                            <input type="email" name="email">
                        </div>
                        <div class="riga">
                            <label>Nuova password</label>
                            <input type="password" name="password" id="password">
                        </div>
                        <div class="riga">
                            <label>Conferma Nuova password</label>
                            <input type="password" name="confermaNuovaPassowrd" id="passwordConferma">
                        </div>
                    </div>
                    <input type="submit">
                </fieldset>
            </form>
        testo;

    }
}


$html.=creaFooter();
echo $html;