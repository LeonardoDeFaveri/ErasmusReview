<?php
/**
 * homeStudente contiene una lista di tutte le esperienze svolte e attive per uno studente.
 */
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Esperienze");
if(isset($_GET['errore']) || !isset($_SESSION['studente'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come utente per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $studente = unserialize($_SESSION['studente']);
    $html .= creaBarraMenu($studente->getEmail());

    if(isset($_SESSION['esperienze'])){
        $esperienze = unserialize($esperienze);
        $html.=<<<testo
            <table id="esperienze">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Azienda</th>
                        <th>Agenzia</th>
                        <th>Famiglia</th>
                        <th>Data inizio</th>
                        <th>Data fine</th>
                    </tr>
                </thead>
                <tbody>
        testo;

        foreach ($esperienze as $esperienza) {
            $html .=<<<testo
                    <tr>
                        <td>{$esperienza->getId()}</td>
                        <td><a href="#">{$esperienza->getAzienda()->getNome()}</a></td>
                        <td><a href="#">{$esperienza->getAgenzia()->getNome()}</a></td>
                        <td><a href="#">{$esperienza->getFamiglia()->getCognome()}</a></td>
                        <td>{$esperienza->getDal()}</td>
                        <td>{$esperienza->getAl()}</td>
                    </tr>
            testo;
        }

        $html .=<<<testo
                </tbody>
            </table>
        testo;
    }
}
$html .= creaFooter();
echo $html;
?>