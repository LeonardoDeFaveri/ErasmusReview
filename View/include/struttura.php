<?php

    function creaHeader($titolo){
        $html =<<<testo
            <!DOCTYPE html>  
            <html>
            <head>
                <title>{$titolo} - ErasmusAdvisor</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="template/stile.css">
            </head>
            <body>
                <header>
                    <h1>{$titolo}</h1>
                </header>
                <main>
        testo;
        return $html;
    }
    
    function creaMenu(){
        $html =<<<testo
            <nav id="menu-principale">
                
            </nav>
        testo;
        return $html;
    }
    
    function creaFooter(){
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