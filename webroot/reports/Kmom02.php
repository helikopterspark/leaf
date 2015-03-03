<?php

// Report for kmom02
$html = <<<EOD
	<h2 id='Kmom02'>Kmom02</h2>
	<div class='article_text'>
 	<p>Kursmoment 2 blev en riktig långkörare. Jag läste igenom litteraturen och jobbade mig igenom oophp20-guiden. Jag har erfarenhet av objektorienterad programmering i C++ och Objective-C sedan tidigare så just den biten var inte svår att förstå och det var egentligen inget nytt. Däremot tog det lång tid att göra uppgifterna.</p>
        <p>Det som ständigt ger mig huvudbry är att man måste tänka på sidomladdningar hela tiden, vilket jag är ovan med. Men jag börjar väl vänja mig vid det nu och jag fick både tärningsspelet och kalendern att funka till slut.</p>
        <p>Jag gav mig på tärningsspelet först och utgick ifrån klasserna som skapades i oophp20-guiden. Sedan skapade jag en klass för själva spelet och en klass för en spelare. Spelklassen är den som sköter all logik och den blev kanske lite rörig. Det finns nog utrymme för en del refactoring där.</p>
        <p>Spelet funkar iallafall, men det går att sabba spelet om man manuellt laddar om sidan. Tyvärr upptäckte jag detta lite för sent för att hinna skriva om koden. Men så länge spelaren sköter sig är det inga problem. Man kan gå ifrån sidan och komma tillbaka till den och fortsätta spelet därifrån man var. Det går att spela mot en mänsklig spelare eller upp till två datorspelare. Datorn försöker alltid få minst tio poäng och avgör sedan från kast till kast om den ska fortsätta kasta eller spara.</p>
        <p>Tärningsspelet tog lång tid för mig att få till, så jag hade väldigt lite tid kvar till att göra kalendern och hann därför inte med alla extrauppgifterna. Det gick dock snabbare att få den här uppgiften att fungera.</p>
        <p>En kalenderklass, CCalendar, bygger upp en sida genom att använda sig av en månadsklass, CCalendarMonth. En instans av denna klass skapas genom att skicka in månad och år. Utifrån dessa värden kollar den upp veckonummer i månaden och skapar en array med veckonumren. Med hjälp av denna array skriver den ut ingående dagar för respektive vecka. Den visar även veckonummer, söndagar, markerar dagens datum och gör datum utanför aktuell månad gråa och lite mindre. Varje månad visar en egen bild. Sidorna validerar korrekt i Unicorn vad jag kan se, vilket även gäller tärningsspelet.</p>
        <p>Jag hade gärna fortsatt och gjort aside-kalendern, namnsdagar och fler helgdagar men tiden rann ut för att hinna lämna in i tid. I övrigt gjorde jag om redovisningssidan lite så att den laddar in separata filer för varje kursmoment och bygger även en länklista. Jag gjorde detta för att få lite mer överskådliga filer för redovisningssrapporterna.</p>
        <p>Det blev lite mastigt att göra bägge uppgifterna och en reflektion är att kalenderuppgiften nästan hade kunnat få vara ett eget kursmoment och då i samband med en databas för namnsdagar och helgdagar.</p>
        <p>Tillägg: Jag korrigerade problemet med att det gick att ladda om sidan för att fuska.</p>
 	</div>
 	<div style="text-align:center;">
 	<p><a href="#">Upp</a></p>
 	</div><hr>
EOD;

$leaf['reports'] .= $html;
