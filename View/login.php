<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";

$html = creaHeader("Login");
$email = $_SESSION['email_utente'] ?? "";
$html .= creaBarraMenu($email);
$html .= "<h2>Login</h2>\n";
if(isset($_GET['errore']) && $_GET['errore'] == 1) {
    $html .=<<<testo
        <script>
            alert("Le credenziali inserite non sono valide!");
        </script>
    testo;
}
$html .= <<<testo
        <fieldset>
            <legend>Accedi al tuo account</legend>
            <form method="POST" action="../index.php">
                <label for="email">Indirizzo email</label><br>
                <input type="email" name="email" placeholder="Indirizzo email" autocomplete="" required><br>
                <label for="password">Password</label><br>
                <input type="password" name="password" placeholder="Password" autocomplete="" required><br>
                <input type="submit" name="login" value="Accedi">
            </form>
        </fieldset>\n
testo;
$html .= creaFooter();
echo $html;
?>