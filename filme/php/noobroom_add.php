#!/usr/local/bin/Resource/www/cgi-bin/php
<?php
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
clearstatcache();
if (file_exists("/data"))
  $f= "/data/noobroom.dat";
else
  $f="/usr/local/etc/noobroom.dat";
if (file_exists($f)) {
   $dir = $f;;
} else {
     $dir = "";
}
$query = $_GET["mod"];
if($query) {
   $queryArr = explode('*', $query);
   $mod = $queryArr[0];
   $link = $queryArr[1];
   $title = $queryArr[2];
}
if ($mod == "add") {
if ($dir <> "") {
$html=file_get_contents($dir);
$match="/"."<link>".$link."<\/link>/";
//if (strpos($html,$title) === false)
if (!preg_match($match,$html))
  $html=$html."<item><link>".$link."</link><title>".$title."</title></item>";
} else {
$dir = $f;
$html="<item><link>".$link."</link><title>".$title."</title></item>";
}
$exec = "rm -f ".$f;
exec($exec);
file_put_contents($dir,$html);
} else if ($mod="delete") {
if ($dir <> "") {
$html=file_get_contents($f);
$out="";
$videos=explode("<item>",$html);
unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {
  $l=str_between($video,"<link>","</link>");
  $t=str_between($video,"<title>","</title>");
  if ($l != $link) {
    $out=$out."<item><link>".$l."</link><title>".$t."</title></item>";
  }
}
}
if ($out <> "") {
$exec = "rm -f ".$f;
file_put_contents($f,$out);
} else {
$exec = "rm -f ".$f;
}
}

