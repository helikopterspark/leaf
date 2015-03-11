-- Skapa databas
CREATE DATABASE Skolan;

-- Välj vilken databas du vill använda
USE Skolan;

-- Radera en databas
DROP DATABASE Skolan;


--
-- Skapa tabell Lärare
--

CREATE TABLE Larare
(
	akronymLarare CHAR(3) PRIMARY KEY,
    avdelningLarare CHAR(3),
    namnLarare CHAR(20),
    lonLarare INT,
    foddLarare DATETIME
);

-- DROP TABLE Larare;

SELECT * FROM Larare;

--
-- Lägg till rader i tabellen Lärare
--
INSERT INTO Larare(akronymLarare, avdelningLarare, namnLarare, lonLarare, foddLarare) VALUES ('MOS', 'APS', 'Mikael', 15000, '1968-03-07');

--
-- Lägg till rader i tabellen Lärare
--
INSERT INTO Larare VALUES ('MOS', 'APS', 'Mikael', 15000, '1968-03-07');
INSERT INTO Larare VALUES ('MOL', 'AIS', 'Mats-Ola', 15000, '1978-12-07');
INSERT INTO Larare VALUES ('BBE', 'APS', 'Betty',    15000, '1968-07-07');
INSERT INTO Larare VALUES ('AJA', 'APS', 'Andreas',  15000, '1988-08-07');
INSERT INTO Larare VALUES ('CJH', 'APS', 'Conny',    15000, '1943-01-07');
INSERT INTO Larare VALUES ('CSA', 'APS', 'Charlie',  15000, '1969-04-07');
INSERT INTO Larare VALUES ('BHR', 'AIS', 'Birgitta', 15000, '1964-02-07');
INSERT INTO Larare VALUES ('MAP', 'APS', 'Marie',    15000, '1972-06-07');
INSERT INTO Larare VALUES ('LRA', 'APS', 'Linda',    15000, '1975-03-07');
INSERT INTO Larare VALUES ('ACA', 'APS', 'Anders',   15000, '1967-09-07');

--
-- Radera rader från en tabell
--
-- DELETE FROM Larare WHERE namnLarare = 'Mikael';
-- DELETE FROM Larare WHERE avdelningLarare = 'AIS';
-- DELETE FROM Larare LIMIT 2;
-- DELETE FROM Larare;

-- Ändra befintlig tabell
ALTER TABLE Larare ADD COLUMN kompetensLarare INT;

ALTER TABLE Larare DROP COLUMN kompetensLarare;

ALTER TABLE Larare ADD COLUMN kompetensLarare INT DEFAULT 5 NOT NULL;

--
-- Uppdatera ett värde
--
UPDATE Larare SET namnLarare = 'Charles' WHERE akronymLarare = 'CSA';

UPDATE Larare 
SET 
    lonLarare = 21000,
    kompetensLarare = 7
WHERE
    akronymLarare = 'MOS';
    
UPDATE Larare 
SET 
    lonLarare = lonLarare + 6000
WHERE
    akronymLarare = 'MOL';

UPDATE Larare 
SET 
    lonLarare = 21000,
    kompetensLarare = 9
WHERE
    akronymLarare = 'BBE';

UPDATE Larare
SET
	lonLarare = lonLarare - 1200
WHERE
	akronymLarare = 'AJA';

UPDATE Larare SET lonLarare = lonLarare * 1.10;
   
SELECT * FROM Larare WHERE avdelningLarare = 'AIS';
SELECT * FROM Larare WHERE akronymLarare LIKE 'M%';
SELECT * FROM Larare WHERE namnLarare LIKE '%o%';
SELECT * FROM Larare WHERE lonLarare >= 20000;
SELECT * FROM Larare WHERE lonLarare >= 20000 AND kompetensLarare > 5;
SELECT * FROM Larare WHERE akronymLarare IN ('MOL', 'MOS', 'BBE');

SELECT namnLarare, lonLarare FROM Larare;
SELECT namnLarare, lonLarare FROM Larare ORDER BY namnLarare ASC;
SELECT namnLarare, lonLarare FROM Larare ORDER BY namnLarare DESC;
SELECT namnLarare, lonLarare FROM Larare ORDER BY lonLarare ASC;
SELECT namnLarare, lonLarare FROM Larare ORDER BY lonLarare DESC;
SELECT namnLarare, lonLarare FROM Larare ORDER BY lonLarare DESC LIMIT 3;

--
-- Byt namn på kolumn
--
SELECT 
    namnLarare AS 'Lärare',
    avdelningLarare AS 'Avdelning',
    lonLarare AS 'Lön'
FROM
    Larare;

SELECT max(lonLarare) FROM Larare;
SELECT min(lonLarare) FROM Larare;

SELECT 
    COUNT(akronymLarare) AS Antal, avdelningLarare AS Avdelning
FROM
    Larare
GROUP BY avdelningLarare;

SELECT 
    SUM(lonLarare) AS Lön, avdelningLarare AS Avdelning
FROM
    Larare
