<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
include_once "{$_SESSION['root']}/Model/SchedaDiValutazione.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Valutazioni");
$html .= creaBarraMenu($_SESSION['email_utente'] ?? "");
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
        case 1:
            $html .=<<<testo
                <h2>Il tuo tipo di account non è autorizzato ad accedere a questa pagina</h2>
                <a href="{$_SESSION['web_root']}/login.php">Accedi</a>
            testo;
        break;
        case 3:
            $html .= "<h2>La scheda di valutazione specificata non esiste</h2>";
        break;
    }
    $html .= creaFooter();
    echo $html;
    return;
}

$esperienza = unserialize($_SESSION['esperienza']);
$schedeDiValutazione = unserialize($_SESSION['schede_di_valutazione']);

$html .=<<<testo
    <main class="pagina-con-barra-laterale">
        <div class="contenuto">
            <h2>Tutti le valutazioni</h2>\n
testo;
switch($_SESSION['tipo_utente']){
    case 'studente':
        $html .= creaScheda($schedeDiValutazione['studente_azienda'], 'studente', 'azienda', true);
        $html .= creaScheda($schedeDiValutazione['azienda_studente'], 'azienda', 'studente');
        if($esperienza->getAgenzia() != null){
            $html .= creaScheda($schedeDiValutazione['studente_agenzia'], 'studente', 'azienda', true);
            $html .= creaScheda($schedeDiValutazione['studente_famiglia'], 'studente', 'famiglia', true);   
        }
    break;
    case 'azienda':
        $html .= creaScheda($schedeDiValutazione['azienda_studente'], 'azienda', 'studente', true);
        $html .= creaScheda($schedeDiValutazione['studente_azienda'], 'studente', 'azienda');
    break;
    case 'agenzia':
        $html .= creaScheda($schedeDiValutazione['studente_agenzia'], 'studente', 'agenzia');
        $html .= creaScheda($schedeDiValutazione['studente_famiglia'], 'studente', 'famiglia');
    break;
}
$html .= "\t\t</div>\n" . creaBarraLaterale($esperienza);
$html .=<<<testo
    </main>\n
testo;

$html .= creaFooter();
echo $html;

function creaScheda($scheda, $recensore, $recensito, $valutabile = false) {
    if($scheda == null){
        $html =<<<testo
            <div class="scheda-di-valutazione">
                <h3>Scheda di valutazione {$recensore}-{$recensito}</h3>\n
        testo;
        if($valutabile){
            $html .=<<<testo
                    <h4>Questa scheda non è ancora stata compilata, 
                        <a href="{$_SESSION['web_root']}?comando=compila-scheda&tipo_recensito={$recensito}">compilala adesso</a>
                    </h4>
                </div>\n
            testo;
        }else{
            $html .=<<<testo
                    <h4>Questa scheda non è ancora stata compilata</h4>
                </div>\n
            testo;
        }
    }else{
        $html =<<<testo
        <div class="scheda-di-valutazione">
            <h3>Scheda di valutazione {$recensore}-{$recensito}</h3>
            <table>
                <thead>
                    <th>Aspetto</th>
                    <th>Voto</th>
                </thead>
                <tbody>
        testo;
        foreach($scheda->getValutazioni() as $valutazione){
            $html .=<<<testo
                <tr>
                    <td>{$valutazione->getAspetto()}</td>
                    <td>{$valutazione->getVoto()}</td>
                </tr>
            testo;
        }
        $html .=<<<testo
                </tbody>
            </table>
        </div>\n
        testo;
    }

    return $html;
}

function creaBarraLaterale($esperienza) {
    $studente = $esperienza->getStudente();
    $classe = $esperienza->getPercorso()->getClasse();
    $tutor = $esperienza->getPercorso()->getDocente();
    $html =<<<testo
            <div class="barra-laterale">
                <h3>Esperienza</h3>
                <p><b>Dati dello studente</b></p>
                <b>Studente:</b> {$studente->getCognome()} {$studente->getNome()}<br>
                <b>Scuola:</b> {$classe->getScuola()->getNome()}<br>
                <b>Classe:</b> {$classe->getNumero()}{$classe->getSezione()} {$classe->getAnnoScolastico()}<br>
                <p><b>Dati dell'esperienza</b></p>
                <b>Periodo:</b> {$esperienza->getDal()} -> {$esperienza->getAl()}<br>
                <b>Azienda:</b> {$esperienza->getAzienda()->getNome()}<br>
                <b>Tutor:</b> {$tutor->getCognome()} {$tutor->getNome()}<br>\n
    testo;
    if($esperienza->getAgenzia() != null){
        $html .= "\t\t\t<b>Agenzia:</b> {$esperienza->getAgenzia()->getNome()}<br>\n";
    }
    if($esperienza->getFamiglia() != null){
        $html .= "\t\t\t<b>Famiglia:</b> {$esperienza->getFamiglia()->getNome()}<br>\n";
    }
    $html .=<<<testo
            </div>\n
    testo;
    return $html;
}
?>