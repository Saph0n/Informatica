
-- CODICE SQL PER CREARE IL DATABASE

-- Creazione del database
CREATE DATABASE GestioneRistorante_5Q;
USE GestioneRistorante_5Q;

-- Creazione della tabella Tavoli
CREATE TABLE Tavoli (
    IDTavolo INT AUTO_INCREMENT PRIMARY KEY,
    NumeroTavolo INT NOT NULL,
    Capacita INT NOT NULL
);

-- Creazione della tabella Prenotazioni
CREATE TABLE Prenotazioni (
    IDPrenotazione INT AUTO_INCREMENT PRIMARY KEY,
    IDTavolo INT,
    NomeCliente VARCHAR(255) NOT NULL,
    EmailCliente VARCHAR(255) NOT NULL,
    Giorno DATE NOT NULL,
    NumeroPersone INT NOT NULL,
    FOREIGN KEY (IDTavolo) REFERENCES Tavoli(IDTavolo)
);

INSERT INTO Tavoli (NumeroTavolo, Capacita) VALUES
(1, 4),
(2, 2),
(3, 6),
(4, 4),
(5, 2),
(6, 8),
(7, 4),
(8, 10),
(9, 2),
(10, 4),
(11, 6),
(12, 2),
(13, 4),
(14, 8),
(15, 10),
(16, 4),
(17, 2),
(18, 6),
(19, 8),
(20, 4);
