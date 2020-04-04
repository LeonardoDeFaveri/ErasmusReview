<?php
    if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Esperienze");

if(isset($_GET['errore']) || !isset($_SESSION['agenzia'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come agenzia per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}
else{   
    $scuole=unserialize($_SESSION["scuole"]);

    $html.=<<<testo
        <table>
            <thead>
                <tr>
                    <th>Codeice Meccanografico</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Citt&agrave;</th>
                    <th>Indirizzo</th>
                    <th>Modifica</th>
                </tr>
            </thead>
            <tbody>
    testo;

    foreach($scuole as $elemento){  
        $html .=<<<testo
        <tr>
            <td>{$elemento->getId()}</td>
            <td>{$elemento->getNome()}</td>
            <td>{$elemento->getEmail()}</td>
            <td>{$elemento->getCitta()}</td>
            <td>{$elemento->getIndirizzo()}</td>
            <td>{$elemento->getIndirizzo()}</td>
        </tr>\n
    testo;
    }

    $html .= creaFooter();
    echo $html;
}