<?php
/**
 * homeStudente contiene una lista di tutte le esperienze svolte e attive per uno studente.
 */
    if(session_id() == ''){
        session_start();
    }
    include_once "{$_SESSION['root']}/View/include/struttura.php";

    $html = creaHeader("Esperienze");
    if(isset($_SESSION['studente'])){
        $studente = unserialize($_SESSION['studente']);
        $html .= creaBarraMenu($studente->getEmail());
    }else{
        $html .= creaBarraMenu("");
    }
    
    if(isset($_SESSION['esperienze'])){
        $esperienze = unserialize($esperienze);
        $html.=<<<testo
            <table id="esperienze">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Azienda</th>
                    </tr>
                </thead>
            </table>
        testo;
    }

    $html .= creaFooter();
    echo $html;
?>