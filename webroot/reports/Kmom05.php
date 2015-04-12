<?php

// Report for kmom05
$html = <<<EOD
	<h2 id='Kmom05'>Kmom05</h2>
	<div class='article_text'>
 		<p>Det börjar bli en del moduler i ramverket men det känns hanterbart. Det gäller förstås att namnge modulerna vettigt så att man direkt förstår vad de gör. Sidkontrollerna blir korta historier och det är förstås bra. Jag tycker det är relativt enkelt att dela upp koden i klasser och sidkontroller.</p>

<p>En sak som jag skulle vilja förbättra men som den tillgängliga tiden inte tillåtit är att se till att få bort hårdkokade referenser till specifika sidkontroller i klasserna. Det förekommer ibland i html-genereringen. Det skulle i så fall medföra lite mer logik i sidkontrollerna men det skulle minska direkta beroenden i klasserna. Klasserna är inte riktigt så generellt användbara som jag skulle önska utan är ofta väldigt specifika.</p>

<p>Jag jobbade mig igenom guiden och gjorde sedan övningen med CTextFilter. Jag gjorde även extrauppgifterna med typografi- och purifier-filtren. De finns nu med i min klass och används för blogginläggen. Jag tänkte även föreslå en förbättring med att lägga till code-taggen för bbcode2html för repot på Github men någon hade hunnit före mig där med precis samma förslag. En exempelsida för textfiltren finns under TextDB->Textfilter.</p>

<p>Den mesta tiden gick åt till att koda klassen CContent. Här finns i princip all logik och den mesta html-genereringen. Jag gjorde extrauppgifterna med att koppla inlägg till en ägare i CUser och kategorier för blogginlägg. Det blev ett par extra tabeller. För att förenkla databasanropen och hålla ner antalet så skapade jag en vy, VContent, där relevanta kolumner från alla tabellerna är samlade. Merparten av frågorna kan ställas mot denna vy. Extrauppgiften med slugify gjorde jag också, slug skapas automatiskt om användaren inte fyller i något annat i slug-fältet.</p>

<p>Det krävdes en del pill för att få alla properties att bli rätt. Klassen kan initiera tabeller i databasen genom att köra reset.sql mot databasen. Man kan lägga till och redigera innehåll. Jag rationaliserade bort create.php och låter edit.php sköta både nytt inlägg och uppdatering av befintligt. Det är en och samma metod som skapar rätt formulär för sammanhanget. För att förhindra inmatning av felaktiga värden så använde jag dropdown-listor för typ och kategori och checkboxar för filtren. Det blev lite kodhackande för att få checkboxarna att bockas av rätt när sidan laddar ett befintligt inlägg.</p>

<p>När man raderar ett inlägg så sätts det endast ett datum för raderat, så som guiden föreslog. Inlägget ligger m a o kvar i databasen men kommer inte att visas på bloggsidan eller i menyn. Sidkontrollen view.php (TextDB i menyn) visar en översikt över innehållet i databasen, inklusive raderade inlägg.</p>

<p>Klassen CPage var det inga konstigheter med att få till och den blev ganska liten. Den ärver CContent och har bara en metod för att hämta innehåll.</p>

<p>Klassen CBlog är snarlik och ärver också CContent. Den har bara en metod mer för att generera html. Publiceringsdatum visas för blogginläggen och när det eventuellt uppdaterats. Författare visas och varje inlägg kopplas till en kategori. Jag har dock inte vidareutvecklat kategorifunktionaliteten mer än så, men det är görbart eftersom kategoridata nu finns i databasen. CContent och de ärvande klasserna skulle gå att använda för redovisningstexterna också, vilket jag kanske gör inför sista kursmomentet.</p>

<p>Sist men inte minst gjorde jag extrauppgiften med att förbättra navbaren. Den skapar nu undermenyer utifrån vad som finns i databasen så att varje inlägg visas som ett menyval. Klickar man t ex direkt på Blogg så får man en lista på alla inlägg. Väljer man sedan ett inlägg markeras toppvalet och även det inlägg som för tillfället visas. Det tog en stund att få detta att funka även om det egentligen bara blev några extra rader kod. Jag skrev två funktioner för detta (getNavbarArray och getLinkList), där den ena även kan användas för att skapa en html-lista av alla inlägg. Beroende på om man skickar in argument eller inte så får man ut olika resultat.</p>

<p>Det känns som att det finns en användbar grund i ramverket nu. Det som behöver byggas ut är användarhanteringen känner jag. Lägga till nya användare, begränsa uppdatering av inlägg till deras ägare, kanske olika nivåer etc. Jag sneglade på projektuppgiften och det verkar vara en extrauppgift där, så där kan jag kanske utveckla funktionaliteten mer.</p>
 	</div>
 	<div style="text-align:center;">
 	<p><a href="#">Upp</a></p>
 	</div><hr>
EOD;

$leaf['reports'] .= $html;
