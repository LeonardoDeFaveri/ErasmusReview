<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . '/../';
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Tutti gli studenti");
$html .= creaBarraMenu($_SESSION['email_utente']);
$studenti = unserialize($_SESSION['studenti']);

$html .=<<<testo
    <h2>Tutti gli studenti</h2>
    <div class="contenitore-centrato">
        <table>
            <thead>
                <tr>
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data di nascita</th>
                    <th>Modifica</th>
                </tr>
            </thead>
            <tbody>\n
testo;

foreach ($studenti as $studente) {
    $html .=<<<testo
                <tr>
                    <td>{$studente->getCognome()}</td>
                    <td>{$studente->getNome()}</td>
                    <td>{$studente->getEmail()}</td>
                    <td>{$studente->getDataNascita()}</td>
                    <td><i class="material-icons">mode_edit</i></td>
                </tr>\n
    testo;
}

$html .=<<<testo
            </tbody>
        </table>
    </div>
testo;

$html .= creaFooter();
echo $html;
?>