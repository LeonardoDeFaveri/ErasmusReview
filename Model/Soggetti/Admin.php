<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Admin extends Soggetto{
    private $email;

    public function __construct($id, $nome, $email){
        parent::__construct($id, $nome);
        $this->email = $email;
    }
}
?>