GROUP BY avdelningLarare;

SELECT 
    AVG(lonLarare) AS Medellön, avdelningLarare AS Avdelning
FROM
    Larare
GROUP BY avdelningLarare;

--
-- SQL för att visa de avdelningar där snittlönen är över 18 000
--
SELECT avdelningLarare, AVG(lonLarare) AS Medellon
FROM Larare
GROUP BY avdelningLarare
HAVING AVG(lonLarare) > 18000;

--
-- SQL för att visa de vanligaste lönerna.
--
SELECT lonLarare, COUNT(lonLarare) AS Antal
FROM Larare
GROUP BY lonLarare
HAVING COUNT(lonLarare) > 1;

--
-- Sträng-funktioner
--
SELECT LOWER(CONCAT(avdelningLarare, '/', akronymLarare)) FROM Larare;

--
-- Datum/tid-funktioner
--
SELECT now();

SELECT LOWER(CONCAT(avdelningLarare, '/', akronymLarare)) AS avd_akr, now(), date_format(foddLarare, '%Y') AS Födelseår FROM Larare;

SELECT akronymLarare, now(), UTC_DATE(), YEAR(foddLarare) FROM Larare;

-- Beräkna ålder v1
SELECT 
    akronymLarare AS Lärare,
    YEAR(foddLarare) AS Födelseår,
    YEAR(NOW()) - YEAR(foddLarare) AS Ålder
FROM
    Larare
ORDER BY Ålder DESC;

-- Beräkna ålder v2
SELECT 
    akronymLarare AS Lärare,
    YEAR(foddLarare) AS Födelseår,
    TIMESTAMPDIFF(YEAR,
        foddLarare,
        CURDATE()) AS Ålder
FROM
    Larare
ORDER BY Ålder DESC;

--
-- Vyer
--
CREATE VIEW VLarare AS
    SELECT 
        akronymLarare AS Lärare,
        YEAR(foddLarare) AS Födelseår,
        TIMESTAMPDIFF(YEAR,
            foddLarare,
            CURDATE()) AS Ålder
    FROM
        Larare
    ORDER BY Ålder DESC;
    
SELECT AVG(Ålder) FROM VLarare;

DROP VIEW VLarare;

-- 11.2 Vy med Larare, * och Ålder
CREATE VIEW VLarare2 AS
    SELECT 
        *,
        TIMESTAMPDIFF(YEAR,
            foddLarare,
            CURDATE()) AS Ålder
    FROM
        Larare;
        
SELECT 
    avdelningLarare AS Avdelning,
    ROUND(AVG(Ålder)) AS Medelålder,
    ROUND(AVG(lonLarare)) AS Medellön
FROM
    VLarare2
GROUP BY avdelningLarare;

-- 11.3 Vy baserad på vy
CREATE VIEW VAvdelningsRapport AS
SELECT 
    avdelningLarare AS Avdelning,
    ROUND(AVG(Ålder)) AS Medelålder,
    ROUND(AVG(lonLarare)) AS Medellön
FROM
    VLarare2
GROUP BY avdelningLarare;

SELECT * FROM VAvdelningsRapport;

--
-- 12 JOIN m m
--
CREATE TABLE Kurs
(
	kodKurs CHAR(6) PRIMARY KEY NOT NULL,
    namnKurs CHAR(40),
    poangKurs FLOAT
) ENGINE = INNODB CHARACTER SET utf8;

--
-- Skapa tabell med constraint foreign key
--
CREATE TABLE Kurstillfalle
(
	idKurstillfalle INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    Kurstillfalle_kodKurs CHAR(6) NOT NULL,
    Kurstillfalle_akronymLarare CHAR(3) NOT NULL,
    lasperiodKurstillfalle INT NOT NULL,
    FOREIGN KEY (Kurstillfalle_kodKurs) REFERENCES Kurs(kodKurs)
) ENGINE = INNODB CHARACTER SET utf8;

SET NAMES 'utf8';

--
-- 12.6 Lägg till rader
--
INSERT INTO Kurs(kodKurs, namnKurs, poangKurs) VALUES ('DV1106', 'Databasteknik och Webbapps', 7.5);
INSERT INTO Kurs(kodKurs, namnKurs, poangKurs) VALUES ('DV1219', 'Databasteknik', 7.5);
INSERT INTO Kurs(kodKurs, namnKurs, poangKurs) VALUES ('PA1106', 'Individuellt Projekt', 7.5);

