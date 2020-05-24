function mostraMenuUtente(){
	var menuUtente = document.getElementById("menu-utente");
	if(menuUtente.style.visibility == "visible") {
		menuUtente.style.visibility = "hidden";
	} else {
		menuUtente.style.visibility = "visible";
	}
}

/**
 * Controlla nei form per il cambio della password, che la password
 * e la sua conferma coincidano.
 */
function controlloPassword() {
	password1 = document.getElementById("password").value;
	password2 = document.getElementById("passwordConferma").value;
	   
	if (password1 === password2) { 
		return true;
	}
	document.getElementById("password").value = "";
	document.getElementById("passwordConferma").value = "";
	alert ("Le password non corrispondono");
	return false;
}

/**
 * Controlla nei form per la modifica dell'email, che l'email
 * e la sua conferma coindidano.
 */
function controlloEmail() { 
	email1 = document.getElementById("email").value;
	email2 = document.getElementById("emailConferma").value;

	if (email1 === email2) { 
		return true;
	}
	alert ("Le email non corrispondono");
	return false;
}

function controllaEsperienza() {
	agenzia = document.getElementById("id_agenzia").value;
	famiglia = document.getElementById("id_famiglia").value;
	dal = document.getElementById("dataDal").value;
	al = document.getElementById("dataAl").value;

	if(agenzia == "null" && famiglia != "null"){
		alert("Se specifichi l'agenzia, la famiglia non può essere vuota");
		return false;
	}

	if (famiglia == "null" && agenzia != "null") {
		alert("Se specifichi la famiglia, l'agenzia non può essere vuota");
		return false;
	}

	if(dal == "" && al != "" || dal != "" && al == ""){
		alert("Devi specificare sia la data di inizio che di fine, oppure nessuna");
		return false;
	}

	if(dal != "" && al != "" && dal >= al) {
		alert("L'intervallo temporale specificato è sbagliato");
		return false;
	}

	return true;
}