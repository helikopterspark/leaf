<?php
// Report for kmom02
$html = <<<EOD
	<h2 id='Kmom02'>Kmom02</h2><div class='article_text'>
 	<p>Det första kursmomentet har löpt ganska smärtfritt eftersom jag precis har avslutat förra kursen och hade saker färskt i minnet. Det var dock en hel del att göra och tog längre tid än jag först trodde. Jag skummade igenom litteraturen eftersom jag läste kapitlen mer grundligt i höstas. Jag jobbade däremot igenom guiden "20 steg..." mer noggrant och det var en bra repetition. Det var kanske inget nytt men en del saker från förra kursen fick en bättre förklaring.</p>
	<p>Sedan gav jag mig på Anax-artikeln och byggde upp mitt ramverk. Det fick heta Leaf, mest för att jag hade en lämplig ikon för loggan. Men också för att ordet också syftar på blad eller sidor. Jag har följt upplägget i artikeln eftersom det var rekommendationen inför kommande kursmoment.</p>
	<p>Skapandet av ramverket flöt på bra men det som orsakade en del huvudbry var den dynamiska menyn. Jag följde artikeln men fick tänka till lite för att anpassa koden till strukturen på sidorna i ramverket. Det fanns en följdartikel med en mer direkt passande lösning men nu försökte jag lösa det själv utifrån första exemplet. Jag lade in CNavigation som en klass eftersom det ändå ska handla om objektorientering i den här kursen. Det blev en fungerande lösning till slut. Kanske får jag revidera den senare, det återstår att se.</p>
	<p>Jag lade in source.php som modul och det beredde inga problem. Jag lade in CSource genom att klona från Github. Funktionen dump() lade jag in i bootstrap.php enligt instruktion.</p>
	<p>Jag lade även in JavaScript-delarna trots att de kunde hoppas över. Jag har dessutom skrivit in all kod för hand, då det är en inlärningsmetod som fungerat bra för mig. Med klipp och klistra missar man lätt detaljkollen på vad som händer i varje steg.</p>
	<p>Jag gjorde även extrauppgiften med Github eftersom jag redan innan velat komma igång med att versionshantera min kod. Jag har erfarenhet av Subversion från ett tidigare jobb och versionshantering är ett krav i professionella sammanhang. Mitt Github-repo finns här: <a href='https://github.com/helikopterspark/leaf.git'>helikopterspark/leaf</a>.</p>
	<p>Min utvecklingsmiljö består av en Mac Mini med OS X 10.10.2, som alltid hålls uppdaterad till senaste OS-version. Jag kodar i NetBeans 8 och använder TextMate för att skriva rena textfiler. Jag började använda NetBeans i förra kursen och tycker att det funkar bra för mig. Jag testar löpande i Firefox men har Safari, Chrome och Opera installerade att testa med också. Sedan testar jag också hur sidorna ser ut i Ubuntu och Windows 7 via VMware Fusion. Jag kör XAMPP som webbserver och FileZilla för filöverföring. Jag använder Pixelmator för att fixa till bilder.</p>
 	</div>
 	<div style="text-align:center;">
 	<p><a href="#">Upp</a></p>
 	</div><hr>
EOD;

$leaf['reports'] .= $html;