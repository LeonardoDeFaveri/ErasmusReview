use erasmus_review;

DELIMITER //
-- insert_docente inserisce nel database un docente.
-- Viene prima creato l'utente associato, poi viene inserito il
-- docente e infine viene creata l'associazione tra il docente e la scuola.
--
-- Valori restituiti
-- 0 -> Tutto ha funzionato correttamente
-- 1 -> Esiste già un utente associato alla mail
-- 2 -> Il docente non è stato inserito con successo
-- 3 -> L'associazione docente-scuola non è stata creata con successo
CREATE OR REPLACE FUNCTION inserisci_docente (
    p_codice_scuola VARCHAR(30),
    p_email VARCHAR(320),
    p_password VARCHAR(64),
    p_nome VARCHAR (50),
    p_cognome  VARCHAR (50),
    p_dal DATE,
    p_al DATE
) RETURNS INTEGER MODIFIES SQL DATA
BEGIN
    DECLARE var_id_docente INTEGER;
    DECLARE var_id_docente_scuola INTEGER;

    -- Controlla che non esista già un utente associato alla mail
    IF (SELECT email FROM utenti WHERE email = p_email) IS NOT NULL THEN
        RETURN 1;
    END IF;
    INSERT INTO utenti (email, password, tipo_utente) VALUES (
        p_email, p_password, 'docente'
    );
    
    INSERT INTO docenti (email_utente, nome, cognome) VALUES (
        p_email, p_nome, p_cognome
    );
    SELECT id INTO var_id_docente FROM docenti WHERE email_utente = p_email;
    
    -- Controlla se è stato inserito il docente
    IF var_id_docente IS NULL THEN
        RETURN 2;
    END IF;

    INSERT INTO docenti_scuole (codice_scuola, id_docente, dal, al) VALUES (
        p_codice_scuola, var_id_docente, p_dal, p_al
    );

    SELECT id INTO var_id_docente_scuola FROM docenti_scuole 
    WHERE codice_scuola = p_codice_scuola AND id_docente = var_id_docente AND dal = p_dal;

    -- Controlla se è stata inserita l'associazione docente-scuola
    IF var_id_docente_scuola IS NULL THEN
        RETURN 3;
    END IF;

    RETURN 0;
END;
//
DELIMITER ;

DELIMITER //
-- inserisci_scuola inserisce nel database una scuola.
-- Viene prima creato l'utente associato, poi viene inserita la scuola.
--
-- Valori restituiti:
-- 0 -> Tutto ha funzionato correttamente
-- 1 -> Esiste già un utente associato alla mail
-- 2 -> Il docente non è stato inserito con successo
CREATE OR REPLACE FUNCTION inserisci_scuola (
    p_codice_scuola VARCHAR(30),
    p_email VARCHAR(320),
    p_nome VARCHAR(50),
    p_citta VARCHAR(30),
    p_indirizzo VARCHAR(100),
    p_password VARCHAR(64)
) RETURNS INTEGER MODIFIES SQL DATA
BEGIN
    -- Controlla che non esista già un utente associato alla mail
    IF (SELECT email FROM utenti WHERE email = p_email) IS NOT NULL THEN
        RETURN 1;
    END IF;
    INSERT INTO utenti (email, password, tipo_utente) VALUES (
        p_email, p_password, 'scuola'
    );

    INSERT INTO scuole (codice_meccanografico, email_utente, nome, citta, indirizzo ) VALUES (
        p_codice_scuola, p_email, p_nome, p_citta, p_indirizzo
    );

    -- Controlla che sia stata inserita la scuola
    IF (SELECT email_utente FROM scuole WHERE email_utente = p_email) IS NULL THEN
        RETURN 2;
    END IF;

    RETURN 0;
END;

//
DELIMITER ;