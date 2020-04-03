<?php
    if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/View/include/struttura.php";
//include_once "{$_SESSION['root']}/Model/Soggetti/Docente.php";
//include_once "{$_SESSION['root']}/Model/Percorso.php";
include_once "{$_SESSION['root']}/Model/Esperienza.php";

$html = creaHeader("Crea Classe");
if(isset($_GET['errore']) || !isset($_SESSION['scuola'])){
    $html .= creaBarraMenu("");
    $html .=<<<testo
        <h2>Devi aver eseguito l'accesso come scuola per poter vedere questa pagina</h2>
        <a href="login.php">Accedi</a>
    testo;
}else{
    $scuola = unserialize($_SESSION['scuola']);
    $html .= creaBarraMenu($scuola->getEmail());
    }
    $as= date("Y")-1;
    $as=$as."/".date("Y");
    $html.=<<<testo
            <div>
                <hr>
                <form method="POST" action="../index.php?comando=crea-classe">
                    <label>Numero sezione</label>
                    <input type="number" name="numero_classe" min="1" required><br>
                    <label>Sezione</label>
                    <input type=text name="sezione_classe" reqiured><br>
                    <label>Anno scolastico</label>
                    <input type=text name="as_classe" value="{$as}" maxlength="9" required><br>
                <button type="submit" id="crea-classe">Crea classe</button>
                </form>
            </div>
    testo;
                    
$html .= creaFooter();
echo $html;

?>