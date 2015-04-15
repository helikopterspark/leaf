-- CREATE DATABASE IF NOT EXISTS Kmom05oophp;

USE Kmom05oophp;
-- USE carb14;

SET NAMES 'utf8';

--
-- Create table for Content
--

DROP TABLE IF EXISTS Post2Category;
DROP TABLE IF EXISTS Content;
CREATE TABLE Content
(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    slug CHAR(80) UNIQUE,
    url CHAR(80) UNIQUE,

    type CHAR(80),
    title VARCHAR(80),
    data TEXT,
    filter CHAR(80),

    published DATETIME,
    created DATETIME,
    updated DATETIME,
    deleted DATETIME

) ENGINE INNODB CHARACTER SET utf8;

DROP TABLE IF EXISTS Category;
CREATE TABLE Category
(
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	name CHAR(20) NOT NULL -- diverse, redovisning, nyheter, etc
) ENGINE INNODB CHARACTER SET utf8;

DROP TABLE IF EXISTS Post2Category;
CREATE TABLE Post2Category
(
	idPost INT NOT NULL,
	idCategory INT NOT NULL,

	FOREIGN KEY (idPost) REFERENCES Content (id),
	FOREIGN KEY (idCategory) REFERENCES Category (id),

	PRIMARY KEY (idPost, idCategory)
) ENGINE INNODB;

DELETE FROM Category;
INSERT INTO Category (name) VALUES 
	('Nyheter'), ('Tänkvärt'), ('Redovisning'), ('Diverse');

--
-- Table for user
--
DROP TABLE IF EXISTS USER;

CREATE TABLE USER
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    acronym CHAR(12) UNIQUE NOT NULL,
    name VARCHAR(80),
    password CHAR(32),
    salt INT NOT NULL
) ENGINE INNODB CHARACTER SET utf8;

INSERT INTO USER (acronym, name, salt) VALUES 
    ('doe', 'John/Jane Doe', unix_timestamp()),
    ('admin', 'Administrator', unix_timestamp())
;

UPDATE USER SET password = md5(concat('doe', salt)) WHERE acronym = 'doe';
UPDATE USER SET password = md5(concat('admin', salt)) WHERE acronym = 'admin';

ALTER TABLE Content ADD COLUMN Content_userId INT;
ALTER TABLE Content ADD FOREIGN KEY (Content_userId) REFERENCES USER(id);

DELETE FROM Content;
INSERT INTO Content (slug, url, type, title, data, filter, published, created, Content_userId) VALUES
    ('hem', 'hem', 'page', 'Hem', "Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter 'nl2br' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.", 'bbcode,nl2br', NOW(), NOW(), 1),
    ('om', 'om', 'page', 'Om', "Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.", 'markdown', NOW(), NOW(), 1),
    ('blogpost-1', null, 'post', 'Välkommen till min blogg!', "Detta är en bloggpost.\n\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.", 'link,nl2br', NOW(), NOW(), 1),
    ('blogpost-2', null, 'post', 'Nu har sommaren kommit', "Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.", 'nl2br', NOW(), NOW(), 1),
    ('blogpost-3', null, 'post', 'Nu har hösten kommit', "Detta är en bloggpost som berättar att hösten har kommit, ett budskap som kräver en bloggpost", 'nl2br', NOW(), NOW(), 1)
;

DELETE FROM Post2Category;
INSERT INTO Post2Category (idPost, idCategory) VALUES
(1,4),
(2,4),
(3,1),
(4,1),
(5,4);

-- SELECT * FROM Content;
-- SELECT * FROM USER;
-- SELECT * FROM Category;
-- SELECT * FROM Post2Category;

--
-- Create view for Content with joined tables USER and Category
--
DROP VIEW IF EXISTS VContent;
CREATE VIEW VContent
AS
SELECT Content.*, USER.name AS UserName, Category.id AS CategoryID, Category.name AS CategoryName
FROM Content
LEFT OUTER JOIN USER ON USER.id = Content.Content_userId
LEFT OUTER JOIN Post2Category ON Post2Category.idPost = Content.id
LEFT OUTER JOIN Category ON Category.id = Post2Category.idCategory
GROUP BY Content.id;
