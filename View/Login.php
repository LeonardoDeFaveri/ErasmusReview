<?php
    include_once "View/include/struttura.php";

    $html = creaHeader("Login");
    $html .= <<<testo
        <fieldset>
            <legend>Login</legend>
            <form method="POST">
                <label for="email">Email</label>
                <input name="email" type="email" required><br>
                <label for="password">Password</label>
                <input name="password" type="password" required><br>
                <input type="submit" value="Accedi">
            </form>
        </fieldset>
    testo;
    
?>