<?php

// Report for kmom04
$html = <<<EOD
	<h2 id='Kmom04'>Kmom04</h2>
	<div class='article_text'>
 		<p>I det fjärde kursmomentet blev det mer att göra vad övningar beträffar. Jag gjorde övningen med filmdatabasen och den tog en bra stund att ta sig igenom. Den kändes ganska mastig måste jag säga men det är förstås bra med mängdträning plus att det säkert är användbara delar att gå tillbaka till när projektuppgiften ska göras. Jag gjorde även övningen med databasklassen, vilket gick snabbare.</p>
		<p>Uppgiften gick ju egentligen ut på att ”objektifiera” den sista sidan från övningen och det gick betydligt snabbare och enklare än att göra själva övningen. Att jobba med PHP PDO känns bra och eftersom det ingick redan i förra kursen så var det egentligen inget nytt med det. Jag använde mig av undantagshantering redan där så den biten satt redan.</p>
		<p>Jag valde att skapa två nya klasser enligt förslaget, CMovieSearch och CHTMLTable. Den förstnämnda hanterar kopplingen till databasen så att databasobjektet inte behöver anropas från sidkontrollern. Jag lade in hantering av genrer också även om det inte var ett krav. Jag valde även att baka in GET-variablerna och valideringen av dessa i klasserna, för att kapsla in så mycket som möjligt. Det resulterade i en väldigt slimmad sidkontroller.</p>
		<p>Man hade kanske kunnat tänka sig att samla allt i en och samma klass, eftersom dessa två klasser är beroende av varann. Nu har jag dessutom dubblerat metoden GetQueryString() i bägge klasserna. Jag tycker dock det känns lättare att hantera ett par mindre klasser än en stor.</p>
		<p>Klassen CUser och sidorna Login, Logout och Status gick snabbt och problemfritt att fixa. Sidorna ger lite olika utseende beroende på om användaren är inloggad eller inte.</p>
		<p>Jag gjorde även extrauppgiften med dropdown-menyer. Jag uppdaterade klassen CNavigation för detta, så även denna lösning är objektorienterad. Det som strulade i detta moment var faktiskt CSS-filen där jag hade problem med att få menyvalen i submenyn att markeras korrekt. Det slutade med att jag tvingades använda <code>!important</code> på lämpliga ställen. Det är kanske ett litet nederlag men slutresultatet fungerar ju.</p>
		<p>Konceptet med klassmoduler är bra och känns naturligt efter att man har hållit på med objektorienterad programmering ett tag. Långa skript är svåra att överblicka och underhålla. Det blir enklare med klasser som man kan stycka upp i metoder. Men man kan ändå hålla ihop en viss funktionalitet i en samlad fil. Uppdatering, vidareutveckling och återanvändning blir då smidigare.</p>
 	</div>
 	<div style="text-align:center;">
 	<p><a href="#">Upp</a></p>
 	</div><hr>
EOD;

$leaf['reports'] .= $html;
