<?php
    include_once "include/struttura.php";

    $html = creaHeader("Login");
    $html .= creaBarraMenu(null);
    $html .= <<<testo
            <fieldset>
                <legend>Accedi al tuo account</legend>
                <form method="POST" >
                    <label for="email">Indirizzo email</label><br>
                    <input type="email" name="email" placeholder="Indirizzo email" autocomplete="" required><br>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" placeholder="Password" autocomplete="" required><br>
                    <input type="submit" value="Accedi">
                </form>
            </fieldset>\n
    testo;
    $html .= creaFooter();
    echo $html;
?>