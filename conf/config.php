<?
// Security check
if(isset($_GET['checkNetHack'])||!isset($checkNetHack))
	echo "<script type=\"text/javascript\">location.href='..';</script>";

// Some vars
$current="3.4.0";
$availVersions=array("3.2.1","3.2.3","3.2.4","3.2.5","3.2.6",$current);

// Get environment
if((strlen(getenv("SERVER_SOFTWARE")))!="0"){
	$server=getenv("SERVER_SOFTWARE");
} else {
	$server=$_SERVER['SERVER_SOFTWARE'];
}

if((strlen(getenv("SERVER_NAME")))!="0"){
	$servername=getenv("SERVER_NAME");
} else {
	$servername=$_SERVER['SERVER_NAME'];
}

// Get IPv6 environment
if((strlen(getenv("REMOTE_ADDR")))!="0"){
	$ip6=getenv("REMOTE_ADDR");
} else {
	$ip6=$_SERVER['REMOTE_ADDR'];
}

if(preg_match("/^::ffff:/",$ip6,$blah)){
 	$ip6 =substr($ip6,7);
}

if(preg_match("/:/",$ip6,$blah)){
	$ip6_mode=1;
} else {
	$ip6_mode=0;
}

// WWW mirrors
//array("name" => "name", "url" => "http url", "desc" => "description", "country" => "country location", "city" => "city location", "sponsor" => "who sponsors")
$www_mirror=array(
	1 => array("name" => "www.kvirc.net", "url" => "http://www.kvirc.net", "desc" => "www.kvirc.net: Primary www site in Norway (located in Oslo)", "country" => "Norway", "city" => "Oslo", "sponsor" => "Norwegian Linux Community"),
	array("name" => "www.kvirc.de", "url" => "http://www.kvirc.de", "desc" => "www.kvirc.de: German mirror (located in Bayreuth)", "country" => "Germany", "city" => "Bayreuth", "sponsor" => "Cyconet.org"),
	array("name" => "kvirc.slackware.it", "url" => "http://kvirc.slackware.it", "desc" => "kvirc.slackware.it: Italian mirror (located in Milano)", "country" => "Italy", "city" => "Milano", "sponsor" => "Slackware.it"),
	//array("name" => "www.kvirc.omnikron.net", "url" => "http://www.kvirc.omnikron.net", "desc" => "www.kvirc.omnikron.net: Italian mirror (located in Arezzo)", "country" => "Italy", "city" => "Arezzo", "sponsor" => "Pragma,Iakko and Resio"),
	array("name" => "kvirc.trexle.net", "url" => "http://kvirc.trexle.net", "desc" => "kvirc.trexle.net: USA mirror (located in Texas)", "country" => "USA, Texas", "city" => "", "sponsor" => "Hossam Hossny from Texle.com"),
	array("name" => "kvirc.paracoda.com", "url" => "http://kvirc.paracoda.com", "desc" => "kvirc.paracoda.com: Canadian mirror (located in Quebec)", "country" => "Canada, Quebec", "city" => "", "sponsor" => "Hossam Hossny from Texle.com"),
	//array("name" => "kvirc.ipv6.net.au", "url" => "http://kvirc.ipv6.net.au", "desc" => "kvirc.ipv6.net.au: Australian Mirror (located in Brisbane Queensland, IPv4 and IPv6)", "country" => "Australia, Queensland", "city" => "Brisbane", "sponsor" => "Peter Good, IPv6 Australia"),
	//array("name" => "kvirc.firenze.linux.it", "url" => "http://kvirc.firenze.linux.it", "desc" => "kvirc.firenze.linux.it: Italian mirror (located in Milano)", "country" => "Italy", "city" => "Milano", "sponsor" => "Firenze Linux Users Group"),
	array("name" => "www.ipv6.kvirc.net", "url" => "http://www.ipv6.kvirc.net", "desc" => "www.ipv6.kvirc.net: German IPV6 Mirror (located in Bayreouth)", "country" => "Germany", "city" => "Bayreuth", "sponsor" => "Cyconet.org")
);

// FTP mirrors
//array("name" => "name", "url" => "ftp url", "desc" => "description")
$ftp_mirror=array(
	1 => array("name" => "ftp.kvirc.ru", "url" => "ftp://ftp.kvirc.ru/pub/kvirc.net", "desc" => "ftp.kvirc.ru: Frankfurt am Main, Germany (managed by CtrlAltCa)"),
	array("name" => "ftp.kvirc.de", "url" => "ftp://ftp.kvirc.de/pub/kvirc", "desc" => "ftp.kvirc.de: Bayreuth, Germany (bandwidth by cyconet.org)"),
	array("name" => "kvirc.gmake.de", "url" => "http://kvirc.gmake.de/pub/kvirc", "desc" => "kvirc.gmake.de: Frankfurt am Main, Germany (managed by Kuja^)"),
	array("name" => "dedimarbo.ath.cx", "url" => "ftp://dedimarbo.ath.cx/pub/kvirc/", "desc" => "dedimarbo.ath.cx: Paris, France (managed by MarbolanGos)"),
	array("name" => "ftp.kvirc.net", "url" => "ftp://ftp.kvirc.net/pub/kvirc", "desc" => "ftp.kvirc.net: Primary FTP, Oslo, Norway (bandwidth by Norwegian Linux Community)"),
	array("name" => "kvirc.tradebit.com", "url" => "http://kvirc.tradebit.com/pub", "desc" => "kvirc.tradebit.com: New York, USA (bandwidth by tradebit.com)"),
	array("name" => "kvirc.imsam.info", "url" => "http://kvirc.imsam.info", "desc" => "kvirc.imsam.info: Nuernberg, Germany (bandwidth by tradebit.com)"),
	array("name" => "kvirc.bcoos.net", "url" => "http://kvirc.bcoos.net", "desc" => "kvirc.bcoos.net: USA (bandwidth by exoops.info)")
);

