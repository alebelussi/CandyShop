CREATE DATABASE IF NOT EXISTS CandyShop;

USE CandyShop;

/* SEDE ( Citta, Via, CAP, Regione) */
CREATE TABLE IF NOT EXISTS Sede (
    Citta VARCHAR(20) NOT NULL, 
    Via VARCHAR(30) NOT NULL, 
    CAP INTEGER(5), 
    Regione VARCHAR(20),
    
    PRIMARY KEY (Citta, Via)
);

/* NEGOZIO ( CodiceNegozio, Nome, Telefono, E-mail, *Sede) */
CREATE TABLE IF NOT EXISTS Negozio (
    CodiceNegozio VARCHAR(20) NOT NULL, 
    Nome VARCHAR(20) NOT NULL, 
    Telefono INT(9),
    Email VARCHAR(30),
    Citta VARCHAR(20) NOT NULL, 
    Via VARCHAR(30) NOT NULL,
    
    PRIMARY KEY (CodiceNegozio),
    FOREIGN KEY (Citta, Via) REFERENCES Sede(Citta, Via)
);

/* ORARIO ( Giorno, OraInizio, OraFine) */
CREATE TABLE IF NOT EXISTS Orario (
    Giorno ENUM('Lunedi', 'Martedi', 'Mercoledi', 'Giovedi', 'Venerdi', 'Sabato', 'Domenica') NOT NULL,
    CodiceNegozio VARCHAR(20),
    OraInizio TIME, 
    OraFine TIME,
    
    PRIMARY KEY (Giorno, CodiceNegozio)
);

/* APERTURA ( CodiceNegozio, Giorno, OraInizio, OraFine) */
CREATE TABLE IF NOT EXISTS Apertura (
    CodiceNegozio VARCHAR(20) NOT NULL, 
    Giorno ENUM('Lunedi', 'Martedi', 'Mercoledi', 'Giovedi', 'Venerdi', 'Sabato', 'Domenica') NOT NULL,
    
    PRIMARY KEY (CodiceNegozio, Giorno),
    FOREIGN KEY (CodiceNegozio) REFERENCES Negozio(CodiceNegozio),
    FOREIGN KEY (Giorno) REFERENCES Orario(Giorno)
);

/* CATEGORIA ( CodiceCategoria, Nome, Descrizione, ScorteMinime, Packaging) */
CREATE TABLE IF NOT EXISTS Categoria (
	CodiceCategoria VARCHAR(20) NOT NULL, 
    Nome VARCHAR(20) NOT NULL,
    Descrizione VARCHAR(50) NOT NULL, 
    ScorteMinime INT NOT NULL, 
    Packaging VARCHAR(40),
    
    PRIMARY KEY(CodiceCategoria)
);

/* PRODOTTO ( Nome, Prezzo, Peso, QuantitaMagazzino, DataScandenza, *Categoria) */
CREATE TABLE IF NOT EXISTS Prodotto (
	Nome VARCHAR(40) NOT NULL, 
    Prezzo DECIMAL(10, 2) NOT NULL, 
    Peso DECIMAL(10, 2), 
    QuantitaMagazzino INT NOT NULL, 
    DataScadenza DATE, 
    PercorsoImmagine VARCHAR(255),
    CodiceCategoria VARCHAR(20) NOT NULL, 
    
    PRIMARY KEY(Nome), 
    FOREIGN KEY (CodiceCategoria) REFERENCES Categoria(CodiceCategoria)
);

/*FORNITORE ( CodiceFornitore, Nome, NomeProprietario, Contratto, Telefono, *Sede) */
CREATE TABLE IF NOT EXISTS Fornitore (
	CodiceFornitore VARCHAR(20) NOT NULL, 
    Nome VARCHAR(30) NOT NULL,
    NomeProprietario VARCHAR(30) NOT NULL, 
    Contratto VARCHAR(30),
    Telefono INT(9),
    Citta VARCHAR(20) NOT NULL, 
    Via VARCHAR(30) NOT NULL, 
    
    PRIMARY KEY (CodiceFornitore),
    FOREIGN KEY (Citta, Via) REFERENCES Sede(Citta, Via)
);

/* CONSEGNA ( Fornitore, Prodotto, QuantitaFornita) */
CREATE TABLE IF NOT EXISTS Consegna (
	CodiceFornitore VARCHAR(20) NOT NULL, 
    Nome VARCHAR(30) NOT NULL, 
    QuantitaFornita INT,
    
    FOREIGN KEY (CodiceFornitore) REFERENCES Fornitore(CodiceFornitore),
    FOREIGN KEY (Nome) REFERENCES Prodotto(Nome)
);

