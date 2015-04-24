<?php
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 




// Do it and store it all in variables in the Anax container.
$leaf['title'] = "Exempel på hantering av bilder med img.php";

$leaf['main'] = <<<EOD
<h1>{$leaf['title']}</h1>

<h2>Orginalbilden</h2>

<p>Så här ser orginalbilden ut, oförvanskad i sitt originalutförande. Bilden är i PNG-format och filstorleken är 589KB.</p>

<code>&lt;img src="img/kodim15.png" alt="Flicka, exempelbild från Kodak"/&gt;</code>

<img src="img/kodim15.png" alt="Flicka, exempelbild från Kodak"/>



<h2>Visa bilden med img.php</h2>

<p>Så här ser bilden ut när den visas upp, oförvanskad i img.php, det är alltså exakt samma källbild, men nu levereras den av PHP.</p>

<code>&lt;img src="img.php?src=kodim15.png&verbose" alt="Flicka, exempelbild från Kodak"/&gt;</code>

<img src="img.php?src=kodim15.png" alt="Flicka, exempelbild från Kodak"/>



<h2>Spara bilden som JPEG</h2>

<p>Denna bilden är omvandlad och sparad i JPEG-format i en cachad variant av bilden med kvalitetsfaktorn 40, resultatet blir en bild som är 1/20-del av orginalbildens storlek med liknande upplevd kvalitet.</p>

<code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&quality=40" alt="Flicka, exempelbild från Kodak"/&gt;</code>

<img src="img.php?src=kodim15.png&save-as=jpg&quality=40" alt="Flicka, exempelbild från Kodak"/>



<h2>Förminska bilden</h2>

<p>Här är bild som nu är 400 pixlar bred. Höjden räknas ut.</p>

<code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&width=400" alt="Flicka, 400 pixlar bred"/&gt;</code>

<img src="img.php?src=kodim15.png&save-as=jpg&width=400" alt="Flicka, 400 pixlar bred"/>



<p>Här är bilden som nu är 200 pixlar hög. Bredden räknas ut.</p>

<code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&height=200" alt="Flicka, 200 pixlar hög"/&gt;</code>

<img src="img.php?src=kodim15.png&save-as=jpg&height=200" alt="Flicka, 200 pixlar hög"/>



<p>Här är bilden som nu passar in i en tänkt ruta om max 200 pixlars bredd och höjd. Ingen del av bilden får gå utanför rutan och bildens storleksförhållande mellan bredd och höjd behålls.</p>

<code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&width=200&height=200" alt="Flicka, i en rutan om 200 pixlar"/&gt;</code>

<img src="img.php?src=kodim15.png&save-as=jpg&width=200&height=200" alt="Flicka, i en rutan om 200 pixlar"/>



<h2>Passa in bilden och ta bort resten</h2>

<p>Här är bilden som nu passar in i en tänkt ruta om max 200 pixlars bredd och höjd. Bilden är beskuren för att få plats i rutan.</p>

<code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&width=200&height=200&crop-to-fit" alt="Flicka, i en rutan om 200 pixlar"/&gt;</code>

<img src="img.php?src=kodim15.png&save-as=jpg&width=200&height=200&crop-to-fit" alt="Flicka, i en rutan om 200 pixlar"/>


<p>Nu är bilden beskuren för att passa in i en ruta om bredd 100px och höjd 200px.</p>

<code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&width=100&height=200&crop-to-fit" alt="Flicka, i en rutan om 100x200 pixlar"/&gt;</code>

<img src="img.php?src=kodim15.png&save-as=jpg&width=100&height=200&crop-to-fit" alt="Flicka, i en rutan om 100x200 pixlar"/>


<p>Nu är bilden beskuren för att passa in i en ruta om bredd 700px och höjd 200px.</p>

<code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&width=700&height=200&crop-to-fit" alt="Flicka, i en rutan om 700x200 pixlar"/&gt;</code>

<img src="img.php?src=kodim15.png&save-as=jpg&width=700&height=200&crop-to-fit" alt="Flicka, i en rutan om 700x200 pixlar"/>


<h2>Gör bilden skarpare</h2>

<p>Här är först originalbilden, beskuren till 300x300 pixlar. Därefter kommer samma bild men förbättrad med ett filter för att ge en skarpare bild.</p>

<p><code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&width=300&height=300&crop-to-fit" alt="Flicka, förminskad och beskuren"/&gt;</code>

<img src="img.php?src=kodim15.png&save-as=jpg&width=300&height=300&crop-to-fit" alt="Flicka, förminskad och beskuren"/>

<p><code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&width=300&height=300&crop-to-fit&sharpen" alt="Flicka, förminskad, beskuren & skarpare"/&gt;</code><br/>

<img src="img.php?src=kodim15.png&save-as=jpg&width=300&height=300&crop-to-fit&sharpen" alt="Flicka, förminskad, beskuren & skarpare"/>

<h2>Gör bilden svartvit (gråskala)</h2>

<p>Här är bilden beskuren till 300x300 pixlar och i gråskala.</p>

<p><code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&width=300&height=300&crop-to-fit&f=grayscale" alt="Flicka, förminskad, beskuren och i gråskala"/&gt;</code><br>

<img src="img.php?src=kodim15.png&save-as=jpg&width=300&height=300&crop-to-fit&f=grayscale" alt="Flicka, förminskad, beskuren och i gråskala"/></p>

<h2>Gör bilden sepiafärgad</h2>

<p>Här är bilden beskuren till 300x300 pixlar och kör genom ett kombinerat sepiafilter.</p>

<p><code>&lt;img src="img.php?src=kodim15.png&save-as=jpg&width=300&height=300&crop-to-fit&sc=sepia" alt="Flicka, förminskad, beskuren och i sepia"/&gt;</code><br>

<img src="img.php?src=kodim15.png&save-as=jpg&width=300&height=300&crop-to-fit&sc=sepia" alt="Flicka, förminskad, beskuren och i sepia"/></p>

EOD;



// Finally, leave it all to the rendering phase of Anax.
include(LEAF_THEME_PATH);
