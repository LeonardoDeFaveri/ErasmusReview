START TRANSACTION;

DELETE FROM tipi_utenti;
INSERT INTO tipi_utenti (tipo_utente) VALUES
('studente'),
('docente'),
('azienda'),
('agenzia'),
('scuola'),
('admin');


DELETE FROM utenti;
INSERT INTO utenti (email, password, tipo_utente) VALUES
    ('leonardo.defaveri@iisvittorioveneto.it', SHA2('leonardo', 256), 'studente'),
    ('riccardo.pavetta@iisvittorioveneto.it', SHA2('riccardo', 256), 'studente'),
    ('alessandro.rizzo@iisvittorioveneto.it', SHA2('alessandro', 256), 'studente'),
    ('marco.arnosti@iisvittorioveneto.it', SHA2('marco', 256), 'studente'),
	('vincenzo@iisvittorioveneto.it', SHA2('vincenzo', 256), 'studente'),
	('gabriele@iisvittorioveneto.it', SHA2('gabriele', 256), 'studente'),
	('saliou@iisvittorioveneto.it', SHA2('saliou', 256), 'studente'),
	('gianni@iisvittorioveneto.it', SHA2('gianni', 256), 'studente'),
	('francesco.paolin@iisvittorioveneto.it', SHA2('francesco', 256), 'studente'),
    ('adriano.botteon@iisvittorioveneto.it', SHA2('adriano', 256), 'docente'),
    ('stefano.zanetti@iisvittorioveneto.it', SHA2('stefano', 256), 'docente'),
	('vittorio.nuvoletta@iisvittorioveneto.it', SHA2('vittorio', 256), 'docente'),
    ('silca.spa@gmail.com', SHA2('silca', 256), 'azienda'),
    ('drz@gmail.com', SHA2('drz', 256), 'azienda'),
    ('idempiere@gmail.com', SHA2('idempiere', 256), 'azienda'),
    ('persite@gmail.com', SHA2('pernisite', 256), 'azienda'),
    ('agenzia.malta@gmail.com', SHA2('agenzia', 256), 'agenzia'),
    ('itt@iisvittorioveneto.it', SHA2('itt', 256), 'scuola'),
    ('ite@iisvittorioveneto.it', SHA2('ite', 256), 'scuola'),
    ('ipsia@iisvittorioveneto.it', SHA2('ipsia', 256), 'scuola');

DELETE FROM studenti;
INSERT INTO studenti (id, email_utente, nome, cognome, data_nascita) VALUES 
    (1, 'leonardo.defaveri@iisvittorioveneto.it', 'Leonardo', 'De Faveri', '2001-11-25'),
    (2, 'riccardo.pavetta@iisvittorioveneto.it', 'Riccardo', 'Pavetta', '2001-06-23'),
    (3, 'alessandro.rizzo@iisvittorioveneto.it', 'Alessandro', 'Rizzo', '2001-12-12'),
    (4, 'marco.arnosti@iisvittorioveneto.it', 'Marco', 'Arnosti', '2001-01-17'),
    (5, 'francesco.paolin@iisvittorioveneto.it', 'Francesco', 'Paolin', '2001-08-12'),
	(6, 'vincenzo@iisvittorioveneto.it', 'Vincenzo', 'Bara', '2001-10-05'),
	(7, 'saliou@iisvittorioveneto.it', 'Saliou', 'Gaye', '2001-12-29'),
	(8, 'gianni@iisvittorioveneto.it', 'Gianni', 'Rossi', '2001-06-07'),
	(9, 'gabriele@iisvittorioveneto.it', 'Gabriele', 'Darsie', '2001-08-02');

DELETE FROM docenti;
INSERT INTO docenti (id, email_utente, nome, cognome) VALUES
    (1, 'adriano.botteon@iisvittorioveneto.it', 'Adriano', 'Botteon'),
    (2, 'stefano.zanetti@iisvittorioveneto.it', 'Stefano', 'Zanetti'),
	(3, 'vittorio.nuvoletta@iisvittorioveneto.it', 'Vittorio', 'Nuvoletta');
DELETE FROM aziende;
INSERT INTO aziende (id, email_utente, nome, stato, citta, indirizzo, telefono) VALUES
    (1, 'silca.spa@gmail.com', 'Silca S.P.A.', 'Italia', 'San Giacomo', 'Via Podgora, 20', '+39 04389136'),
    (2, 'drz@gmail.com', 'DRZ Office', 'Italia', 'Vittorio Veneto', 'Via Vittorio Emanuele II, 148', '+39 0438556011'),
    (3, 'idempiere@gmail.com', 'Idempiere', 'Italia', 'Mescolino-Minelle', 'Via del Marangon, 10', '+39 04381890684'),
    (4, 'persite@gmail.com', 'Pernisite', 'Malta', 'La Valletta', 'Via finta, 23', '+356 987654321');
	
DELETE FROM agenzie;
INSERT INTO agenzie (id, email_utente, nome, stato, citta, indirizzo, telefono) VALUES 
    (1, 'agenzia.malta@gmail.com', 'Agenzia', 'Malta', 'La Valletta', 'Via Fasulla, 15', '+356 123456789');

DELETE FROM famiglie;
INSERT INTO famiglie (id, nome, cognome, stato, citta, indirizzo) VALUES
    (1, 'Andrea', 'Sperelli', 'Malta', 'La Valletta', 'Via maltese, 7');

