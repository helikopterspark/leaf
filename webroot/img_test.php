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

<h2>Originalbilden</h2>

<p>Så här ser originalbilden ut, oförvanskad i sitt originalutförande. Bilden är i PNG-format och filstorleken är 589KB.</p>

<code>&lt;img src="img/kodim15.png" alt="Flicka, exempelbild från Kodak"/&gt;</code>

<img src="img/kodim15.png" alt="Flicka, exempelbild från Kodak"/>



<h2>Visa bilden med img.php</h2>

<p>Så här ser bilden ut när den visas upp, oförvanskad i img.php, det är alltså exakt samma källbild, men nu levereras den av PHP.</p>

<code>&lt;img src="img.php?src=kodim15.png" alt="Flicka, exempelbild från Kodak"/&gt;</code>

<img src="img.php?src=kodim15.png" alt="Flicka, exempelbild från Kodak"/>



<h2>Spara bilden som JPEG</h2>

<p>Denna bilden är omvandlad och sparad i JPEG-format i en cachad variant av bilden med kvalitetsfaktorn 40, resultatet blir en bild som är 1/20-del av orginalbildens storlek med liknande upplevd kvalitet.</p>

<code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;quality=40" alt="Flicka, exempelbild från Kodak"/&gt;</code>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;quality=40" alt="Flicka, exempelbild från Kodak"/>



<h2>Förminska bilden</h2>

<p>Här är bild som nu är 400 pixlar bred. Höjden räknas ut.</p>

<code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=400" alt="Flicka, 400 pixlar bred"/&gt;</code>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=400" alt="Flicka, 400 pixlar bred"/>



<p>Här är bilden som nu är 200 pixlar hög. Bredden räknas ut.</p>

<code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;height=200" alt="Flicka, 200 pixlar hög"/&gt;</code>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;height=200" alt="Flicka, 200 pixlar hög"/>



<p>Här är bilden som nu passar in i en tänkt ruta om max 200 pixlars bredd och höjd. Ingen del av bilden får gå utanför rutan och bildens storleksförhållande mellan bredd och höjd behålls.</p>

<code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=200&amp;height=200" alt="Flicka, i en ruta om 200 pixlar"/&gt;</code>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=200&amp;height=200" alt="Flicka, i en ruta om 200 pixlar"/>



<h2>Passa in bilden och ta bort resten</h2>

<p>Här är bilden som nu passar in i en tänkt ruta om max 200 pixlars bredd och höjd. Bilden är beskuren för att få plats i rutan.</p>

<code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=200&amp;height=200&amp;crop-to-fit" alt="Flicka, i en ruta om 200 pixlar"/&gt;</code>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=200&amp;height=200&amp;crop-to-fit" alt="Flicka, i en ruta om 200 pixlar"/>


<p>Nu är bilden beskuren för att passa in i en ruta om bredd 100px och höjd 200px.</p>

<code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=100&amp;height=200&amp;crop-to-fit" alt="Flicka, i en ruta om 100x200 pixlar"/&gt;</code><br>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=100&amp;height=200&amp;crop-to-fit" alt="Flicka, i en ruta om 100x200 pixlar"/>


<p>Nu är bilden beskuren för att passa in i en ruta om bredd 700px och höjd 200px.</p>

<code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=700&amp;height=200&amp;crop-to-fit" alt="Flicka, i en ruta om 700x200 pixlar"/&gt;</code><br>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=700&amp;height=200&amp;crop-to-fit" alt="Flicka, i en ruta om 700x200 pixlar"/>


<h2>Gör bilden skarpare</h2>

<p>Här är först originalbilden, beskuren till 300x300 pixlar. Därefter kommer samma bild men förbättrad med ett filter för att ge en skarpare bild.</p>

<p><code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit" alt="Flicka, förminskad och beskuren"/&gt;</code>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit" alt="Flicka, förminskad och beskuren"/>

<p><code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;sharpen" alt="Flicka, förminskad, beskuren & skarpare"/&gt;</code><br/>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;sharpen" alt="Flicka, förminskad, beskuren & skarpare"/>

<h2>Gör bilden svartvit (gråskala)</h2>

<p>Här är bilden beskuren till 300x300 pixlar och i gråskala.</p>

<p><code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;f=grayscale" alt="Flicka, förminskad, beskuren och i gråskala"/&gt;</code><br>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;f=grayscale" alt="Flicka, förminskad, beskuren och i gråskala"/></p>

<h2>Pixelera bilden</h2>

<p>Här är bilden beskuren till 300x300 pixlar och körd genom ett pixelfilter.</p>

<p><code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;f=pixelate,10,10" alt="Flicka, förminskad, beskuren och pixelerad"/&gt;</code><br>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;f=pixelate,10,10" alt="Flicka, förminskad, beskuren och pixelerad"/></p>

<h2>Gör bilden sepiafärgad</h2>

<p>Här är bilden beskuren till 300x300 pixlar och körd genom ett kombinerat sepiafilter via en shortcut-sträng.</p>

<p><code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;sc=sepia" alt="Flicka, förminskad, beskuren och i sepia"/&gt;</code><br>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;sc=sepia" alt="Flicka, förminskad, beskuren och i sepia"/></p>

<h2>Ytterligare en shortcut, Pixeldistort</h2>

<p>Här är bilden beskuren till 300x300 pixlar och körd genom ett kombinerat filter.</p>

<p><code>&lt;img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;sc=pixeldistort" alt="Flicka, förminskad, beskuren, i negativ gråskala och pixelerad"/&gt;</code><br>

<img src="img.php?src=kodim15.png&amp;save-as=jpg&amp;width=300&amp;height=300&amp;crop-to-fit&amp;sc=pixeldistort" alt="Flicka, förminskad, beskuren, i negativ gråskala och pixelerad"/></p>

EOD;



// Finally, leave it all to the rendering phase of Anax.
include(LEAF_THEME_PATH);
