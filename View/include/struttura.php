<?php

function creaHeader($nomePagina) {
    $html = <<<testo
    <!DOCTYPE html>  
    <html>
    <head>
        <title>{$nomePagina} - ErasmusReview</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="template/stile.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script src="include/funzioni.js"></script>
    </head>
    <body>
        <div id="barra-superiore">
            <header id="header-principale">
                <h1><a href="../index.php">ErasmusReview</a></h1>
            </header>\n
    testo;
    return $html;
}

function creaBarraMenu($emailUtente) {
    $ricerca = creaSezioneRicerca();
    $utente = creaSezioneUtente($emailUtente);
    $html =<<<testo
            <div id="barra-menu">
        {$ricerca}
        {$utente}    
            </div>
        </div>
        <main>\n
    testo;
    return $html;
}

function creaSezioneRicerca() {
    $html = <<<testo
            <div id="ricerca">
                <form method="POST" action="../index.php?comando=cerca">
                    <input type="text" placeholder="Cerca.." name="cerca">
                    <button type="submit"><i id="icona-ricerca" class="material-icons">search</i></button>
                </form>
            </div>
    testo;
    return $html;
}

function creaSezioneUtente($email) {
    $html = "\t<div id=\"utente\">\n";
    if(isset($email)){
        //Aggiunge l'evento onClick per visulizzare le opzioni per l'utente (esci e gestione)
        $html .=<<<testo
            \t\t<p>{$email}</p>
            \t\t<i id="icona-utente" class="material-icons" onClick="mostraMenuUtente()">account_circle</i>\n
        testo;
    }else{
        $html.="\t\t\t<i id='icona-utente' class='material-icons'>account_circle</i>\n";
    }
    $html .="\t\t</div>";
            
    return $html;
}

function creaFooter() {
    $html = <<<testo
        </main>
        <footer>
            <address>Progetto: Erasmus Advisor</address>
            <address>Scuola: IIS Vittorio Veneto</address>
        </footer>
    </body>
    </html>
    testo;
    return $html;
}
?>