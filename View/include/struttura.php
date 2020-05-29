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
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
        <script src="{$_SESSION['web_root']}/View/include/funzioni.js"></script>
    </head>
    <body>
        <div id="barra-superiore">
            <header id="header-principale">
                <h1><a href="{$_SESSION['web_root']}/index.php">ErasmusReview</a> - <small>{$nomePagina}</small></h1>
            </header>\n
    testo;
    return $html;
}

function creaBarraMenu($emailUtente, $tipoUtente) {
    $tipoUtente = creaSezioneTipoUtente(strtolower($tipoUtente));
    $utente = creaSezioneUtente($emailUtente);
    $html =<<<testo
            <div id="barra-menu">
                {$tipoUtente}
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

function creaSezioneTipoUtente($tipoUtente) {
    $html = "";
    if($tipoUtente != ""){
        $html =<<<testo
            <div id="tipo-utente">
                <h3><b>Utente di tipo {$tipoUtente}</b></h3>
            </div>
        testo;
    }
    return $html;
}

function creaSezioneUtente($email) {
    $html = "\t<div id=\"utente\">\n";
    if(isset($email)){
        //Aggiunge l'evento onClick per visulizzare le opzioni per l'utente (esci e gestione)
        $html .=<<<testo
            \t\t<h3>{$email}</h3>
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
        </footer>
    </body>
    </html>
    testo;
    return $html;
}
?>