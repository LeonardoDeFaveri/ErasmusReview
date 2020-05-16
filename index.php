<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__;
    $protocollo = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $_SESSION['web_root'] = "{$protocollo}://{$_SERVER['SERVER_NAME']}/ErasmusReview";
}
include_once "{$_SESSION['root']}/Controller/Controller.php";

$controllo = new Controller();
$controllo->invoca();
?>