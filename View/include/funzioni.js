function mostraMenuUtente(){
    html="<div id=\"menuUtente\">\n\
    <a href=\"../../index.php?comando=logout\">Esci</a><br>\n\
    <a href=\"../../index.php?comando=gestione-account\">Gestione Account</a>\n\
    </div>";
    document.getElementById("utente").innerHTML = html;
}