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

function controlloCorrispondezaEmail(form) { 
	email1 = form.email.value;
	email2 = form.emailConferma.value; 
	   
	if (email1 === email2) { 
		return true;
	}
	alert ("Le email non corrispondono");
	return false;
} 