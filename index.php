<?php
    if(session_id() == ''){
        session_start();
    }
    $_SESSION['root'] = __DIR__;
    include_once "{$_SESSION['root']}/Controller/Controller.php";

    $controllo = new Controller();
    $controllo->invoca();
?>