DELETE FROM scuole;
INSERT INTO scuole (codice_meccanografico, email_utente, nome, citta, indirizzo) VALUES
    ('TVTF007017', 'itt@iisvittorioveneto.it', 'ITT - IIS Vittorio Veneto', 'Vittorio Veneto', 'Via Covour, 1'),
    ('TVTD007011', 'ite@iisvittorioveneto.it', 'ITE - IIS Vittorio Veneto', 'Vittorio Veneto', 'Via Pontavai, 121'),
    ('TVRI00701A', 'ipsia@iisvittorioveneto.it', 'IPSIA - IIS Vittorio Veneto', 'Vittorio Veneto', 'Via Vittorio Emanuele II, 97');

DELETE FROM docenti_scuole;
INSERT INTO docenti_scuole (codice_scuola, id_docente, dal, al) VALUES
    ('TVTF007017', 1, '1998-09-01', NULL),
    ('TVTF007017', 2, '2015-09-01', NULL),
    ('TVTF007017', 3, '2008-09-01', '2009-06-07');

DELETE FROM classi;
INSERT INTO classi (id, codice_scuola, numero, sezione, anno_scolastico) VALUES
    (1, 'TVTF007017', 5, 'AINFO', '2019/2020');

DELETE FROM classi_studenti;
INSERT INTO classi_studenti (id_studente, id_classe, dal, al) VALUES
    (1, 1, '2019-9-1', '2020-10-31'),
    (2, 1, '2019-9-1', '2020-10-31'),
    (3, 1, '2019-9-1', '2020-10-31'),
    (4, 1, '2019-9-1', '2020-10-31'),
    (5, 1, '2019-9-1', '2020-10-31');

DELETE FROM classi_docenti;
INSERT INTO classi_docenti (id_docente, id_classe, dal, al) VALUES 
	(1,1,'2019-9-1', '2020-10-31'),
	(2,1,'2019-9-1', '2020-10-31'),
	(3,1,'2019-9-1', '2020-10-31');

DELETE FROM percorsi;
INSERT INTO percorsi (id, id_docente, id_classe,dal,al) VALUES 
    (1, 1, 1,"2019-10-01","2019-10-31"),
	(2, 1, 1,"2020-02-25","2025-10-30");

DELETE FROM esperienze;
INSERT INTO esperienze (id_studente, id_azienda, id_percorso, id_agenzia, id_famiglia, dal, al) VALUES
    (1, 1, 1, NULL, NULL, '2019-10-01', '2019-10-30'),
	(1, 1, 2, NULL, NULL, '2020-02-25', '2025-10-30'),
	(1, 1, 1, 1, 1, '2019-11-01', '2019-12-30'),
    (2, 4, 1, 1, 1, '2019-10-01', '2019-10-30'),
	(2, 4, 1, NULL, NULL, '2019-11-01', '2019-12-30'),
	(2, 3, 2, 1, 1, '2020-02-25', '2025-10-30'),
    (3, 2, 1, NULL, NULL, '2019-10-01', '2019-10-30'),
	(3, 2, 2, NULL, NULL, '2020-02-25', '2025-10-30'),
	(3, 2, 1, 1, 1, '2019-11-01', '2019-12-30'),
	(4, 3, 1, NULL, NULL, '2019-10-01', '2019-10-30'),
	(4, 3, 2, NULL, NULL, '2020-02-25', '2025-10-30'),
	(4, 3, 1, 1, 1, '2019-11-01', '2019-12-30'),
    (5, 3, 1, NULL, NULL, '2019-10-01', '2019-10-30'),
	(5, 3, 2, NULL, NULL, '2020-02-25', '2025-10-30'),
	(5, 3, 1, 1, 1, '2019-11-01', '2019-12-30'),	
	(6, 1, 1, NULL, NULL, '2018-10-01', '2018-10-30'),
	(6, 1, 1, 1, 1, '2019-10-01', '2019-10-30'),
	(6, 1, 2, NULL, NULL, '2020-02-01', '2025-10-30'),
	(7, 1, 1, NULL, NULL, '2020-02-01', '2025-10-30'),
	(7, 1, 2, NULL, NULL, '2020-02-25', '2025-10-30'),
	(7, 1, 1, 1, 1, '2019-11-01', '2019-12-30');

DELETE FROM modelli;
INSERT INTO modelli (id,tipo_recensore,tipo_recensito) 
VALUES
	(1,"Studente","Azienda"),
	(2,"Azienda","Studente");
	
DELETE FROM aspetti;
INSERT INTO aspetti (id,nome) 
VALUES 
	(1,"Disponibilita del personale"),
	(2,"Spiegazione del lavoro che deve essere svolto "),
	(3,"Tempo di inattivita "),
	(4,"Chiarezza nell'assegnazione delle mansioni"),
	(5,"Educazione"),
	(6,"Preparazione"),
	(7,"Puntualità a lavoro "),
	(8,"Esegue bene il lavoro che gli è stato assegnato "),
	(9,"Rispetto verso il personale");

DELETE FROM modelli_aspetti;
INSERT INTO modelli_aspetti (id_modello,id_aspetto) 
VALUES 
	(1,1),
	(1,2),
	(1,3),
	(1,4),
	(2,5),
	(2,6),
	(2,7),
	(2,8),
	(2,9);
	
COMMIT;