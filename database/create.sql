create schema Biblioteca;
use Biblioteca;

CREATE TABLE Autore (
    id_autore INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    data_nascita DATE,
    luogo_nascita VARCHAR(100)
);

CREATE TABLE Libro (
    ISBN VARCHAR(20) PRIMARY KEY,
    titolo VARCHAR(255) NOT NULL,
    anno_pubblicazione INT,
    lingua VARCHAR(50)
);

CREATE TABLE Succursale (
    nome VARCHAR(100) PRIMARY KEY,
    indirizzo VARCHAR(255)
);

CREATE TABLE AutoreLibro (
    id_autore INT,
    ISBN VARCHAR(20),
    PRIMARY KEY (id_autore, ISBN),
    FOREIGN KEY (id_autore) REFERENCES Autore(id_autore) ON DELETE CASCADE,
    FOREIGN KEY (ISBN) REFERENCES Libro(ISBN) ON DELETE CASCADE
);

CREATE TABLE Utente (
    matricola VARCHAR(6) PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    indirizzo VARCHAR(255),
    telefono VARCHAR(20)
);

CREATE TABLE CopiaLibro (
    id_copia INT PRIMARY KEY AUTO_INCREMENT,
    ISBN VARCHAR(20) NOT NULL,
    succursale VARCHAR(100),
    FOREIGN KEY (ISBN) REFERENCES Libro(ISBN) ON DELETE CASCADE,
    FOREIGN KEY (succursale) REFERENCES Succursale(nome) ON DELETE CASCADE
);

CREATE TABLE Prestito (
    id_copia INT NOT NULL,
    matricola VARCHAR(6) NOT NULL,
    data_uscita DATE NOT NULL,
    data_restituzione_prevista DATE,
    PRIMARY KEY (id_copia, matricola, data_uscita),
    FOREIGN KEY (id_copia) REFERENCES CopiaLibro(id_copia) ON DELETE CASCADE,
    FOREIGN KEY (matricola) REFERENCES Utente(matricola) ON DELETE CASCADE
);