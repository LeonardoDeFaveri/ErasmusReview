<?php
if (session_id() == '') {
    session_start();
    $_SESSION['root'] = __DIR__ . "/..";
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}

function creaHeader($nomePagina) {
    $html = <<<testo
    <!DOCTYPE html>  
    <html lang="it">
    <head>
        <title>{$nomePagina} - ErasmusReview</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{$_SESSION['web_root']}/View/template/stile.css" rel="stylesheet" type="text/css">
        <script src="{$_SESSION['web_root']}/View/include/funzioni.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <div id="barra-superiore">
            <header id="header-principale">
                <hgroup>
                    <h1><a href="{$_SESSION['web_root']}/index.php">ErasmusReview</a></h1>
                    <h4 id=nome-pagina>$nomePagina</h4>
                </hgroup>
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
        <div id="menu-utente">
            <a href="{$_SESSION['web_root']}/index.php?comando=gestione-account">Gestione Account</a><br>
            <a href="{$_SESSION['web_root']}/index.php?comando=logout">Logout</a>
        </div>
        <main>\n
    testo;
    return $html;
}

function creaSezioneRicerca() {
    $html = <<<testo
            <div id="ricerca">
                <form method="POST" action="{$_SESSION['web_root']}/index.php?comando=cerca">
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
            <address>Progetto: Erasmus Review</address>
            <address>Scuola: IIS Vittorio Veneto</address>
        </footer>
    </body>
    </html>
    testo;
    return $html;
}
?>