/* UTENTE ( Username, Nome, Cognome, Password, E-mail, CodiceFiscale, LivelloFedelta, Ruolo) */
CREATE TABLE IF NOT EXISTS Utente (
	Username VARCHAR(20) NOT NULL, 
    Nome VARCHAR(20) NOT NULL, 
    Cognome VARCHAR(20) NOT NULL, 
    Password VARCHAR(255) NOT NULL, 
    Email VARCHAR(40), 
    CodiceFiscale VARCHAR(20), 
    LivelloFedelta ENUM('Standard', 'Premium', 'Gold'),
    Ruolo ENUM('Cliente', 'Amministratore'),
    
    PRIMARY KEY (Username)
);

/* SPESA ( CodiceOrdine, Importo, Citta, CAP, Via, Tipo, 
ModalitaSpedizione, PuntiFedelta, DataConsegna, DataOrdine, *Utente, *Negozio) */
CREATE TABLE IF NOT EXISTS Spesa (
	CodiceOrdine VARCHAR(255) NOT NULL,
    Importo FLOAT NOT NULL, 
    CittaConsegna VARCHAR(20),
    CAP VARCHAR(20),
    Via VARCHAR(40),
    Tipo VARCHAR(30) NOT NULL,
    ModalitaSpedizione VARCHAR(30),
    PuntiFedelta INT NOT NULL,
    DataConsegna DATE,
    DataOrdine DATE NOT NULL, 
    Username VARCHAR(20) NOT NULL, 
    CodiceNegozio VARCHAR(20) NOT NULL, 
    
    PRIMARY KEY (CodiceOrdine),
    FOREIGN KEY (Username) REFERENCES Utente(Username),
    FOREIGN KEY (CodiceNegozio) REFERENCES Negozio(CodiceNegozio)
);

/* ORDINA ( Spesa, Prodotto, QuantitaOrdinata) */
CREATE TABLE IF NOT EXISTS Ordina (
	CodiceOrdine VARCHAR(255) NOT NULL,
    Nome VARCHAR(40) NOT NULL, 
    QuantitaOrdinata INT,
    
    PRIMARY KEY (CodiceOrdine, Nome),
	FOREIGN KEY (CodiceOrdine) REFERENCES Spesa(CodiceOrdine),
    FOREIGN KEY (Nome) REFERENCES Prodotto(Nome)
);

/* VENDE(CodiceNegozio, NomeProdotto, QuantitaVenduta) */
CREATE TABLE IF NOT EXISTS Vendita (
	CodiceNegozio VARCHAR(20) NOT NULL, 
    Nome VARCHAR(40) NOT NULL,
    QuantitaVenduta INT(4) NOT NULL,
    
    PRIMARY KEY (CodiceNegozio, Nome),
    FOREIGN KEY (CodiceNegozio) REFERENCES Negozio(CodiceNegozio),
    FOREIGN KEY (Nome) REFERENCES Prodotto(Nome)
);


/* RECENSIONE ( NumeroRecensione, Commento, Punteggio, DataRecensione, *Utente) */
CREATE TABLE IF NOT EXISTS Recensione (
	NumeroRecensione INT NOT NULL AUTO_INCREMENT, 
    Commento VARCHAR(100), 
    Punteggio ENUM('1', '2', '3', '4', '5') NOT NULL, 
    DataRecensione DATE NOT NULL,
    Username VARCHAR(20) NOT NULL,
    
    PRIMARY KEY (NumeroRecensione),
    FOREIGN KEY (Username) REFERENCES Utente(Username)
);

CREATE TABLE IF NOT EXISTS Lavoratore (
	CodiceFiscale VARCHAR(20) NOT NULL,
    Nome VARCHAR(20) NOT NULL,
    Cognome VARCHAR(20) NOT NULL,
    DataNascita DATE, 
    Stipendio DECIMAL(10,0),
    Contratto VARCHAR(40),
    Telefono INT(11),
    Ruolo ENUM('Titolare', 'Dipendente'),
    DataNomina DATE,
    CodiceTurno VARCHAR(20),
    Username VARCHAR(20),
    
    PRIMARY KEY(CodiceFiscale),
    FOREIGN KEY(CodiceTurno) REFERENCES Turno(CodiceTurno),
    FOREIGN KEY(Username) REFERENCES Utente(Username)
);

CREATE TABLE IF NOT EXISTS Impiego (
	CodiceNegozio VARCHAR(20) NOT NULL,
    CodiceFiscale VARCHAR(20) NOT NULL,
    DataInizio DATE,
    DataFine DATE,
    
    PRIMARY KEY(CodiceNegozio, CodiceFiscale),
    FOREIGN KEY (CodiceNegozio) REFERENCES Negozio(CodiceNegozio),
	FOREIGN KEY (CodiceFiscale) REFERENCES Lavoratore(CodiceFiscale)
);