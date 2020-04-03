function mostraMenuUtente(){
	// $("#menu-utente").show();
	var menuUtente = document.getElementById("menu-utente");
	if(menuUtente.style.visibility == "visible") {
		menuUtente.style.visibility = "hidden";
	} else {
		menuUtente.style.visibility = "visible";
	}
}

function controlloCorrispondezaPassword(form) { 
	password1 = form.password.value;
	password2 = form.passwordConferma.value; 
	   
	if (password1 === password2) { 
		return true;
	}
	alert ("Le password non corrispondono");
	return false;
} 