SET AUTOCOMMIT = 0;
START TRANSACTION;

DROP DATABASE IF EXISTS erasmus_advisor;
DROP DATABASE IF EXISTS erasmus_review;
CREATE DATABASE erasmus_review;
USE erasmus_review;

CREATE TABLE modelli (
	id INTEGER NOT NULL AUTO_INCREMENT,
	tipo_recensore VARCHAR (20) NOT NULL,
    tipo_recensito VARCHAR (20) NOT NULL, 
	
	PRIMARY KEY (id),
	UNIQUE(tipo_recensore, tipo_recensito)
);

CREATE TABLE aspetti(
	id INTEGER NOT NULL AUTO_INCREMENT,
	nome VARCHAR (100),
	PRIMARY KEY (id)
);

CREATE TABLE tipi_utenti(
	tipo_utente VARCHAR(50) NOT NULL,
	PRIMARY KEY(tipo_utente)
);

CREATE TABLE utenti (
	email VARCHAR(320) NOT NULL,
	password VARCHAR(64) NOT NULL,
	tipo_utente VARCHAR (30) NOT NULL,
	PRIMARY KEY (email),
	FOREIGN KEY (tipo_utente) REFERENCES tipi_utenti(tipo_utente)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

CREATE TABLE famiglie(
	id INTEGER NOT NULL AUTO_INCREMENT,
	nome VARCHAR (50),
	cognome VARCHAR (50),
	stato VARCHAR (30),
	citta VARCHAR (30),
	indirizzo VARCHAR (100),
	PRIMARY KEY (id)
);

CREATE TABLE modelli_aspetti(
	id INTEGER NOT NULL AUTO_INCREMENT,
	id_modello INTEGER NOT NULL,
	id_aspetto INTEGER NOT NULL,
	PRIMARY KEY (id),
	UNIQUE(id_modello, id_aspetto),
	FOREIGN KEY (id_modello) REFERENCES modelli (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY (id_aspetto) REFERENCES aspetti (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE studenti(
	id INTEGER NOT NULL AUTO_INCREMENT,
	email_utente VARCHAR (320) NOT NULL,
	nome VARCHAR (50) NOT NULL,
	cognome VARCHAR (50) NOT NULL,
	data_nascita DATE NOT NULL,
	PRIMARY KEY (id),
    UNIQUE (email_utente),
	FOREIGN KEY (email_utente) REFERENCES utenti (email)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE aziende(
	id INTEGER NOT NULL AUTO_INCREMENT,
	email_utente VARCHAR (320) NOT NULL,
	nome VARCHAR (50),
	stato VARCHAR (30),
	citta VARCHAR (30),
	indirizzo VARCHAR (100),
	telefono VARCHAR (50),
	PRIMARY KEY (id),
    UNIQUE (email_utente),
	FOREIGN KEY (email_utente) REFERENCES utenti (email)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE agenzie(
	id INTEGER NOT NULL AUTO_INCREMENT,
	email_utente VARCHAR (320),
	nome VARCHAR (50),
	stato VARCHAR (30),
	citta VARCHAR (30),
	indirizzo VARCHAR (100),
	telefono VARCHAR (50),
	PRIMARY KEY (id),
    UNIQUE (email_utente),
	FOREIGN KEY (email_utente) REFERENCES utenti(email)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE docenti(
	id INTEGER NOT NULL AUTO_INCREMENT,
	email_utente VARCHAR (320),
	nome VARCHAR (50),
	cognome VARCHAR (50),
	PRIMARY KEY (id),
    UNIQUE (email_utente),
	FOREIGN KEY (email_utente) REFERENCES utenti(email)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE scuole(
	codice_meccanografico VARCHAR (30) NOT NULL,
	email_utente VARCHAR (320),
	nome VARCHAR (50),
	citta VARCHAR (30),
	indirizzo VARCHAR (100),
	PRIMARY KEY (codice_meccanografico),
    UNIQUE (email_utente),
	FOREIGN KEY (email_utente) REFERENCES utenti(email)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE studenti_scuole(
	id INTEGER NOT NULL AUTO_INCREMENT,
	codice_scuola VARCHAR (30) NOT NULL,
	id_studente INTEGER NOT NULL,
	dal DATE NOT NULL,
	al DATE,
	PRIMARY KEY (id),
	UNIQUE(id_studente, dal),
	FOREIGN KEY (codice_scuola) REFERENCES scuole (codice_meccanografico)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_studente) REFERENCES studenti (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE docenti_scuole(
    id INTEGER NOT NULL AUTO_INCREMENT,
    codice_scuola VARCHAR (30) NOT NULL,
    id_docente INTEGER NOT NULL,
    dal DATE NOT NULL,
    al DATE,
    PRIMARY KEY (id),
    UNIQUE (codice_scuola, id_docente, dal),
    FOREIGN KEY (codice_scuola) REFERENCES scuole (codice_meccanografico)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_docente) REFERENCES docenti (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE classi(
	id INTEGER NOT NULL AUTO_INCREMENT,
	codice_scuola VARCHAR (30) NOT NULL,
	numero INTEGER NOT NULL,
	sezione VARCHAR (5) NOT NULL,
	anno_scolastico VARCHAR (9) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (codice_scuola,numero,sezione,anno_scolastico),
	FOREIGN KEY (codice_scuola) REFERENCES scuole (codice_meccanografico)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE classi_studenti(
	id INTEGER NOT NULL AUTO_INCREMENT,
	id_studente INTEGER NOT NULL,
	id_classe INTEGER NOT NULL,
	dal DATE,
	al DATE,
	PRIMARY KEY (id),
	UNIQUE (id_studente,dal),
	FOREIGN KEY (id_studente) REFERENCES studenti(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY (id_classe) REFERENCES classi(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
CREATE TABLE classi_docenti(
	id INTEGER NOT NULL AUTO_INCREMENT,
	id_docente INTEGER NOT NULL,
	id_classe INTEGER NOT NULL,
	dal DATE,
	al DATE,
	PRIMARY KEY(id),
	UNIQUE (id_docente,dal),
	FOREIGN KEY (id_docente) REFERENCES docenti(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY (id_classe) REFERENCES classi (id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

CREATE TABLE percorsi (
	id INTEGER NOT NULL AUTO_INCREMENT,
	id_docente INTEGER NOT NULL,
	id_classe INTEGER NOT NULL,
	dal DATE NOT NULL,
	al DATE NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (id_docente) REFERENCES docenti(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY (id_classe) REFERENCES classi(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE esperienze(
	id INTEGER NOT NULL AUTO_INCREMENT,
	id_studente INTEGER NOT NULL,
	id_azienda INTEGER NOT NULL,
	id_percorso INTEGER NOT NULL,
    id_agenzia INTEGER,
	id_famiglia INTEGER,
	dal DATE NOT NULL,
	al DATE NOT NULL,

	PRIMARY KEY (id),
	UNIQUE (id_studente, dal),
	FOREIGN KEY (id_azienda) REFERENCES aziende(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY (id_percorso) REFERENCES percorsi(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_agenzia) REFERENCES agenzie(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY (id_famiglia) REFERENCES famiglie(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE schede_di_valutazione(
	id INTEGER NOT NULL AUTO_INCREMENT,
	id_modello INTEGER NOT NULL,
	id_recensore INTEGER NOT NULL,
	id_recensito INTEGER NOT NULL,
	id_esperienza INTEGER NOT NULL,
	data_ora DATETIME NOT NULL DEFAULT NOW(),
	PRIMARY KEY (id),
	FOREIGN KEY (id_modello) REFERENCES modelli(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	FOREIGN KEY (id_esperienza) REFERENCES esperienze(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE valutazioni(
	id_scheda_di_valutazione INTEGER NOT NULL,
	voto INTEGER NOT NULL,
	id_aspetto INTEGER NOT NULL,
	PRIMARY KEY (id_scheda_di_valutazione,id_aspetto),
	FOREIGN KEY (id_scheda_di_valutazione) REFERENCES schede_di_valutazione (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY (id_aspetto) REFERENCES aspetti(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

COMMIT;