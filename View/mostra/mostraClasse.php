<?php 
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/Model/Classe.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/Model/Utili/ContenitoreSoggettoDate.php";
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
        case 3:
            $html .= "<h2>La classe selezionata non esiste</h2>";
        break;
    }
    $html .= creaFooter();
    echo $html;
    return;
}

$classe = unserialize($_SESSION['classe']);
$docenti = unserialize($_SESSION['docenti_classe']);

$html.=<<<testo
    <h2>Classe {$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoscolastico()}</h2>
    <h3>Studenti</h3>
    <div class="contenitore-centrato">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Email</th>
                    <th>Data di nascita</th>
                    <th>Dal</th>
                    <th>Al</th>
                </tr>
            </thead>
            <tbody>
testo;

$studenti = unserialize($_SESSION['studenti']);

foreach($studenti as $elemento){
    $studente = $elemento->getSoggetto();
    $html .=<<<testo
        <tr>
            <td>{$studente->getNome()}</td>
            <td>{$studente->getCognome()}</td>
            <td><a href="{$_SESSION['web_root']}/index.php?comando=mostra-studente&id={$studente->getId()}">{$studente->getEmail()}</a></td>
            <td>{$studente->getDataNascita()}</td>
            <td>{$elemento->getDal()}</td>
            <td>{$elemento->getAl()}</td>
        </tr>
    testo;
}
$html .=<<<testo
            </tbody>
        </table>
    </div>
testo;

if(count($docenti) == 0){
    $html .=<<<testo
    <h3>Docenti</h3>
    <h4>Non è ancora stato associato nessun docente a questa classe</h4>\n
    testo;
}else{
    $html .=<<<testo
        <h3>Docenti</h3>
        <div class="contenitore-centrato">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                        <th>Dal</th>
                        <th>Al</th>
                    </tr>
                </thead>
                <tbody>
    testo;

    foreach($docenti as $elemento){
        $docente = $elemento->getSoggetto();
        $html.=<<<testo
            <tr>
                <td>{$docente->getNome()}</td>
                <td>{$docente->getCognome()}</td>
                <td><a href="{$_SESSION['web_root']}/index.php?comando=mostra-docente&id={$docente->getId()}">{$docente->getEmail()}</a></td>
                <td>{$elemento->getDal()}</td>    
                <td>{$elemento->getAl()}</td>
            </tr>
        testo;
    }

    $html.=<<<testo
                </tbody>
            </table>
        </div>
    testo;
}
if($_SESSION['tipo_utente'] == 'scuola') {
    $html .= "<h4><a href='{$_SESSION['web_root']}/index.php?comando=associa-docente-classe&id={$classe->getId()}'>Associa un docente</a></h4>\n";
}

$html .= creaFooter();
echo $html;