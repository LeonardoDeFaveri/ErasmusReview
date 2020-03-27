<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . '/../';
}
include_once "{$_SESSION['root']}/Model/Soggetti/Studente.php";
?>