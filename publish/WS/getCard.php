<?
include('../mini.inc.php');
include('global.inc.php');
include('WSa.class.php');
use LMKbits\WSa;
use LMKbits\T;

function errorout($a) {
	global $jpg, $SAP;
	$f=APSchola::ROOT.$SAP->getConf()->cardunavailable;
	if(!$jpg||!file_exists($f)) {$a->send();exit();};
	header('Content-Type: image/jpeg');
	header('Content-Length: '.filesize($f));
	readfile($f);
	exit();
	};

$jpg=T::gp('jpeg');
if(!$SAP->gpaccess()) errorout(new WSa(false,1,'INVALIDACCESSKEY'));
$id=trim(T::gp('id',$SAP->recuser));
$load=$SAP->db->getUser($id);
if($SAP->db->wtf()) errorout(new WSa(false,2,'NORECORD'));
if(!$load['isActive']) errorout(new WSa(false,3,'NOTVALID'));
if(!$SAP->isAdmin()) $SAP->db->updateTS($id,'lastUserAccessTS');
$cury=$SAP->getConf()->cury;
$a=new WSa(true,0,'OK',$load);
$img=@imagecreatefromjpeg(APSchola::ROOT.$SAP->getConf()->cardjpeg);
if(!$img) errorout(new WSa(false,4,'TECHPB','Missing JPEG background'.$SAP->getConf()->cardjpeg));
$font=APSchola::ROOT.$SAP->getConf()->cardfont;
// echo $font;
$deccolor=hexdec($SAP->getConf()->cardfontcolor);
$r=$deccolor >> 16;
$g=($deccolor >> 8) & 255;
$b=$deccolor & 255;
// var_dump($load); exit();
$colorindex=imagecolorallocatealpha($img,$r,$g,$b,$SAP->getConf()->cardfontalpha);
$starty=$SAP->getConf()->cardstarty;
$indenty=$SAP->getConf()->cardindenty;
// echo $indenty; exit;

function writetext($text,$scale=1) {
	global $colorindex,$img,$SAP,$starty,$indenty,$font;	
	$ret=@imagettftext($img,intval($scale*$SAP->getConf()->cardfontsize),$SAP->getConf()->cardfontangle,
		$SAP->getConf()->cardstartx,$starty,$colorindex,$font,
		$text);
	// var_dump($ret); echo "<BR>";
	if(is_array($ret)) $starty+=$ret[1]-$ret[7]+$indenty;
	else errorout(new WSa(false,5,'TECHPB','Missing TTF font '.$SAP->getConf()->cardfont));
	// $starty+=$indenty;
	// echo $starty; echo '<BR>';
	};

writetext(strtoupper($load['sn']));
writetext($load['givenName']);
//$code=rand(1000,9999).'-'.$load['id'].'-'.rand(1000,9999);
$code=' ';
writetext($code);
if(isset($SAP->getConf()->cardextrainfo)) writetext($SAP->getConf()->cardextrainfo,0.6);
if(isset($SAP->getConf()->cardextrainfo2)) writetext($SAP->getConf()->cardextrainfo2,0.6);

if($jpg) {
	header('Content-Type: image/jpeg');
	imagejpeg($img);
	exit();
	}
ob_start();
imagejpeg($img);
$ret=base64_encode(ob_get_contents());
ob_end_clean();
$a=new WSa(true,0,'OK',$ret);
$a->send();
?>

