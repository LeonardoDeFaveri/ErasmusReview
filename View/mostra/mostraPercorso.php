<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/Percorso.php";

$html = creaHeader("Percorso");
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

if(isset($_GET['errore']) ){
    switch($_GET['errore']){
        case 3:
            $html .= "<h2>Il percorso selezionato non esiste</h2>";
        break;
    }
    $html .= creaFooter();
    echo $html;
    return;
}

$percorso = unserialize($_SESSION['persorso']);
$html .=<<<testo
    <div class="contenitore-centrato">
        <div>
            <div class="riquadro">
                <strong>Dati del Percorso</strong><br>
                <hr>
                <strong>Docente: </strong>{$percorso->getDocente()}<br>
                <strong>Classe: </strong>{$percorso->getClasse()}<br> 
                <strong>Dal: </strong>{$percorso->getDal()}<br>
                <strong>Al: </strong>{$percorso->getAl()}<br>
                </div>
                <hr>
                <table>
                    <thead>
                        <tr>
                            <th>Aspetto</th>
                            <th>Voto medio</th>
                        </tr>
                    </thead>
                    <tbody>
    testo;
    foreach($aspetti as $aspetto){
        $html.=<<<testo
            <tr>
                <td>{$aspetto->getAspetto()->getNome()}</td>
                <td>{$aspetto->getVoto()}</td>
            </tr>
        testo;
    }
    $html .=<<<testo
                </tbody>
            </table>
        </div>
    </div>
    testo;
$html .= creaFooter();
echo $html;

?>

