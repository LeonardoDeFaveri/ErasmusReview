<?php
/*
    homeStudente contiene una lista di tutte le esperienze svolte e attive per uno studente
*/
    include_once "include/struttura.php";

    $html = creaHeader("Esperienze");
    $html .= creaBarraMenu("email");
    $html.=<<<testo
        <p>ciao</p>
    testo;

    $html .= creaFooter();
    echo $html;
?>