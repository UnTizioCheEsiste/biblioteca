USE Biblioteca;

INSERT INTO Succursale (nome, indirizzo) VALUES
('Architettura', 'Via Ghiara, 36 - 44121 Ferrara'),
('Economia e Management', 'Via Voltapaletto n. 11 - 44121 Ferrara'),
('Fisica e Scienze della Terra', 'Via Saragat, 1 - 44122 Ferrara'),
('Giurisprudenza', 'Corso Ercole I d''Este n. 37 - 44121 Ferrara'),
('Ingegneria', 'Via Saragat, 1 - 44122 Ferrara'),
('Matematica e Informatica', 'Via Machiavelli, 30 - 44121 Ferrara'),
('Medicina Traslazionale e per la Romagna', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Neuroscienze e Riabilitazione', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Scienze Chimiche, Farmaceutiche ed Agrarie', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Scienze dell''Ambiente e della Prevenzione', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Scienze della Vita e Biotecnologie', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Scienze Mediche', 'Via Fossato di Mortara, 64/B - 44121 Ferrara'),
('Studi Umanistici', 'Via Paradiso, 12 - 44121 Ferrara');

INSERT INTO Autore (nome, cognome, data_nascita, luogo_nascita) VALUES
('Claudio', 'Favata', '1954-09-01', 'Borgo Damiano'),
('Alfio', 'Ravaglioli', '1952-05-06', 'Borgo Giovanni'),
('Giuseppe', 'Orlando', '1963-12-23', 'Settimo Giulio'),
('Gionata', 'Moresi', '1948-07-23', 'Ricciotti laziale'),
('Massimo', 'Muratori', '1990-04-20', 'Vanvitelli del friuli'),
('Torquato', 'Barsanti', '1948-02-11', 'Aurora salentino'),
('Anita', 'Bianchi', '1950-12-10', 'Borgo Luciano'),
('Filippa', 'Boccaccio', '1971-12-02', 'Sesto Martino');

INSERT INTO Libro (ISBN, titolo, anno_pubblicazione, lingua) VALUES
('978-88-2867825', 'Alla Ricerca del Tempo Perduto', '1995', 'Francese'),
('978-88-5614226', 'Atomic Habits', '2002', 'Italiano'),
('978-88-3341057', 'L’Amica Geniale', '2018', 'Italiano'),
('978-88-2458591', 'Never Split The Difference', '2013', 'Inglese'),
('978-88-1533224', 'Il resto di niente', '1995', 'Italiano'),
('978-88-4668136', 'Le Memorie di Adriano', '2002', 'Francese'),
('978-88-1445199', 'Diceria dell’untore', '2012', 'Italiano'),
('978-88-8038374', 'The Mountain is You', '2002', 'Inglese'),
('978-88-5667265', 'Vero minus expedita', '2020', 'Italiano'),
('978-88-3678638', 'The Pivot Year', '2017', 'Inglese');

INSERT INTO AutoreLibro (id_autore, ISBN) VALUES
(5, '978-88-2867825'),
(2, '978-88-2867825'),
(6, '978-88-5614226'),
(5, '978-88-3341057'),
(1, '978-88-1445199'),
(2, '978-88-5667265'),
(3, '978-88-3678638'),
(4, '978-88-2458591'),
(7, '978-88-8038374'),
(8, '978-88-4668136'),
(8, '978-88-1533224');


INSERT INTO Utente (matricola, nome, cognome, indirizzo, telefono) VALUES
('196673', 'Emilio Nicola', 'Bruno', 'Incrocio Accardo 20 Piano 7, Opizzi lido, 01110 Grosseto (CN)', '+39 936 73972820'),
('139871', 'Dafne', 'Mundi', 'Canale Alphons 492 Piano 9, Merisi laziale, 19585 Bologna (CR)', '+39 5415 7567006'),
('147930', 'Filippo', 'Fantetti', 'Rotonda Lando 2, Pulci laziale, 59123 Verona (FR)', '+39 212 8705313'),
('120458', 'Vincenzo Ruggero', 'Petrini', 'Stretto Nicolò 7 Appartamento 68, Majorana lido, 56004 Trieste (PI)', '+39 35 8116281'),
('140512', 'Sara', 'Vanzo', 'Stretto Rosaria 726, Luigi calabro, 76140 Sondrio (FR)', '+39 280 2241526'),
('123238', 'Cinzia Maria', 'Perilli', 'Stretto Tonia 5, Gabrieli salentino, 78666 Salerno (CH)', '+39 8383 38404793'),
('159823', 'Hans', 'Pionati', 'Vicolo Adriano 6 Appartamento 17, Borgo Germana, 49697 Bolzano (NU)', '+39 8038 1823313'),
('146434', 'Gino', 'Tapparo', 'Piazza Jolanda 01 Piano 4, Raffaella umbro, 49907 Imperia (PZ)', '+39 625 7143732'),
('169429', 'Maria Teresa', 'La Loggia', 'Stretto Tamburello 1 Appartamento 75, Quarto Galasso umbro, 74680 Isernia (OR)', '+39 5808 5895827'),
('193320', 'Egidio Enrico', 'Turroni', 'Piazza Serafina 2 Appartamento 11, Sesto Loretta del friuli, 32707 Crotone (FR)', '+39 8190 6268417');


INSERT INTO CopiaLibro (id_copia, ISBN, succursale) VALUES
(1, '978-88-4668136', 'Fisica e Scienze della Terra'),
(2, '978-88-4668136', 'Matematica e Informatica'),
(3, '978-88-2458591', 'Scienze della Vita e Biotecnologie'),
(4, '978-88-1533224', 'Scienze Mediche'),
(5, '978-88-5614226', 'Scienze dell''Ambiente e della Prevenzione'),
(6, '978-88-3341057', 'Scienze Chimiche, Farmaceutiche ed Agrarie'),
(7, '978-88-2458591', 'Fisica e Scienze della Terra'),
(8, '978-88-8038374', 'Medicina Traslazionale e per la Romagna'),
(9, '978-88-1533224', 'Scienze della Vita e Biotecnologie'),
(10, '978-88-5667265', 'Giurisprudenza'),
(11, '978-88-4668136', 'Studi Umanistici'),
(12, '978-88-2867825', 'Giurisprudenza');


INSERT INTO Prestito (id_copia, matricola, data_uscita, data_restituzione_prevista) VALUES
(1, '123238', '2024-07-20', '2024-08-24'),
(5, '139871', '2025-05-20', '2025-06-12'),
(10, '123238', '2025-05-06', '2025-05-29'),
(11, '146434', '2024-10-08', '2024-11-12'),
(11, '146434', '2024-11-20', '2024-12-09'),
(5, '147930', '2024-10-13', '2024-11-07'),
(12, '169429', '2025-03-18', '2025-05-01'),
(5, '193320', '2024-10-01', '2024-11-07');
