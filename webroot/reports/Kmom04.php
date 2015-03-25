<?php

// Report for kmom04
$html = <<<EOD
	<h2 id='Kmom04'>Kmom04</h2>
	<div class='article_text'>
 	<p>Kursmoment 3 kändes lugnare än det föregående. Mina tidigare erfarenheter av SQL och databaser bestod av att vi fick bekanta oss med SQLite och väldigt grundläggande SQL i förra kursen. Jag har även läst en kurs i databaser och datamodellering för längesedan. 1995 närmare bestämt och har inte datamodellerat sedan dess. Då var det MS Access vi använde som verktyg. Jag har vissa minnen av ER-diagram, entiteter, relationer, kardinaliteter och attribut, men har som sagt inte jobbat med det praktiskt. Jag har byggt några mindre datamodeller i Core Data för iPhone-appar men även om det är en SQLite-fil i bakgrunden så ligger det ett abstraktionslager ovanpå och man skriver inte SQL-frågor utan använder en annan syntax där. Det kändes bra att fräscha upp kunskaperna igen och det blir ännu bättre att få använda dem praktiskt i kommande kursmoment.</p>
        <p>Jag började med att läsa litteraturen och testade sedan att starta de olika klienterna. När jag fått igång dessa lokalt så testade jag även att logga in på BTH-servern via alla tre klienterna, bara för att verifiera att det funkade. Det var dessbättre inga problem, anslutning och inloggning funkade bra.</p>
        <p>Det var inte speciellt svårt att genomföra övningarna den här gången. Jag gjorde övningarna lokalt på min dator för att kunna skapa en ny databas och radera den. Jag använde MySQL Workbench eftersom guiden använde den, och jag tycker att applikationen är rätt smidig och överskådlig för att snabbt kunna lägga upp tabeller och testa SQL-frågor. Jag hade dock lite problem med att applikationen hängde sig emellanåt när jag hade auto-complete påslaget.</p>
        <p>Guiden och litteraturen i form av boken Databasteknik och MySQL-manualen gav svaren på de smärre undringar jag hade. MySQL-manualen är kanske inte den mest lättlästa manualen som skrivits men den finns där som en hjälp i alla fall. Nytt för mig i det här kursmomentet vad gäller SQL var vyer och INNER och OUTER JOIN. Storage engine och teckenkodning likaså.</p>
 	</div>
 	<div style="text-align:center;">
 	<p><a href="#">Upp</a></p>
 	</div><hr>
EOD;

$leaf['reports'] .= $html;
