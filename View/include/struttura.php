<?php
    function creaHeader($titolo){
        $html =<<<testo
            <!DOCTYPE html>  
            <html>
            <head>
                <title>{$titolo} - ErasmusAdvisor</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="{$_SESSION['root']}/View/template/stile.css">
            </head>
            <body>
        testo;
        return html;
    }
    
    function creaFooter(){
        $html =<<<testo
                <footer>

                </footer>
            </body>
            </html>
        testo;
        return $html;
    }
?>