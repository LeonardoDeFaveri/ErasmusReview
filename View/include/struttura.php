<?php
function creaHeader($nomePagina) {
    $html =<<<testo
    <!DOCTYPE html>  
    <html>
    <head>
        <title>{$nomePagina} - ErasmusAdvisor</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="template/stile.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <header id="header-principale">
            <h1><a href="../index.php">ErasmusAdvisor</a></h1>
        </header>\n
    testo;
    return $html;
}

function creaBarraMenu($emailUtente) {
    $menu = creaSezioneMenu();
    $ricerca = creaSezioneRicerca();
    $utente = creaSezioneUtente($emailUtente);
    $html =<<<testo
        <div id="barra-menu">
    {$menu}
    {$ricerca}
    {$utente}    
        </div>
        <main>
    testo;
    return $html;
}

function creaSezioneMenu() {
    $html =<<<testo
            <nav id="menu-principale">
                <p>Menu</p>
            </nav>\n
    testo;
    return $html;
}

function creaSezioneRicerca() {
    $html =<<<testo
            <div id="ricerca">
                <form method="GET" action="../index.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i id="icona-ricerca" class="material-icons">search</i></button>
                </form>
            </div>\n
    testo;
    return $html;
}

function creaSezioneUtente($email) {
    $html =<<<testo
            <div id="utente">
                <p>{$email}</p>
                <i id="icona-utente" class="material-icons">account_circle</i>
            </div>\n
    testo;
    return $html;
}

function creaFooter() {
    $html =<<<testo
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