// Addons
//aray("name" => "name", "ver" => "addon version", "min" => "min KVIrc version", "max" => "max KVIrc version", "author" => "author", "desc" => "description", "url" => "url")
$addons=array(
	1 => array("name" => "Auto Away: Automatic Away", "ver" => "1.0.0", "min" => "3.2.1", "max" => $current, "author" => "Szymon Stefanek", "desc" => $template['addons']['addon1'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/autoaway.1.0.0.zip"),
	array("name" => "Chan Ops: Channel Operations", "ver" => "1.0.0", "min" => "3.2.1", "max" => $current, "author" => "Szymon Stefanek", "desc" => $template['addons']['addon2'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/chanops.1.0.0.zip"),
	array("name" => "Chan Stats: Channel Statistics", "ver" => "1.1.1", "min" => "3.2.1", "max" => $current, "author" => "g00dsP33D", "desc" => $template['addons']['addon3'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/chanstats.1.1.1.zip"),
	array("name" => "Hell Country", "ver" => "0.1", "min" => "3.2.1", "max" => $current, "author" => "HelLViS69", "desc" => $template['addons']['addon4'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/country.0.1.zip"),
	array("name" => "Cryption", "ver" => "1.0.2", "min" => "3.2.1", "max" => $current, "author" => "g00dsP33D", "desc" => $template['addons']['addon5'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/cryption.1.0.2.zip"),
	array("name" => "Ezbounce", "ver" => "1.0.0", "min" => "3.2.1", "max" => $current, "author" => "Szymon Stefanek", "desc" => $template['addons']['addon6'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/ezbounce.1.0.0.zip"),
	array("name" => "F4: Forza 4 game", "ver" => "0.9", "min" => "3.2.1", "max" => $current, "author" => "Grifisx &amp; Noldor", "desc" => $template['addons']['addon7'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/forza4.0.9.zip"),
	array("name" => "Fserve: An F-Server", "ver" => "1.0.0", "min" => "3.2.1", "max" => $current, "author" => "assassin", "desc" => $template['addons']['addon8'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/fserve.1.0.0.zip"),
	array("name" => "Funny Lol And Write", "ver" => "0.1", "min" => "3.2.1", "max" => $current, "author" => "Grifisx &amp; HelLViS69", "desc" => $template['addons']['addon9'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/funnylolandwrite.0.1.zip"),
	array("name" => "Hell Mediaplayer", "ver" => "0.1", "min" => "3.2.1", "max" => $current, "author" => "HelLViS69", "desc" => $template['addons']['addon10'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/mediaplayer.0.1.zip"),
	array("name" => "Mines Weeper", "ver" => "1.1.0", "min" => "3.2.1", "max" => $current, "author" => "Szymon Stefanek", "desc" => $template['addons']['addon11'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/minesweeper-1.1.0.zip"),
	array("name" => "News Ticker: The RSS News Reader", "ver" => "1.1.0", "min" => "3.2.1", "max" => $current, "author" => "Szymon Stefanek", "desc" => $template['addons']['addon12'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/newsticker-1.1.0.zip"),
	array("name" => "Now Playing: The Media Advertiser", "ver" => "1.0.0", "min" => "3.2.1", "max" => $current, "author" => "Szymon Stefanek", "desc" => $template['addons']['addon13'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/nowplaying.1.0.0.zip"),
	array("name" => "Question Manager", "ver" => "0.1", "min" => "3.2.1", "max" => $current, "author" => "Grifisx &amp; Noldor", "desc" => $template['addons']['addon14'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/questionManager.0.1.zip"),
	array("name" => "Quiz", "ver" => "1.0.0", "min" => "3.2.1", "max" => $current, "author" => "Szymon Stefanek and HelLViS69", "desc" => $template['addons']['addon15'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/quiz.1.0.0.zip"),
	array("name" => "SMS: SMS sender", "ver" => "1.9.9", "min" => "3.2.1", "max" => $current, "author" => "Grifisx &amp; Noldor", "desc" => $template['addons']['addon16'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/sms.1.9.9.zip"),
	array("name" => "The Censor", "ver" => "1.0.0", "min" => "3.2.1", "max" => $current, "author" => "Grifisx", "desc" => $template['addons']['addon17'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/thecensor.1.0.0.zip"),
	array("name" => "Twins Auto Op: auto op/voice/ban", "ver" => "1.1", "min" => "3.2.3", "max" => $current, "author" => "Ahinu", "desc" => $template['addons']['addon18'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/twinsautoop-1.1.zip"),
	array("name" => "Twins Input Color: Colorize your input text", "ver" => "1.2", "min" => "3.2.4", "max" => $current, "author" => "Ahinu", "desc" => $template['addons']['addon19'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/twinsinputcolor-1.2.zip"),
	array("name" => "Twins Lag bar: A graphical lag bar", "ver" => "1.0", "min" => "3.2.4", "max" => $current, "author" => "Ahinu", "desc" => $template['addons']['addon20'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/twinslagbar-1.0.zip"),
	array("name" => "Twins Media Player: Control your player and share you music", "ver" => "1.4", "min" => "3.2.4", "max" => $current, "author" => "Ahinu", "desc" => $template['addons']['addon21'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/twinsmediaplayer-1.4.zip"),
	array("name" => "Host Check", "ver" => "1.0", "min" => "3.2.6", "max" => $current, "author" => "", "desc" => $template['addons']['addon22'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/hostcheck.tar.gz"),
	array("name" => "KISS: The KVIrc Icons Style Setup", "ver" => "2.1", "min" => "3.2.6", "max" => $current, "author" => "HelLViS69", "desc" => $template['addons']['addon23'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/scripts/KISS-2.1.tar.bz2")
);

// Archive
// array("link" => "link name", "long" => "long name")
$months=array(
	1 => array("link" => $template['archive']['jan'], "long" => "January"),
	array("link" => $template['archive']['feb'], "long" => "February"),
	array("link" => $template['archive']['mar'], "long" => "March"),
	array("link" => $template['archive']['apr'], "long" => "April"),
	array("link" => $template['archive']['may'], "long" => "May"),
	array("link" => $template['archive']['jun'], "long" => "June"),
	array("link" => $template['archive']['jul'], "long" => "July"),
	array("link" => $template['archive']['aug'], "long" => "August"),
	array("link" => $template['archive']['sep'], "long" => "September"),
	array("link" => $template['archive']['oct'], "long" => "October"),
	array("link" => $template['archive']['nov'], "long" => "November"),
	array("link" => $template['archive']['dec'], "long" => "December")
);

// Arts
// array("title" => "title", "author" => "author", "mail" => "email", "desc" => "description", "thumb" => "thumbnail", "down" => "download", "date" => "date")
$arts=array(
	1 => array("title" => "\"Connect to the World\" Splash Screens", "author" => "SuSp|r|a", "mail" => "suspy [at] email [dot] it", "desc" => $template['arts']['desc1'], "thumb" => "connect_to_the_world_thumb.jpg", "down" => "connect_to_the_world.zip", "date" => "18.05.2005"),
	array("title" => "Suspiria's Marmalade", "author" => "SuSp|r|a", "mail" => "suspy [at] email [dot] it", "desc" => $template['arts']['desc2'], "thumb" => "suspirias_marmalade_thumb.jpg", "down" => "suspirias_marmalade.jpg", "date" => "18.05.2005"),
	array("title" => "Upside Down", "author" => "SuSp|r|a", "mail" => "suspy [at] email [dot] it", "desc" => $template['arts']['desc3'], "thumb" => "upsidedown_thumb.jpg", "down" => "upsidedown.jpg", "date" => "18.05.2005"),
	array("title" => "Avatar Background", "author" => "SuSp|r|a", "mail" => "suspy [at] email [dot] it", "desc" => $template['arts']['desc4'], "thumb" => "avatar_back_thumb.jpg", "down" => "avatar_back.jpg", "date" => "18.05.2005"),
	array("title" => "Oh.. So Lovely!", "author" => "SuSp|r|a", "mail" => "suspy [at] email [dot] it", "desc" => ":)", "thumb" => "ohsolovely_thumb.jpg", "down" => "ohsolovely.jpg", "date" => "18.05.2005"),
	array("title" => "BSD Magik", "author" => "Lady_dark_demoN", "mail" => "", "desc" => $template['arts']['desc6'], "thumb" => "karries_splash_thumb.jpg", "down" => "karrie_splash.jpg", "date" => "17.10.2005"),
	array("title" => "\"Virg0 - Time makes no Sense\" Splash Screens", "author" => "etherea`", "mail" => "cle [at] virg0 [dot] org", "desc" => $template['arts']['desc7'], "thumb" => "virg0_anomalies_thumb.png", "down" => "virg0_anomalies.zip", "date" => "09.03.2006")
);

// Honor & glory
// array("nick" => "nick", "name" => "name", "mail" => "mail", "made" => "made", "quote" => "quote", "image" => "image")
$honor=array(
	1 => array("nick" => "Pragma", "name" => "Szymon Stefanek", "mail" => "pragma [at] kvirc [dot] net", "made" => $template['honor']['made1'], "quote" => $template['honor']['quote1'], "image" => "pragma"),
	array("nick" => "Istari, spion", "name" => "Jan Wagner", "mail" => "webmaster [at] cyconet [dot] org", "made" => $template['honor']['made2'], "quote" => "", "image" => "istari"),
	array("nick" => "Balboy", "name" => "Luk De Ketelaere", "mail" => "balboy [at] kvirc [dot] net", "made" => $template['honor']['made3'], "quote" => $template['honor']['quote3'], "image" => "balboy"),
	array("nick" => "YaP", "name" => "Andrea Parrella", "mail" => "yap [at] kvirc [dot] net", "made" => $template['honor']['made4'], "quote" => $template['honor']['quote4'], "image" => "yap"),
	array("nick" => "alch3m1st", "name" => "Ted Podgurski", "mail" => "tedp [at] toocool [dot] com", "made" => $template['honor']['made5'], "quote" => $template['honor']['quote5'], "image" => "alch3m1st"),
	array("nick" => "oehansen", "name" => "O. E. Hansen", "mail" => "oe.hansen [at] gamma.telenordia [dot] se", "made" => $template['honor']['made6'], "quote" => $template['honor']['quote6'], "image" => "oehansen"),
	array("nick" => "wiza", "name" => "Jorma Tuomainen", "mail" => "jt [at] wiza [dot] fi", "made" => $template['honor']['made7'], "quote" => "", "image" => "wiza"),
	array("nick" => "Penny", "name" => "Eva Schaller", "mail" => "eva [at] cyberbeat [dot] it", "made" => $template['honor']['made8'], "quote" => $template['honor']['quote8'], "image" => "penny"),
	array("nick" => "Crissi", "name" => "Christoph Thielecke", "mail" => "", "made" => $template['honor']['made9'], "quote" => $template['honor']['quote9'], "image" => "crissi"),
	array("nick" => "Triskelios", "name" => "", "mail" => "trisk-kvirc [at] quasarnet [dot] org", "made" => $template['honor']['made10'], "quote" => $template['honor']['quote10'], "image" => "trisk"),
	array("nick" => "munehiro", "name" => "", "mail" => "", "made" => $template['honor']['made11'], "quote" => "", "image" => "munehiro"),
	array("nick" => "Kristoff", "name" => "Krzysztof Godlewski", "mail" => "kristoff [at] proczta.wprost [dot] pl", "made" => $template['honor']['made12'], "quote" => $template['honor']['quote12'], "image" => "kristoff"),
	array("nick" => "iakko", "name" => "Iacopo Palazzi", "mail" => "iakko [at] siena.linux.it_REMOVEFROMUNDERSCORETOTHISPOINT", "made" => $template['honor']['made13'], "quote" => $template['honor']['quote13'], "image" => "iakko"),
	array("nick" => "Thilo", "name" => "Thilo Schulz", "mail" => "arny [at] ats.s.bawue [dot] de", "made" => $template['honor']['made14'], "quote" => "", "image" => "Thilo"),
	array("nick" => "Ahinu", "name" => "Ahinu", "mail" => "ahinu.laman [at] gmail [dot] com", "made" => $template['honor']['made15'], "quote" => "", "image" => "ahinu"),
	array("nick" => "Noldor", "name" => "Alessandro Carbone", "mail" => "Noldor [at] barmes [dot] org", "made" => $template['honor']['made16'], "quote" => $template['honor']['quote16'], "image" => "noldor"),
	array("nick" => "Grifisx", "name" => "Tonino Imbesi", "mail" => "", "made" => $template['honor']['made17'], "quote" => $template['honor']['quote17'], "image" => "grifisx"),
	array("nick" => "Alexey", "name" => "Alexey Uzhva", "mail" => "wizard-ANTISPAM [at] opendoor [dot] ru", "made" => $template['honor']['made18'], "quote" => "", "image" => "alexey"),
	array("nick" => "HelLViS69", "name" => "Elvio Basello", "mail" => "hellvis69 [at] netsons [dot] org", "made" => $template['honor']['made19'], "quote" => $template['honor']['quote19'], "image" => "hellvis69"),
	array("nick" => "etherea`", "name" => "Claudia Galingani Mongini", "mail" => "cle [at] virg0 [dot] org", "made" => $template['honor']['made20'], "quote" => $template['honor']['quote20'], "image" => "etherea"),
	array("nick" => "Nate", "name" => "Alessio Paoletti", "mail" => "nate [at] paranoici [dot] org", "made" => $template['honor']['made21'], "quote" => "", "image" => "nate"),
	array("nick" => "k0sm|k0", "name" => "Massimiliano Leone", "mail" => "k0smik0 [at] logorroici [dot] org", "made" => $template['honor']['made22'], "quote" => $template['honor']['quote22'], "image" => "kosmiko"),
	array("nick" => "LoSko", "name" => "Lorenzo Marcon", "mail" => "lorenzo.marcon [at] startrekitalia [dot] com", "made" => $template['honor']['made23'], "quote" => $template['honor']['quote23'], "image" => "losko"),
	array("nick" => "Kane", "name" => "Juanjo Avarez", "mail" => "juanjux [at] yahoo [dot] es", "made" => $template['honor']['made24'], "quote" => $template['honor']['quote24'], "image" => "unknown"),
	array("nick" => "|Tom| [at] IrcNet", "name" => "Thomas Kalla", "mail" => "", "made" => $template['honor']['made37'], "quote" => "", "image" => "unknown"),
	array("nick" => "Ze_M", "name" => "Américo Josè Melo", "mail" => "", "made" => $template['honor']['made38'], "quote" => "", "image" => "zem"),
	array("nick" => "CGabriel", "name" => "Christopher R. Gabriel", "mail" => "cgabriel [at] linux [dot] it", "made" => $template['honor']['made25'], "quote" => $template['honor']['quote25'], "image" => "unknown"),
	array("nick" => "Drosha", "name" => "Andrew Frolov", "mail" => "", "made" => $template['honor']['made26'], "quote" => $template['honor']['quote26'], "image" => "unknown"),
	array("nick" => "Number1", "name" => "Christian Strmmen", "mail" => "number1 [at] realityx [dot] net", "made" => $template['honor']['made27'], "quote" => $template['honor']['quote27'], "image" => "unknown"),
	array("nick" => "RADKade1", "name" => "RAD Kade 1", "mail" => "", "made" => $template['honor']['made28'], "quote" => $template['honor']['quote28'], "image" => "unknown"),
	array("nick" => "KNFritz", "name" => "Fritz Elfert", "mail" => "", "made" => $template['honor']['made29'], "quote" => "", "image" => "unknown"),
	array("nick" => "Njaard", "name" => "Charles Samuels", "mail" => "kcharles [at] altair.dhs [dot] org", "made" => $template['honor']['made30'], "quote" => $template['honor']['quote30'], "image" => "unknown"),
	array("nick" => "BuTi", "name" => "", "mail" => "buti [at] geocities [dot] com", "made" => $template['honor']['made31'], "quote" => "", "image" => "unknown"),
	array("nick" => "Error403", "name" => "Nick Betcher", "mail" => "nbetcher [at] real-time [dot] com", "made" => "", "quote" => $template['honor']['quote32'], "image" => "unknown"),
	array("nick" => "Crocodile", "name" => "Olle H�ln�", "mail" => "olle [at] xmms [dot] org", "made" => $template['honor']['made33'], "quote" => "", "image" => "unknown"),
	array("nick" => "marl", "name" => "Giovanni Ferri", "mail" => "giovanni [at] fonderiadigitale [dot] it", "made" => $template['honor']['made34'], "quote" => $template['honor']['quote34'], "image" => "unknown"),
	array("nick" => "[Anodine]", "name" => "Anodine", "mail" => "", "made" => $template['honor']['made35'], "quote" => $template['honor']['quote35'], "image" => "unknown"),
	array("nick" => "infected", "name" => "Paul Boehm", "mail" => "", "made" => $template['honor']['made36'], "quote" => $template['honor']['quote36'], "image" => "unknown"),
	array("nick" => "valeragir", "name" => "Valeriy Girchenko", "mail" => "valeragir [at] mail [dot] ru", "made" => $template['honor']['made39'], "quote" => "", "image" => "unknown")
);

// Screenshots
// array("img" => "image", "thumb" => "thumbnail", "desc" => "description")
$screen=array(
	1 => array(
		0 => "KVIrc 2.0.0 \"Phoenix\"",
		array("img" => "phoenix_shot1.jpg", "thumb" => "phoenix_smallshot1.jpg", "desc" => $template['screen']['screen1']),
		array("img" => "phoenix_shot2.jpg", "thumb" => "phoenix_smallshot2.jpg", "desc" => $template['screen']['screen2']),
		array("img" => "phoenix_shot3.jpg", "thumb" => "phoenix_smallshot3.jpg", "desc" => $template['screen']['screen3']),
		array("img" => "phoenix_shot4.jpg", "thumb" => "phoenix_smallshot4.jpg", "desc" => $template['screen']['screen4']),
		array("img" => "phoenix_shot5.jpg", "thumb" => "phoenix_smallshot5.jpg", "desc" => $template['screen']['screen5']),
		array("img" => "phoenix_shot6.jpg", "thumb" => "phoenix_smallshot6.jpg", "desc" => $template['screen']['screen6']),
		array("img" => "phoenix_shot7.jpg", "thumb" => "phoenix_smallshot7.jpg", "desc" => $template['screen']['screen7']),
		array("img" => "phoenix_shot8.jpg", "thumb" => "phoenix_smallshot8.jpg", "desc" => $template['screen']['screen8'])
	),
	array(
		0 => "KVIrc 3.0.0 CVS \"Avatar\"",
		array("img" => "snapshot8.jpg", "thumb" => "snapshot8_small.jpg", "desc" => $template['screen']['screen9']),
		array("img" => "snapshot1.jpg", "thumb" => "snapshot1_small.jpg", "desc" => $template['screen']['screen10']),
		array("img" => "snapshot2.jpg", "thumb" => "snapshot2_small.jpg", "desc" => $template['screen']['screen11']),
		array("img" => "snapshot3.jpg", "thumb" => "snapshot3_small.jpg", "desc" => $template['screen']['screen12']),
		array("img" => "snapshot4.jpg", "thumb" => "snapshot4_small.jpg", "desc" => $template['screen']['screen13']),
		array("img" => "snapshot5.jpg", "thumb" => "snapshot5_small.jpg", "desc" => $template['screen']['screen14']),
		array("img" => "snapshot6.jpg", "thumb" => "snapshot6_small.jpg", "desc" => $template['screen']['screen15'])
	),
	array(
		0 => "KVIrc 3.0.0 \"Awakening\" ~ 3.0.0 CVS \"Avatar\"",
		array("img" => "awake_fancy.jpg", "thumb" => "awake_fancy_small.jpg", "desc" => $template['screen']['screen16']),
		array("img" => "awake_minimalist.jpg", "thumb" => "awake_minimalist_small.jpg", "desc" => $template['screen']['screen17']),
		array("img" => "awake_spec_windows.jpg", "thumb" => "awake_spec_windows_small.jpg", "desc" => $template['screen']['screen18']),
		array("img" => "awake_scripter.jpg", "thumb" => "awake_scripter_small.jpg", "desc" => $template['screen']['screen19']),
		array("img" => "trex_shot1.jpg", "thumb" => "trex_shot1_small.jpg", "desc" => $template['screen']['screen20']),
		array("img" => "trex_shot2.jpg", "thumb" => "trex_shot2_small.jpg", "desc" => $template['screen']['screen21']),
		array("img" => "trex_shot3.jpg", "thumb" => "trex_shot3_small.jpg", "desc" => $template['screen']['screen22']),
		array("img" => "trex_shot4.jpg", "thumb" => "trex_shot4_small.jpg", "desc" => $template['screen']['screen23'])
	),
	array(
		0 => "KVIrc 3.2.0 \"Realia\" ~ 3.2.3 CVS \"Anomalies\"",
		array("img" => "snapshot9.jpg", "thumb" => "snapshot9_small.jpg", "desc" => $template['screen']['screen24']),
		array("img" => "realia_shot_bizzia.png", "thumb" => "realia_smallshot_bizzia.png", "desc" => $template['screen']['screen25']),
		array("img" => "snapshot10.png", "thumb" => "snapshot10_small.png", "desc" => $template['screen']['screen26']),
		array("img" => "snapshot13.png", "thumb" => "snapshot13_small.png", "desc" => $template['screen']['screen27']),
		array("img" => "snapshot11.png", "thumb" => "snapshot11_small.png", "desc" => $template['screen']['screen28']),
		array("img" => "snapshot14.png", "thumb" => "snapshot14_small.png", "desc" => $template['screen']['screen29'])
	),
	array(
		0 => "KVIrc 3.2.6 \"Anomalies\"",
		array("img" => "snapshot15.png", "thumb" => "snapshot15_small.png", "desc" => $template['screen']['screen30']),
		array("img" => "snapshot16.png", "thumb" => "snapshot16_small.png", "desc" => $template['screen']['screen31']),
		array("img" => "snapshot17.png", "thumb" => "snapshot17_small.png", "desc" => $template['screen']['screen32']),
		array("img" => "snapshot18.png", "thumb" => "snapshot18_small.png", "desc" => $template['screen']['screen33']),
		array("img" => "snapshot19.png", "thumb" => "snapshot19_small.png", "desc" => $template['screen']['screen34'])
	)
);

// Scripts
// array("script" => "script name", "author" => "author name", "mail" => "author mail", "desc" => "description", "home" => "script homepage")
$scripts=array(
	1 => array("script" => "Princoscript", "author" => "Francesco Meloni", "mail" => "francesco.melo [at] tiscali [dot] it", "desc" => $template['scripts']['script1'], "home" => "http://web.tiscali.it/princoscript/"),
	array("script" => "SaNVirC", "author" => "Wunslov", "mail" => "", "desc" => $template['scripts']['script2'], "home" => "http://sanvirc.sourceforge.net/"),
	array("script" => "Savage", "author" => "???", "mail" => "", "desc" => $template['scripts']['script3'], "home" => "http://www.cynapses.org/tmp/kvirc-script-0.7.tar.gz"),
	//array("script" => "dwnKVIrc", "author" => "Klaus Weidenbach", "mail" => "Klaus.Weidenbach [at] gmx [dot] net", "desc" => $template['scripts']['script4'], "home" => "http://dszdw.homelinux.org/~klaus/programs/kvirc/index.php")
);

// Splash screens
// array("name" => "name", "screen" => "screenshot", "alt" => "version number", "motd" => "motd", "date" => "date", "present" => "present")
$splash=array(
	1 => array("name" => "0.9.0", "screen" => "splash-0.9.0.png", "alt" => "0.9.0", "motd" => "", "date" => "25.01.1999", "present" => "0.6.0, 0.8.0, 0.9.0"),
	array("name" => "1.0.0 beta", "screen" => "splash-1.0.0-beta.png", "alt" => "1.0.0 beta", "motd" => "The Net in your hands", "date" => "", "present" => ""),
	array("name" => "1.0.0 \"Millennium\"", "screen" => "splash-1.0.0.png", "alt" => "1.0.0", "motd" => "", "date" => "21.12.1999", "present" => ""),
	array("name" => "2.0.0 \"Phoenix\"", "screen" => "splash-2.0.0.png", "alt" => "2.0.0", "motd" => "The client that can't make coffee", "date" => "30.05.2000", "present" => ""),
	array("name" => "2.1.0 \"Dark Star\"", "screen" => "splash-2.1.0.png", "alt" => "2.1.0", "motd" => "The client that can't make coffee", "date" => "30.01.2001", "present" => ""),
	array("name" => "2.1.1 \"Monolith\"", "screen" => "splash-2.1.1.png", "alt" => "2.1.1", "motd" => "A breath of fresh net", "date" => "01.05.2001", "present" => ""),
	array("name" => "3.0.0 beta \"Avatar\"", "screen" => "splash-3.0.0-beta.png", "alt" => "3.0.0 beta", "motd" => "No boundaries on the net", "date" => "24.12.2001", "present" => "alpha, xmas, beta 1, beta2"),
	array("name" => "3.0.0 CVS \"Avatar\"", "screen" => "splash-3.0.0-cvs.png", "alt" => "3.0.0 CVS", "motd" => "You run, never stop, got to win, got to run 'till you drop", "date" => "", "present" => ""),
	array("name" => "3.0.0 \"Awakening\"", "screen" => "splash-3.0.0.png", "alt" => "3.0.0", "motd" => "No boundaries on the net", "date" => "17.04.2004", "present" => ""),
	array("name" => "3.0.1 \"System Virtue\"", "screen" => "splash-3.0.1.png", "alt" => "3.0.1", "motd" => "Ooh, look, a shiny object...", "date" => "31.04.2004", "present" => ""),
	array("name" => "3.0.2 CVS \"Realia\"", "screen" => "splash-3.0.2-cvs.png", "alt" => "3.0.2", "motd" => "Ooh, look, a shiny object...", "date" => "06.12.2004", "present" => ""),
	array("name" => "3.2.0 \"Realia\"", "screen" => "splash-3.2.0.png", "alt" => "3.2.0", "motd" => "So Long,  And Thanks for All the Fish", "date" => "26.02.2005", "present" => ""),
	array("name" => "3.2.0.99 CVS \"Marmalade\" (1)", "screen" => "splash-3.2.0.99.1.png", "alt" => "3.2.0.99", "motd" => "Hello, Hey Joe! You Wanna Give It a Go ?", "date" => "01.05.2005", "present" => ""),
	array("name" => "3.2.0.99 CVS \"Marmalade\" (2)", "screen" => "splash-3.2.0.99.2.png", "alt" => "3.2.0.99", "motd" => "Hello, Hey Joe! You Wanna Give It a Go ?", "date" => "01.08.2005", "present" => ""),
	array("name" => "3.2.4 CVS \"Anomalies\"", "screen" => "splash-3.2.0.20051230.png", "alt" => "3.2.4", "motd" => "Time makes no sense", "date" => "06.08.2006", "present" => "3.2.0.20051230, 3.2.1, 3.2.2, 3.2.3, 3.2.4"),
	array("name" => "3.2.6 SVN \"Anomalies\"", "screen" => "splash-3.2.6-svn.png", "alt" => "3.2.6", "motd" => "Time makes no sense", "date" => "12.09.2006", "present" => "3.2.4, 3.2.5, 3.2.6"),
	array("name" => "3.4.0 \"Virgo\"", "screen" => "splash-3.4.0.png", "alt" => "3.4.0", "motd" => "No matter how dark the night, somehow the Sun rises once again", "date" => "25-03-2008", "present" => "")
);

// Themes
// array("name" => "name", "version" => "version", "mail" => "mail", "author" => "author", "desc" => "description", "home" => "homepage", "download" => "download", "screen" => "screenshot", "thumb" => "thumbnail")

$themes=array(
	1 => array("name" => "Marble Theme", "version" => "1.0.4", "mail" => "sbrokka [at] openlug [dot] org", "author" => "Sbrokka", "desc" => $template['themes']['theme1'], "home" => "", "download" => "Marble-1.0.4.kvt", "screen" => "theme_marble.jpg", "thumb" => "thumb_marble.png"),
	array("name" => "Crystal", "version" => "0.3", "mail" => "trisk-kvirc [at] quasarnet [dot] org", "author" => "Triskelios", "desc" => $template['themes']['theme2'], "home" => "", "download" => "Crystal-0.3.kvt", "screen" => "theme_crystal.jpg", "thumb" => "thumb_crystal.png"),
	array("name" => "Green Theme", "version" => "1.1", "mail" => "", "author" => "F.F (have more fun)", "desc" => $template['themes']['theme3'], "home" => "", "download" => "Green-1.1.kvt", "screen" => "theme_green.jpg", "thumb" => "thumb_green.png"),
	array("name" => "Ircii Like", "version" => "1.0", "mail" => "eva [at] cyberbeat [dot] it", "author" => "Penny", "desc" => $template['themes']['theme4'], "home" => "", "download" => "Ircii-like-1.0.kvt", "screen" => "theme_ircii.jpg", "thumb" => "thumb_ircii.png"),
	array("name" => "Yisus", "version" => "0.3", "mail" => "fnotari [at] comtron.com [dot] ar", "author" => "Fernando Notari", "desc" => $template['themes']['theme5'], "home" => "", "download" => "Yisus-0.3.kvt", "screen" => "theme_notari.jpg", "thumb" => "thumb_notari.png"),
	array("name" => "Kitsch Theme", "version" => "1.0", "mail" => "eva [at] cyberbeat [dot] it", "author" => "Penny", "desc" => $template['themes']['theme6'], "home" => "", "download" => "Kitsch-1.0.kvt", "screen" => "theme_kitsch.jpg", "thumb" => "thumb_kitsch.png"),
	array("name" => "Ghost", "version" => "1.0", "mail" => "darkstalker [at] insightbb [dot] com", "author" => "Jason Carter", "desc" => $template['themes']['theme7'], "home" => "", "download" => "Ghost-1.0.kvt", "screen" => "theme_ghost.jpg", "thumb" => "thumb_ghost.png"),
	array("name" => "PayneReactor", "version" => "1.0", "mail" => "webmaster [at] paynereactor [dot] net", "author" => "Kristian Hollund", "desc" => $template['themes']['theme8'], "home" => "http://www.PayneReactor.com", "download" => "PayneReactor-1.0.kvt", "screen" => "theme_payne.jpg", "thumb" => "thumb_payne.png"),
	array("name" => "XCrystall Black", "version" => "0.0.1", "mail" => "wizard at opendoor [dot] ru", "author" => "Alexey", "desc" => $template['themes']['theme9'], "home" => "", "download" => "XCrystall-black-0.0.1.kvt", "screen" => "theme_xcrystall.jpg", "thumb" => "thumb_xcrystall.jpg"),
	array("name" => "DarkBaghira", "version" => "0.6", "mail" => "hellvis69 [at] netsons [dot] org", "author" => "HelLViS69", "desc" => $template['themes']['theme10'], "home" => "http://hellvis69.netsons.org", "download" => "DarkBaghira-0.6.kvt", "screen" => "theme_darkbaghira.jpg", "thumb" => "thumb_darkbaghira.png"),
	array("name" => "Time makes no sense", "version" => "3.3.2", "mail" => "cle [at] virg0 [dot] org", "author" => "etherea`", "desc" => $template['themes']['theme11'], "home" => "http://kvirc.virg0.org", "download" => "Time-3.3.2.kvt", "screen" => "theme_time.png", "thumb" => "thumb_time.png"),
	array("name" => "Pure", "version" => "1.0.1", "mail" => "cle [at] virg0 [dot] org", "author" => "etherea`", "desc" => $template['themes']['theme12'], "home" => "http://kvirc.virg0.org", "download" => "Pure-1.0.1.kvt", "screen" => "theme_pure.png", "thumb" => "thumb_pure.png"),
	array("name" => "Dark Glass", "version" => "1.0", "mail" => "grifisx [at] barmes.org", "author" => "Grifisx &amp; Noldor", "desc" => $template['themes']['theme13'], "home" => "", "download" => "DarkGlass-1.0.kvt", "screen" => "theme_darkglass.png", "thumb" => "thumb_darkglass.png"),
	array("name" => "Black Heart", "version" => "1.0", "mail" => "grifisx [at] barmes.org", "author" => "Grifisx &amp; Noldor", "desc" => $template['themes']['theme14'], "home" => "", "download" => "BlackHeart-1.0.kvt", "screen" => "theme_blackheart.png", "thumb" => "thumb_blackheart.png"),
	array("name" => "X-KVIrc-mas", "version" => "1.0", "mail" => "grifisx [at] barmes.org", "author" => "Grifisx &amp; Noldor", "desc" => $template['themes']['theme15'], "home" => "", "download" => "X-KVIrc-mas-1.0.kvt", "screen" => "theme_X-KVIrcmas.png", "thumb" => "thumb_X-KVIrcmas.png"),
	array("name" => "Words are Perversion", "version" => "1.0.3", "mail" => "cle [at] virg0 [dot] org", "author" => "etherea`", "desc" => $template['themes']['theme16'], "home" => "http://kvirc.virg0.org", "download" => "Words_are_Perversion-1.0.3.kvt", "screen" => "theme_words.png", "thumb" => "thumb_words.png"),
	array("name" => "Erotica", "version" => "0.6.9", "mail" => "cle [at] virg0 [dot] org", "author" => "etherea`", "desc" => $template['themes']['theme17'], "home" => "http://kvirc.virg0.org", "download" => "Erotica-0.6.9.kvt", "screen" => "theme_erotica.png", "thumb" => "thumb_erotica.png"),
	array("name" => "Anger", "version" => "0.0.1", "mail" => "cle [at] virg0 [dot] org", "author" => "etherea`", "desc" => $template['themes']['theme18'], "home" => "http://kvirc.virg0.org", "download" => "Anger-0.0.1.kvt", "screen" => "theme_anger.png", "thumb" => "thumb_anger.png"),
	array("name" => "Dark Blue", "version" => "0.9", "mail" => "lgxco [at] yahoo [dot] it", "author" => "Puk", "desc" => $template['themes']['theme19'], "home" => "", "download" => "DarkBlue-0.9.0.kvt", "screen" => "theme_darkblue.png", "thumb" => "thumb_darkblue.png"),
	array("name" => "Soft Blue", "version" => "2.0", "mail" => "gestenigd [at] gmail [dot] com", "author" => "lsd", "desc" => $template['themes']['theme20'], "home" => "http://stato-brodo.blogspot.com", "download" => "Soft_blue-2.0.kvt", "screen" => "theme_softblue.jpg", "thumb" => "thumb_softblue.jpg"),
	array("name" => "Snow", "version" => "1.1", "mail" => "youpiter [at] mail [dot] ru", "author" => "Youpiter", "desc" => $template['themes']['theme21'], "home" => "", "download" => "Snow-1.1.kvt", "screen" => "theme_snow.jpg", "thumb" => "thumb_snow.jpg"),
	array("name" => "Zima", "version" => "1.3", "mail" => "youpiter [at] mail [dot] ru", "author" => "Youpiter", "desc" => $template['themes']['theme22'], "home" => "", "download" => "Zima-1.3.kvt", "screen" => "theme_zima.jpg", "thumb" => "thumb_zima.jpg"),
	array("name" => "GreenKDE", "version" => "1.0", "mail" => "youpiter [at] mail [dot] ru", "author" => "Youpiter", "desc" => $template['themes']['theme23'], "home" => "", "download" => "GreenKDE-1.0.kvt", "downbig" => "GreenKDE-1.1.2.kvt", "screen" => "theme_greenkde.jpg", "thumb" => "thumb_greenkde.jpg"),
	array("name" => "Minimalist", "version" => "1.0", "mail" => "", "author" => "Stan", "desc" => $template['themes']['theme24'], "home" => "http://www.stantown.de", "download" => "Minimalist-1.0.kvt", "screen" => "theme_minimalist.png", "thumb" => "thumb_minimalist.png"),
	array("name" => "Slightly Yellow", "version" => "1.0", "mail" => "mren [at] mrmx [dot] de", "author" => "mren_", "desc" => $template['themes']['theme25'], "home" => "", "download" => "Slightly_Yellow-1.0.kvt", "screen" => "theme_slightly.png", "thumb" => "thumb_slightly.png"),
	array("name" => "YellowIRC", "version" => "1.0", "mail" => "pragma [at] kvirc [dot] net", "author" => "Pragma", "desc" => $template['themes']['theme26'], "home" => "http://pragmaware.net", "download" => "YellowIRC-1.0.kvt", "screen" => "theme_yellowirc.png", "thumb" => "thumb_yellowirc.png"),
	array("name" => "Love And Death", "version" => "1.0.5", "mail" => "", "author" => "DanBadJar", "desc" => $template['themes']['theme27'], "home" => "", "download" => "Love_and_Death-1.0.5.kvt", "screen" => "theme_loveanddeath.png", "thumb" => "thumb_loveanddeath.png"),
	array("name" => "mIRC", "version" => "1.1", "mail" => "sonichedgehog_hyperblast00 [at] yahoo [dot] com", "author" => "Taoki", "desc" => $template['themes']['theme28'], "home" => "", "download" => "mIRC-1.1.kvt", "screen" => "theme_mirc.png", "thumb" => "thumb_mirc.png"),
	array("name" => "SilverEx_Clone", "version" => "0.1", "mail" => "vampiermsx [at] gmail [dot] com", "author" => "Vampier", "desc" => $template['themes']['theme29'], "home" => "", "download" => "SilverEx_Clone-0.1.kvt", "screen" => "theme_silverexclone.png", "thumb" => "thumb_silverexclone.png"),
	array("name" => "Light My Fire!", "version" => "0.3", "mail" => "k0smik0 [at] logorroici [dot] org", "author" => "k0sm|k0", "desc" => $template['themes']['theme30'], "home" => "", "download" => "Light_My_Fire-0.3.kvt", "screen" => "theme_lightmyfire.png", "thumb" => "thumb_lightmyfire.png"),
	array("name" => "Drow", "version" => "1.0", "mail" => "yoyo.pete [at] gmail [dot] com", "author" => "YoYo-Pete", "desc" => $template['themes']['theme31'], "home" => "", "download" => "Drow-1.0.kvt", "screen" => "theme_drow.png", "thumb" => "thumb_drow.png")

	// without info, not listed
	//array("name" => "Burst Rebird", "version" => "0.1", "mail" => "", "author" => "", "desc" => "", "home" => "", "download" => "BurstRebird-0.1.kvt", "screen" => "", "thumb" => ""),
	//array("name" => "Kvinvision", "version" => "1.0", "mail" => "", "author" => "LoSko", "desc" => "", "home" => "", "download" => "Kvinvision-1.0.kvt", "screen" => "", "thumb" => "")
);

// Tools
//aray("name" => "tool name", "author" => "author name", "mail" => "author mail", "desc" => "description", "url" => "url")
$tools=array(
	1 => array("name" => "Notepad++ KVS-Syntax", "author" => "TheXception", "mail" => "kvirc [at] thexception [dot] net", "desc" => $template['tools']['tool1'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/tools/kvs-notepad++.zip"),
	array("name" => "KVIrc TCL", "author" => array("HelLViS69","CtrlAltCa"), "mail" => array("hellvis69 [at] netsons [dot] org","ctrlaltca [at] gmail [dot] com"), "desc" => $template['tools']['tool2'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/tools/kvirc-2.0.tcl.bz2"),
	array("name" => "KVIrc SVN/Trac Syndacator", "author" => "HelLViS69", "mail" => "hellvis69 [at] netsons [dot] org", "desc" => $template['tools']['tool3'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/tools/kvircrss-2.0.tcl.bz2"),
	array("name" => "GetText Checker", "author" => "aleksanteri", "mail" => "aleksanteri4028 [at] gmail [dot] com", "desc" => $template['tools']['tool4'], "url" => "ftp://ftp.kvirc.net/pub/kvirc/tools/gtc-0.2.tcl.bz2")
);

// Translations (keep 'em in alphabetical order)
// array("lang" => "language", "nick" => "nick", "mail" => "mail")
$translators=array(
	1 => array("lang" => $template['index']['french'], "nick" => array("Ahinu","_Otaku"), "mail" => array("ahinu.laman [at] gmail [dot] com","notakou [at] tiscali [dot] fr")),
	array("lang" => $template['index']['german'], "nick" => array("mren","Ionic"), "mail" => array("kvirc [at] mrmx [dot] de","ionic [at] ionic [dot] de")),
	array("lang" => $template['index']['hungarian'], "nick" => "Fiber^", "mail" => "vfiber [at] gmail [dot] com"),
	array("lang" => $template['index']['italian'], "nick" => array("Nate Grey","HelLViS69","etherea`"), "mail" => array("nate [at] paranoici [dot] org","hellvis69 [at] netsons [dot] org","cle [at] virg0 [dot] org")),
	array("lang" => $template['index']['portuguese'], "nick" => "Ze_m", "mail" => "mmodem00 [at] netvisao [dot] pt")
);

/*
$template['index']['bulgarian'], bugar [at] developer [dot] bg, Bugar
$template['index']['croatian'], SpeedyGhost
$template['index']['czech'], dusan [at] mirc [dot] cz, Dusan Hokuv
$template['index']['dutch'], balboy [at] kvirc [dot] net, Balboy
$template['index']['polish'], kgod [at] poczta.onet [dot] pl, Krzysztof Godlewski
$template['index']['brazilian'], cabide [at] brfree [dot] com.br, Adilson Gonçalves Soares Junior
$template['index']['russian'], spam [at] kvirc [dot] ru, Alexey
$template['index']['serbian'], preth [at] kvsky [dot] net, Prethorian
*/
?>