INSERT INTO Kurstillfalle(Kurstillfalle_kodKurs, Kurstillfalle_akronymLarare, lasperiodKurstillfalle) VALUES ('DV1106', 'MOS', 1);
INSERT INTO Kurstillfalle(Kurstillfalle_kodKurs, Kurstillfalle_akronymLarare, lasperiodKurstillfalle) VALUES ('DV1106', 'MOS', 4);
INSERT INTO Kurstillfalle(Kurstillfalle_kodKurs, Kurstillfalle_akronymLarare, lasperiodKurstillfalle) VALUES ('DV1219', 'CJH', 2);
INSERT INTO Kurstillfalle(Kurstillfalle_kodKurs, Kurstillfalle_akronymLarare, lasperiodKurstillfalle) VALUES ('DV1219', 'MOS', 3);
INSERT INTO Kurstillfalle(Kurstillfalle_kodKurs, Kurstillfalle_akronymLarare, lasperiodKurstillfalle) VALUES ('PA1106', 'MOL', 1);
INSERT INTO Kurstillfalle(Kurstillfalle_kodKurs, Kurstillfalle_akronymLarare, lasperiodKurstillfalle) VALUES ('PA1106', 'BBE', 2);

SELECT * FROM Kurs;
SELECT * FROM Kurstillfalle;

--
-- En crossjoin
--
SELECT * FROM Kurs, Kurstillfalle;

--
-- Joina två tabeller, använd alias för att korta ned SQL-satsen
--
SELECT * FROM Kurs AS K, Kurstillfalle AS Kt WHERE K.kodKurs = Kt.Kurstillfalle_kodKurs;

CREATE VIEW VKurstillfallen AS
SELECT * FROM Kurs AS K, Kurstillfalle AS Kt WHERE K.kodKurs = Kt.Kurstillfalle_kodKurs;

SELECT * FROM VKurstillfallen;

CREATE VIEW VKursinfo AS
SELECT * FROM VKurstillfallen, VLarare2 WHERE Kurstillfalle_akronymLarare = akronymLarare;

SELECT * FROM VKursinfo;

--
-- 12.9 Inner join av samtliga tabeller.
--
SELECT 
    K.kodKurs AS Kurskod,
    K.namnKurs AS Kursnamn,
    Kt.lasperiodKurstillfalle AS Läsperiod,
    CONCAT(L.namnLarare, ' (', L.akronymLarare, ')') AS Kursansvarig
FROM
    Kurstillfalle AS Kt
        INNER JOIN
    Kurs AS K ON Kt.Kurstillfalle_kodKurs = K.kodKurs
        INNER JOIN
    Larare AS L ON Kt.Kurstillfalle_akronymLarare = L.akronymLarare
ORDER BY K.kodKurs;

--
-- 13 Joinade tabeller
--

-- Medelålder på PA1106
SELECT 
    Kurs.kodKurs AS Kurskod,
    ROUND(AVG(VLarare2.Ålder)) AS Medelålder
FROM
    Kurstillfalle
        INNER JOIN
    Kurs ON Kurstillfalle.Kurstillfalle_kodKurs = Kurs.kodKurs
        INNER JOIN
    VLarare2 ON Kurstillfalle.Kurstillfalle_akronymLarare = VLarare2.akronymLarare
WHERE
    Kurs.kodKurs = 'PA1106'
ORDER BY Kurstillfalle.Kurstillfalle_kodKurs;

-- Medellön på PA%
SELECT 
    Kurs.kodKurs AS Kurskod,
    ROUND(AVG(VLarare2.lonLarare)) AS Medellön
FROM
    Kurstillfalle
        INNER JOIN
    Kurs ON Kurstillfalle.Kurstillfalle_kodKurs = Kurs.kodKurs
        INNER JOIN
    VLarare2 ON Kurstillfalle.Kurstillfalle_akronymLarare = VLarare2.akronymLarare
WHERE
    Kurs.kodKurs LIKE 'PA%'
GROUP BY Kurstillfalle.Kurstillfalle_kodKurs;

--
-- Hur många kurstillfällen har lärarna?
--
CREATE VIEW VVAntalKATillfallen AS
    SELECT 
        akronymLarare, COUNT(akronymLarare) AS Antal
    FROM
        VKursinfo
    GROUP BY akronymLarare;
    
SELECT * FROM VVAntalKATillfallen;
SELECT MAX(Antal) FROM VVAntalKATillfallen;

-- SVAR = 3
 
SELECT 
    *
FROM
    VVAntalKATillfallen
WHERE
    Antal = 3;
    
--
-- En fråga med en subquery
--
SELECT 
    *
FROM
    VVAntalKATillfallen
WHERE
    Antal = (SELECT 
            MAX(Antal)
        FROM
            VVAntalKATillfallen);
		
-- Minst antal kurstillfällen
SELECT 
    *
FROM
    VVAntalKATillfallen
WHERE
    Antal = (SELECT 
            MIN(Antal)
        FROM
            VVAntalKATillfallen);

--
-- Skapa kurs utan kurstillfälle och gör inner join mot tabell för kurstillfällen.
--
INSERT INTO Kurs VALUES ('DV1207', 'Db och Webb2', 7.5);
SELECT * FROM Kurs;

SELECT 
    K.kodKurs AS Kurskod,
    K.namnKurs AS Kursnamn,
    Kt.lasperiodKurstillfalle AS Läsperiod
FROM
    Kurstillfalle AS Kt
        RIGHT OUTER JOIN
    Kurs AS K ON Kt.Kurstillfalle_kodKurs = K.kodKurs
ORDER BY K.kodKurs;