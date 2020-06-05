<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";

$html = creaHeader("Modifica Percorso");
if(isset($_GET['errore']) || !isset($_SESSION['email_utente'])){
    $html .= creaBarraMenu("","");
    if($_GET["errore"] == 1 || !isset($_SESSION['email_utente'])){
        $html .=<<<testo
            <h2>Devi aver eseguito l'accesso come scuola o docente per poter vedere questa pagina</h2>
            <a href="{$_SESSION['web_root']}/View/login.php">Accedi</a>
        testo;
    }else if($_GET["errore"] == 2){
        $html .=<<<testo
            <script>
                alert("Qualcosa &egrave; andato storto nella modifica");
            </script>
        testo;
    }
}else{
    if(isset($_GET['successo'])){
        $html .=<<<testo
            <script>
                alert("Modifica effettuata con successo");
            </script>
        testo;
    }
    $percorso = unserialize($_SESSION['percorso']);
    $classi = unserialize($_SESSION['classi']);
    $html .= creaBarraMenu($_SESSION["email_utente"], $_SESSION["tipo_utente"]);
    $html.=<<<testo
        <form action="{$_SESSION['web_root']}/index.php?comando=modifica-percorso&id={$percorso->getId()}" method="POST">
            <fieldset class="form-con-colonne">
                <legend>Modifica Percorso</legend>
                <div class="dati">
                    <div class="riga">
                        <label for="id_classe">Seleziona Classe:</label>
                        <select name ='id_classe' required>\n
    testo;
    foreach($classi as $classe){
        if(($classe->getNumero() == $percorso->getClasse()->getNumero()) && ($classe->getSezione() == $percorso->getClasse()->getSezione()) && ($classe->getAnnoScolastico() == $percorso->getClasse()->getAnnoScolastico())){
            $html.=<<<testo
                        \t\t<option value ='{$classe->getId()}' selected>{$classe->getNumero()} {$classe->getSezione()} {$classe->getAnnoScolastico()}</option>\n
            testo;
        }else{
            $html.=<<<testo
                            \t\t<option value ='{$classe->getId()}'>{$classe->getNumero()} {$classe->getSezione()} {$classe->getAnnoScolastico()}</option>\n
            testo;
        }
    }
    $html.=<<<testo
                    </select>
                    </div>
                    <div class="riga">
                        <label>Dal: </label>
                        <input type=date name="dal" value='{$percorso->getDal()}' required><br>
                    </div>
                    <div class="riga">
                        <label>Al: </label>
                        <input type=date name="al" value='{$percorso->getAl()}' required><br>
                    </div>
    testo;
    if($_SESSION['tipo_utente'] == 'scuola'){
        $docenti = unserialize($_SESSION['docenti']);
        $html .=<<<testo
                    <div class="riga">
                        <label for="id_docente">Seleziona Docente:</label>
                        <select name="id_docente" autofocus required>\n
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
    $html.=<<<testo
                </div>
                <input type="submit" name="submit">
            </fieldset>
        </form>
    testo;
}
$html.=creaFooter();
echo $html;
?>