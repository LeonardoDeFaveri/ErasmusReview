<?php
    include_once "include/struttura.php";

    $html = creaHeader("Login");
    $html .= <<<testo
        <fieldset>
            <legend>Login</legend>
            <form method="POST">
                <label for="email">Email</label><br>
                <input name="email" type="email" required><br>
                <label for="password">Password</label><br>
                <input name="password" type="password" required><br>
                <input type="submit" value="Accedi">
            </form>
        </fieldset>
    testo;
    $html .= creaFooter();
    echo $html;
?>