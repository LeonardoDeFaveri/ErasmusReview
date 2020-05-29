<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Classe");
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "", $_SESSION['tipo_utente'] ?? "");
if(!isset($_SESSION['email_utente'])){
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso per poter vedere questa pagina</h2>
        <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
    testo;
    $html .= creaFooter();
    echo $html;
    return;
}

if(isset($_GET['errore'])){
    switch($_GET['errore']){
        case 2:
            $html .=<<<testo
            <script>
                alert("C'è stato un errore durante l'assegnazione del docente alla classe, probabilmente è già stato assegnato");
            </script>
            testo;
        break;
        case '3a':
            $html .= "<h2>La classe selezionata non esiste</h2>\n";
            $html .= creaFooter();
            echo $html;
            return;
        break;
        case '3b':
            $html .= "<h2>Il docente selezionato non esiste</h2>\n";
            $html .= creaFooter();
            echo $html;
            return;
        break;
    }
}

$classe = unserialize($_SESSION['classe']);
$docenti = unserialize($_SESSION['possibili_docenti_classe']);
$html .=<<<testo
    <h2>Associazione docente-classe</h2>
    <div class="contenitore-centrato">
testo;

if(count($docenti) == 0){
    $html .=<<<testo
        <h3>Non c'è nessun docente disponibile</h3>
    testo;
}else{
    $html .=<<<testo
        <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=associa-docente-classe&id={$classe->getId()}" onSubmit="return controllaDate(this)">
            <fieldset class="form-con-colonne">
                <legend>Associazione docente-classe</legend>
                <div class="dati">
                    <div class="riga">
                        <label for="id_docente">Scegli un docente:</label>
                        <select name="id_docente" required>\n
    testo;

    foreach ($docenti as $docente) {
        $html .= "<option value='{$docente->getId()}'>{$docente->getCognome()} {$docente->getNome()}</option>";
    }

    $html .=<<<testo
                        </select>
                    </div>
                    <div class="riga">
                        <label for="dal">Dal:</label>
                        <input type="date" name="dal">
                    </div>
                    <div class="riga">
                        <label for="al">Al:</label>
                        <input type="date" name="al">
                    </div>
                </div>
                <input type="submit" name="submit">
            </fieldset>
        </form>
    testo;
}

$html .= "</div>\n";
$html .= creaFooter();
echo $html;
?>