<?php

function creaHeader($nomePagina) {
    $html = <<<testo
    <!DOCTYPE html>  
    <html>
    <head>
        <title>{$nomePagina} - ErasmusAdvisor</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="template/stile.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script src="include/funzioni.js"></script>
    </head>
    <body>
        <div id="barra-superiore">
            <header id="header-principale">
                <h1><a href="../index.php">ErasmusAdvisor</a></h1>
            </header>\n
    testo;
    return $html;
}

function creaBarraMenu($emailUtente) {
    $ricerca = creaSezioneRicerca();
    $utente = creaSezioneUtente($emailUtente);
<<<<<<< HEAD
    $html = <<<testo
        <div id="barra-menu">
    {$menu}
    {$ricerca}
    {$utente}    
=======
    $html =<<<testo
            <div id="barra-menu">
        {$ricerca}
        {$utente}    
            </div>
>>>>>>> eb02466e2148dd6b76b252170b4c0913b6fb79fb
        </div>
        <main>\n
    testo;
    return $html;
}

<<<<<<< HEAD
function creaSezioneMenu() {
    $html = <<<testo
            <nav id="menu-principale">
                <p>Menu</p>
            </nav>\n
    testo;
    return $html;
}

=======
>>>>>>> eb02466e2148dd6b76b252170b4c0913b6fb79fb
function creaSezioneRicerca() {
    $html = <<<testo
            <div id="ricerca">
                <form method="POST" action="../index.php?comando=cerca">
                    <input type="text" placeholder="Cerca.." name="cerca">
                    <button type="submit"><i id="icona-ricerca" class="material-icons">search</i></button>
                </form>
            </div>\n
    testo;
    return $html;
}

function creaSezioneUtente($email) {
    $html = "<div id=\"utente\">";
    /*se l email è settata allora l accesso è stato effettuato*/
    if(isset($email)){
        /*allora posso cliccare e vedere i link a esci o gestione account*/
        $html.="<p>{$email}</p>";
        $html.="<i id=\"icona-utente\" class=\"material-icons\" onClick=\"mostraMenuUtente()\">account_circle</i>";
    }else{
        /*altrimenti no*/
        $html.="<i id=\"icona-utente\" class=\"material-icons\">account_circle</i>";
    }
    $html .="</div>\n";
            
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