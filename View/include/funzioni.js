function mostraMenuUtente(){
	var menuUtente = document.getElementById("menu-utente");
	if(menuUtente.style.visibility == "visible") {
		menuUtente.style.visibility = "hidden";
	} else {
		menuUtente.style.visibility = "visible";
	}
}

function controlloPassword(form) { 
	password1 = form.fieldset.password.value;
	password2 = form.fieldset.passwordConferma.value; 
	   
	if (password1 === password2) { 
		return true;
	}
	alert ("Le password non corrispondono");
	return false;
}

function controlloEmail(form) { 
	email1 = form.fieldset.email.value;
	email2 = form.fieldset.emailConferma.value; 
	   
	if (email1 === email2) { 
		return true;
	}
	alert ("Le email non corrispondono");
	return false;
} 