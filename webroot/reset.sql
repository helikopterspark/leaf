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
    ('blogpost-3', null, 'post', 'Nu har hösten kommit', "Detta är en bloggpost som berättar att hösten har kommit, ett budskap som kräver en bloggpost", 'nl2br', NOW(), NOW(), 1),
    ('Kmom01', null, 'report', 'Kmom01', "Det första kursmomentet har löpt ganska smärtfritt eftersom jag precis har avslutat förra kursen och hade saker färskt i minnet. Det var dock en hel del att göra och tog längre tid än jag först trodde. Jag skummade igenom litteraturen eftersom jag läste kapitlen mer grundligt i höstas. Jag jobbade däremot igenom guiden \"20 steg...\" mer noggrant och det var en bra repetition. Det var kanske inget nytt men en del saker från förra kursen fick en bättre förklaring.\n\nSedan gav jag mig på Anax-artikeln och byggde upp mitt ramverk. Det fick heta Leaf, mest för att jag hade en lämplig ikon för loggan. Men också för att ordet också syftar på blad eller sidor. Jag har följt upplägget i artikeln eftersom det var rekommendationen inför kommande kursmoment.\n\nSkapandet av ramverket flöt på bra men det som orsakade en del huvudbry var den dynamiska menyn. Jag följde artikeln men fick tänka till lite för att anpassa koden till strukturen på sidorna i ramverket. Det fanns en följdartikel med en mer direkt passande lösning men nu försökte jag lösa det själv utifrån första exemplet. Jag lade in CNavigation som en klass eftersom det ändå ska handla om objektorientering i den här kursen. Det blev en fungerande lösning till slut. Kanske får jag revidera den senare, det återstår att se.\n\nJag lade in source.php som modul och det beredde inga problem. Jag lade in CSource genom att klona från Github. Funktionen dump() lade jag in i bootstrap.php enligt instruktion.\n\nJag lade även in JavaScript-delarna trots att de kunde hoppas över. Jag har dessutom skrivit in all kod för hand, då det är en inlärningsmetod som fungerat bra för mig. Med klipp och klistra missar man lätt detaljkollen på vad som händer i varje steg.\n\nJag gjorde även extrauppgiften med Github eftersom jag redan innan velat komma igång med att versionshantera min kod. Jag har erfarenhet av Subversion från ett tidigare jobb och versionshantering är ett krav i professionella sammanhang. Mitt Github-repo finns här: [url=https://github.com/helikopterspark/leaf.git']helikopterspark/leaf[/url].\n\nMin utvecklingsmiljö består av en Mac Mini med OS X 10.10.2, som alltid hålls uppdaterad till senaste OS-version. Jag kodar i NetBeans 8 och använder TextMate för att skriva rena textfiler. Jag började använda NetBeans i förra kursen och tycker att det funkar bra för mig. Jag testar löpande i Firefox men har Safari, Chrome och Opera installerade att testa med också. Sedan testar jag också hur sidorna ser ut i Ubuntu och Windows 7 via VMware Fusion. Jag kör XAMPP som webbserver och FileZilla för filöverföring. Jag använder Pixelmator för att fixa till bilder.", 'bbcode,nl2br', NOW(), NOW(), 2),
    ('Kmom02', null, 'report', 'Kmom02', "Kursmoment 2 blev en riktig långkörare. Jag läste igenom litteraturen och jobbade mig igenom oophp20-guiden. Jag har erfarenhet av objektorienterad programmering i C++ och Objective-C sedan tidigare så just den biten var inte svår att förstå och det var egentligen inget nytt. Däremot tog det lång tid att göra uppgifterna.\n\nDet som ständigt ger mig huvudbry är att man måste tänka på sidomladdningar hela tiden, vilket jag är ovan med. Men jag börjar väl vänja mig vid det nu och jag fick både tärningsspelet och kalendern att funka till slut.\n\nJag gav mig på tärningsspelet först och utgick ifrån klasserna som skapades i oophp20-guiden. Sedan skapade jag en klass för själva spelet och en klass för en spelare. Spelklassen är den som sköter all logik och den blev kanske lite rörig. Det finns nog utrymme för en del refactoring där.\n\nSpelet funkar iallafall, men det går att sabba spelet om man manuellt laddar om sidan. Tyvärr upptäckte jag detta lite för sent för att hinna skriva om koden. Men så länge spelaren sköter sig är det inga problem. Man kan gå ifrån sidan och komma tillbaka till den och fortsätta spelet därifrån man var. Det går att spela mot en mänsklig spelare eller upp till två datorspelare. Datorn försöker alltid få minst tio poäng och avgör sedan från kast till kast om den ska fortsätta kasta eller spara.\n\nTärningsspelet tog lång tid för mig att få till, så jag hade väldigt lite tid kvar till att göra kalendern och hann därför inte med alla extrauppgifterna. Det gick dock snabbare att få den här uppgiften att fungera.\n\nEn kalenderklass, CCalendar, bygger upp en sida genom att använda sig av en månadsklass, CCalendarMonth. En instans av denna klass skapas genom att skicka in månad och år. Utifrån dessa värden kollar den upp veckonummer i månaden och skapar en array med veckonumren. Med hjälp av denna array skriver den ut ingående dagar för respektive vecka. Den visar även veckonummer, söndagar, markerar dagens datum och gör datum utanför aktuell månad gråa och lite mindre. Varje månad visar en egen bild. Sidorna validerar korrekt i Unicorn vad jag kan se, vilket även gäller tärningsspelet.\n\nJag hade gärna fortsatt och gjort aside-kalendern, namnsdagar och fler helgdagar men tiden rann ut för att hinna lämna in i tid. I övrigt gjorde jag om redovisningssidan lite så att den laddar in separata filer för varje kursmoment och bygger även en länklista. Jag gjorde detta för att få lite mer överskådliga filer för redovisningssrapporterna.\n\nDet blev lite mastigt att göra bägge uppgifterna och en reflektion är att kalenderuppgiften nästan hade kunnat få vara ett eget kursmoment och då i samband med en databas för namnsdagar och helgdagar.\n\nTillägg: Jag korrigerade problemet med att det gick att ladda om sidan för att fuska.
", 'bbcode,nl2br', NOW(), NOW(), 2),
    ('Kmom03', null, 'report', 'Kmom03', "Kursmoment 3 kändes lugnare än det föregående. Mina tidigare erfarenheter av SQL och databaser bestod av att vi fick bekanta oss med SQLite och väldigt grundläggande SQL i förra kursen. Jag har även läst en kurs i databaser och datamodellering för längesedan. 1995 närmare bestämt och har inte datamodellerat sedan dess. Då var det MS Access vi använde som verktyg. Jag har vissa minnen av ER-diagram, entiteter, relationer, kardinaliteter och attribut, men har som sagt inte jobbat med det praktiskt. Jag har byggt några mindre datamodeller i Core Data för iPhone-appar men även om det är en SQLite-fil i bakgrunden så ligger det ett abstraktionslager ovanpå och man skriver inte SQL-frågor utan använder en annan syntax där. Det kändes bra att fräscha upp kunskaperna igen och det blir ännu bättre att få använda dem praktiskt i kommande kursmoment.\n\nJag började med att läsa litteraturen och testade sedan att starta de olika klienterna. När jag fått igång dessa lokalt så testade jag även att logga in på BTH-servern via alla tre klienterna, bara för att verifiera att det funkade. Det var dessbättre inga problem, anslutning och inloggning funkade bra.\n\nDet var inte speciellt svårt att genomföra övningarna den här gången. Jag gjorde övningarna lokalt på min dator för att kunna skapa en ny databas och radera den. Jag använde MySQL Workbench eftersom guiden använde den, och jag tycker att applikationen är rätt smidig och överskådlig för att snabbt kunna lägga upp tabeller och testa SQL-frågor. Jag hade dock lite problem med att applikationen hängde sig emellanåt när jag hade auto-complete påslaget.\n\nGuiden och litteraturen i form av boken Databasteknik och MySQL-manualen gav svaren på de smärre undringar jag hade. MySQL-manualen är kanske inte den mest lättlästa manualen som skrivits men den finns där som en hjälp i alla fall. Nytt för mig i det här kursmomentet vad gäller SQL var vyer och INNER och OUTER JOIN. Storage engine och teckenkodning likaså.", 'bbcode,nl2br', NOW(), NOW(), 2),
    ('Kmom04', null, 'report', 'Kmom04', "I det fjärde kursmomentet blev det mer att göra vad övningar beträffar. Jag gjorde övningen med filmdatabasen och den tog en bra stund att ta sig igenom. Den kändes ganska mastig måste jag säga men det är förstås bra med mängdträning plus att det säkert är användbara delar att gå tillbaka till när projektuppgiften ska göras. Jag gjorde även övningen med databasklassen, vilket gick snabbare.\n\nUppgiften gick ju egentligen ut på att ”objektifiera” den sista sidan från övningen och det gick betydligt snabbare och enklare än att göra själva övningen. Att jobba med PHP PDO känns bra och eftersom det ingick redan i förra kursen så var det egentligen inget nytt med det. Jag använde mig av undantagshantering redan där så den biten satt redan.\n\nJag valde att skapa två nya klasser enligt förslaget, CMovieSearch och CHTMLTable. Den förstnämnda hanterar kopplingen till databasen så att databasobjektet inte behöver anropas från sidkontrollern. Jag lade in hantering av genrer också även om det inte var ett krav. Jag valde även att baka in GET-variablerna och valideringen av dessa i klasserna, för att kapsla in så mycket som möjligt. Det resulterade i en väldigt slimmad sidkontroller.\n\nMan hade kanske kunnat tänka sig att samla allt i en och samma klass, eftersom dessa två klasser är beroende av varann. Nu har jag dessutom dubblerat metoden GetQueryString() i bägge klasserna. Jag tycker dock det känns lättare att hantera ett par mindre klasser än en stor.\n\nKlassen CUser och sidorna Login, Logout och Status gick snabbt och problemfritt att fixa. Sidorna ger lite olika utseende beroende på om användaren är inloggad eller inte.\n\nJag gjorde även extrauppgiften med dropdown-menyer. Jag uppdaterade klassen CNavigation för detta, så även denna lösning är objektorienterad. Det som strulade i detta moment var faktiskt CSS-filen där jag hade problem med att få menyvalen i submenyn att markeras korrekt. Det slutade med att jag tvingades använda !important på lämpliga ställen. Det är kanske ett litet nederlag men slutresultatet fungerar ju.\n\nKonceptet med klassmoduler är bra och känns naturligt efter att man har hållit på med objektorienterad programmering ett tag. Långa skript är svåra att överblicka och underhålla. Det blir enklare med klasser som man kan stycka upp i metoder. Men man kan ändå hålla ihop en viss funktionalitet i en samlad fil. Uppdatering, vidareutveckling och återanvändning blir då smidigare.
", 'bbcode,nl2br', NOW(), NOW(), 2),
    ('Kmom05', null, 'report', 'Kmom05', "Det börjar bli en del moduler i ramverket men det känns hanterbart. Det gäller förstås att namnge modulerna vettigt så att man direkt förstår vad de gör. Sidkontrollerna blir korta historier och det är förstås bra. Jag tycker det är relativt enkelt att dela upp koden i klasser och sidkontroller.\n\nEn sak som jag skulle vilja förbättra men som den tillgängliga tiden inte tillåtit är att se till att få bort hårdkokade referenser till specifika sidkontroller i klasserna. Det förekommer ibland i html-genereringen. Det skulle i så fall medföra lite mer logik i sidkontrollerna men det skulle minska direkta beroenden i klasserna. Klasserna är inte riktigt så generellt användbara som jag skulle önska utan är ofta väldigt specifika.\n\nJag jobbade mig igenom guiden och gjorde sedan övningen med CTextFilter. Jag gjorde även extrauppgifterna med typografi- och purifier-filtren. De finns nu med i min klass och används för blogginläggen. Jag tänkte även föreslå en förbättring med att lägga till code-taggen för bbcode2html för repot på Github men någon hade hunnit före mig där med precis samma förslag. En exempelsida för textfiltren finns under TextDB->Textfilter.\n\nDen mesta tiden gick åt till att koda klassen CContent. Här finns i princip all logik och den mesta html-genereringen. Jag gjorde extrauppgifterna med att koppla inlägg till en ägare i CUser och kategorier för blogginlägg. Det blev ett par extra tabeller. För att förenkla databasanropen och hålla ner antalet så skapade jag en vy, VContent, där relevanta kolumner från alla tabellerna är samlade. Merparten av frågorna kan ställas mot denna vy. Extrauppgiften med slugify gjorde jag också, slug skapas automatiskt om användaren inte fyller i något annat i slug-fältet.\n\nDet krävdes en del pill för att få alla properties att bli rätt. Klassen kan initiera tabeller i databasen genom att köra reset.sql mot databasen. Man kan lägga till och redigera innehåll. Jag rationaliserade bort create.php och låter edit.php sköta både nytt inlägg och uppdatering av befintligt. Det är en och samma metod som skapar rätt formulär för sammanhanget. För att förhindra inmatning av felaktiga värden så använde jag dropdown-listor för typ och kategori och checkboxar för filtren. Det blev lite kodhackande för att få checkboxarna att bockas av rätt när sidan laddar ett befintligt inlägg.\n\nNär man raderar ett inlägg så sätts det endast ett datum för raderat, så som guiden föreslog. Inlägget ligger m a o kvar i databasen men kommer inte att visas på bloggsidan eller i menyn. Sidkontrollen view.php (TextDB i menyn) visar en översikt över innehållet i databasen, inklusive raderade inlägg.\n\nKlassen CPage var det inga konstigheter med att få till och den blev ganska liten. Den ärver CContent och har bara en metod för att hämta innehåll.\n\nKlassen CBlog är snarlik och ärver också CContent. Den har bara en metod mer för att generera html. Publiceringsdatum visas för blogginläggen och när det eventuellt uppdaterats. Författare visas och varje inlägg kopplas till en kategori. Jag har dock inte vidareutvecklat kategorifunktionaliteten mer än så, men det är görbart eftersom kategoridata nu finns i databasen. Ett inlägg kan endast kopplas till en kategori. CContent och de ärvande klasserna skulle gå att använda för redovisningstexterna också, vilket jag kanske gör inför sista kursmomentet.\n\nSist men inte minst gjorde jag extrauppgiften med att förbättra navbaren. Den skapar nu undermenyer utifrån vad som finns i databasen så att varje inlägg visas som ett menyval. Klickar man t ex direkt på Blogg så får man en lista på alla inlägg. Väljer man sedan ett inlägg markeras toppvalet och även det inlägg som för tillfället visas. Det tog en stund att få detta att funka även om det egentligen bara blev några extra rader kod. Jag skrev två funktioner för detta (getNavbarArray och getLinkList), där den ena även kan användas för att skapa en html-lista av alla inlägg. Beroende på om man skickar in argument eller inte så får man ut olika form på resultatet.\n\nDet känns som att det finns en användbar grund i ramverket nu. Det som behöver byggas ut är användarhanteringen känner jag. Lägga till nya användare, begränsa uppdatering av inlägg till deras ägare, kanske olika nivåer etc. Jag sneglade på projektuppgiften och det verkar vara en extrauppgift där, så där kan jag kanske utveckla funktionaliteten mer.
", 'bbcode,nl2br', NOW(), NOW(), 2),
    ('Kmom06', null, 'report', 'Kmom06', "Sjätte kursmomentet var kanske det roligaste och har löpt smärtfritt. Jag läste igenom guiderna och gjorde sen objektorienterade lösningar av exemplen. Jag skapade klassen CImage och la in i princip all funktionalitet där. Sidkontrollern img.php är mycket kort och skapar bara CImage-objektet och anropar sedan klassens enda publika metod för att processa bilden.\n\nEfter att klarat av grundkraven så gjorde jag uppgiften med galleriet. Den gick snabbt att göra utan några egentliga problem. Det blev dock uppenbart att jag behövde kunna hantera transparenta bilder och därför fixade jag det i CImage-klassen. Jag gjorde även övriga extrauppgifter, dvs stöd för GIF-bilder och imagefilter. Jag gjorde en liknande lösning som i förlagan till CImage, dvs att klassen kan hantera alla tillgängliga filter och upp till 11 filter i en GET-query. Därefter blev det enkelt att fixa ett sepia-filter som shortcut också. Det är inte en lika sofistikerad lösning som förlagan med all dess felhantering men den funkar. Jag lade till en exempelsida under Galleri-menyn (Bildhantering) där några av filtren demonstreras i de fyra sista exemplen.\n\nYtterligare ett tillägg i detta moment som egentligen inte ingick var att jag lade in redovisningstexterna i databasen och plockar fram dem med hjälp av CContent-klassen plus en ärvd klass, CReport.\n\nJag hade begränsad erfarenhet av bildbehandling sedan tidigare, det som jag till nöds behövt göra med bilder i olika sammanhang. Förminska, förstora, beskära, spara i annat format etc. Färghantering och mer avancerade saker har jag inte sysslat med men skulle gärna lära mig mer om.\n\nPHP GD verkar enkelt att jobba med. Det är lätt att få till effekterna med filtren tycker jag. img.php kan nog vara ett bra verktyg och är enkel att lägga in när man väl vet hur den fungerar.\n\nEfter sista kursmomentet innan projektet så har ramverket fått en del klasser som jag hoppas går att återanvända. Jag befarar att klasserna är lite för specifika för uppgifterna i kursmomenten för att kunna användas mer generellt. Troligtvis kommer jag att få skriva om en del i projektet sedan. Men det känns enklare att skapa nya klasser nu när jag fått strukturen klarare för mig. Det ska förhoppningsvis gå bra att genomföra projektet med ramverket som grund. Jag saknar en lite mer avancerad hantering av användare och ska försöka få till det i projektet. Sedan kanske någon modul för uppspelning av media kunde vara trevlig att ha.", 'bbcode,nl2br', NOW(), NOW(), 2)
;

DELETE FROM Post2Category;
INSERT INTO Post2Category (idPost, idCategory) VALUES
(1,4),
(2,4),
(3,1),
(4,1),
(5,4),
(6,3),
(7,3),
(8,3),
(9,3),
(10,3),
(11,3);

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