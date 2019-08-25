<?
//Singleton d'application
// dépendances : T.class, Translation.class, fastConf.class
class APSCHOLA {
// clefs de valeurs de session
const ROOT=ROOT;
const SITE=SITE;
const BASEJQ='https://ajax.googleapis.com/ajax/libs/';
const FASTCONF='/data/schola-conf.json';
const ONE='ONE'; //un seul contexte de traduction pour cette appli
private $conf=null;
private $lang=null;
private $trad=null;
 
const DEFLANG='fr';

function site() {return self::SITE;}
function wsbase() {return self::WSBASE;}
function root() {return self::ROOT;}
function supportedLanguages() {return $this->conf->supportedLanguages;}

public static function brutexit($mess) {
	echo "\n?? EMERGENCY EXIT, $mess";
	exit();
	}

function __construct() {
	$this->loadConf();
	if(!isset($this->conf->magic)) self::brutexit('missing '.self::FASTCONF.' configuration file');
	$this->lang=$this->conf->defaultLanguage;
	$this->fitlang();
	}

function loadconf() {
	// echo "charegemnt de ".self::ROOT.self::FASTCONF."\n";
	$this->conf=new fastConf(self::ROOT.self::FASTCONF);
	}

function getTrad() {return $this->trad;}

function fitLang() {
	$reqlang=T::gp('lang');
	if(!$this->trad || ($reqlang && $reqlang!=$this->lang)) {
		//uniquement dans le cas pas de langage défini ou lang= en GET ou POST
		if($reqlang 
			&& !in_array($reqlang,$this->supportedLanguages())
			&& isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
			$reqlang=T::preferred_language($this->supportedLanguages());
		if($reqlang && in_array($reqlang,$this->supportedLanguages())) $this->lang=$reqlang;
		else $this->lang=$this->conf->defaultLanguage;
		// et chargement du fichier langue adequat
		$this->trad=new Translation(); // effacement $trad
		$this->trad->setLangDir($this->root().'/lang'); 
		$this->trad->setLangUrl($this->site().'/lang'); 
		$this->trad->loadTS('lang-'.$this->lang.'.ts',$this->lang);
		$this->trad->setDefLang($this->lang);
	};
}

// ===================== SORTIES HTML =======================
function simpleSelect($name,$opt,$default=null,$extra='') {
	$ret="<SELECT name=\"$name\" id=\"$name\" $extra>\n";
	$ret.="<OPTION value=\"\">-</OPTION>\n";
	foreach($opt as $v) {
		$yes=($opt==$default)? 'SELECTED':'';
		$ret.="<OPTION value=\"$v\" $yes>$v</OPTION>\n";
		};
	$ret.="</SELECT>\n";
	return $ret;
	}

function optgroupSelect($name,$opt,$default=null, $extra='') {
	$ret="<SELECT name=\"$name\" id=\"$name\" $extra>\n";
	$ret.="<OPTION value=\"\">-</OPTION>\n";
	foreach($opt as $group=>$tab) {
		$ret.="<optgroup label=\"$group\">";
		foreach($tab as $v) {
			$yes=($opt==$default)? 'SELECTED':'';
			$ret.="<OPTION value=\"$v\" $yes>$v</OPTION>\n";
			};
		$ret.="</optgroup>\n";
		};
	$ret.="</SELECT>\n";
	return $ret;
	}

//   _____ _____ _____ _____ _____ _____ _____ 
//  |_____|_____|_____|_____|_____|_____|_____|
//   _    ____  _                    _           
//  | |__|___ \| |__   ___  __ _  __| | ___ _ __ 
//  | '_ \ __) | '_ \ / _ \/ _` |/ _` |/ _ \ '__|
//  | |_) / __/| | | |  __/ (_| | (_| |  __/ |   
//  |_.__/_____|_| |_|\___|\__,_|\__,_|\___|_|   
//
function header($title,$extra='') {

$extra=array_flip(explode(' ',strtolower($extra)));
$nojq=isset($extra['nojq']);
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<!-- <meta http-equiv="Cache-Control" content="private, cache, no-store, max-age=600"> -->
	<link rel="shortcut icon" href="<?=$this->site();?>/images/aspros-64x64.png" /> <!--pour mod_proxy_html -->
	<TITLE><?=$title;?></TITLE>
	<meta name="description" content="<?$this->getTrad()->translate(self::ONE,'DEFTITLE')?>">
	<meta name="viewport" content="width=device-width">
</head>

<body>
	<? if(!$nojq) { ?>
	<script src="<?=self::BASEJQ?>/jquery/1.8.2/jquery.min.js"></script>
	<script src="<?=self::BASEJQ?>/jqueryui/1.9.1/jquery-ui.min.js"></script>
	<script src="<?=self::BASEJQ?>/jqueryui/1.9.1/i18n/jquery-ui-i18n.min.js"></script>
	<script src="<?=$this->site()?>/include/JT.js.php"></script>
	<? }; ?>

	<link rel="stylesheet" href="<?=self::BASEJQ?>/jqueryui/1.9.1/themes/smoothness/jquery-ui.css">	
	<link rel="stylesheet" href="<?=$this->site();?>/schola.css.php">

<? if(!$nojq) { ?>
<script>
$(function() { 
$(document).tooltip();
});
</script>
<? }; ?>

<!--  ========================== content -->
<HEADER id=HEAD class="ui-widget ui-widget-header ui-corner-all">
<IMG src="<?echo $this->site();?>/images/schola.png"><H1><?echo $title?></H1>
</HEADER>
<DIV id="MAIN" class="ui-widget-content ui-corner-all">
<?
} // fin methode header


//   _____ _____ _____ _____ _____ _____ _____ 
//  |_____|_____|_____|_____|_____|_____|_____|
//

function tailer($extra='') {
?>
</DIV	> <!-- fin de MAIN-->
<FOOTER id="TAILER" class="ui-widget ui-widget-header ui-corner-all">
<IMG id="SCHOLALOGO" src="<?echo $this->site();?>/images/ASPROS.png" alt="Logo ASPROS"><SPAN id="FOOTERAPPNAME">ASPROS</SPAN>
</FOOTER>
</BODY>
</HTML>
<?
}

}; // fin definition de la classe
?>
