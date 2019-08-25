<?

class Translation {
const DEFLANG='deflang';
// const EMPTYKEY='____empty_lmk_key___';

private $userdeflang;
private $dico=array();
private $ifnotthen=array();
private $slang=self::DEFLANG; //selected language
private $langdir='';
private $langurl='';

public function setDefLang($lang) {
	$this->userdeflang=$lang;
	}

public function setLangDir($langdir) {
	$this->langdir=$langdir;
	}

public function setLangURl($langurl) {
	$this->langurl=$langurl;
	}

public function getLangURl() {
	return $this->langurl;
	}

public function getDefLang() {
	if($this->userdeflang) return $this->userdeflang;
	return self::DEFLANG;
	}

protected function replace($context,$key,$lang,$value) {
//if(!$key) { $key=$this->EMPTYKEY;
//		echo "nuvelle clef $key\n"; };
// if(!$key) { $key=$this->EMPTYKEY; echo "REMPLACEMENT";};
if(!@is_array($this->dico[$context])) $this->dico[$context]=array();
if(!@is_array($this->dico[$context][$key])) $this->dico[$context][$key]=array();
if(!@is_array($this->dico[$context][$key][$lang])) $this->dico[$context][$key][$lang]=array();
$this->dico[$context][$key][$lang]=$value;
//print_r($this->dico);
}

// chargement de phrases au format QT LINGUIST
public function loadTS($file,$lang='') {
	if(!$lang) $lang=$this->getDefLang();
	try {
	if(isset($this->langdir)) $file=$this->langdir.'/'.$file;
	$cat=simplexml_load_file($file);
	foreach($cat->context as $c) {
		$context=(string)$c->name;
		foreach($c->message as $m) {
			$org=(string)$m->source;
			$trad=(string)$m->translation;
//			echo "$context,$lang,$org,$trad\n";
			$this->replace($context,$org,$lang,$trad);
			}
		};
	}
	catch (Exception $e) {
	};
}

public function addIfNotThen($unavailable,$trythis) {
// pas de vérification de boucle dans le graphe => boucle infinie impossible sur la lecture
$this->ifnotthen[$unavailable]=$trythis;
}

public function translate($context,$key,$lang='') {
//	if(!$key) { $key=$this->EMPTYKEY;
//		echo "nuvelle clef $key\n"; };
	if(!$lang) $lang=$this->getDefLang();
	$tint=array($lang);
	while($flang=@$this->ifnotthen[$lang]) $tint[]=$flang;
	foreach($tint as $flang) {
		// echo "\n<!-- essai traduction avec $context $key $flang -->\n";
		if($trans=@$this->dico[$context][$key][$lang]) return $trans;
		};
	//on a pas trouvé de traduction, dans le cas ou on cherche la traduction
	//de la deflang, on crée cette clef dans le dictionnaire avec trad à vide.
	if(($lang==$this->getDefLang()) && (!isset($this->dico[$context][$key][$lang]))) $this->replace($context,$key,$lang,'');
	// echo "\n<!-- remplissage et retour $key -->\n";
	return '['.$context.']&shy;'.$key;
}

public function i18n($context,$key,$lang='') {
	echo $this->translate($context,$key,$lang);
	}

public function asi18n($context,$key,$lang='') {
	echo addslashes($this->translate($context,$key,$lang));
	}

public function xml($lang='',$option='') {
	$option=strtoupper($option);
	$onlyempty=(strpos($option,'ONLYEMPTY')!==false);
	if(!$lang) $lang=$this->getDefLang();
	$ret="<!DOCTYPE TS><TS>";
	// print_r($this->dico);
	ksort($this->dico);
	foreach($this->dico as $context=>$tkey) {
		$ret.="\n<context>\n\t<name>".htmlspecialchars($context).'</name>';
		ksort($tkey);
		foreach($tkey as $key=>$tlang) {
			$translation=$tlang[$lang];
			if(!$onlyempty || !$translation) {
				$ret.="\n\t<message>";
				$ret.="\n\t\t<source>".htmlspecialchars($key).'</source>';
				$ret.="\n\t\t<translation>".htmlspecialchars($translation).'</translation>';
				$ret.="\n\t</message>";
				};
			};
		$ret.="\n</context>";
		};
	$ret.="</TS>";
	return $ret;
}

public function i18nfile($file,$lang='') {
	if(!$lang) $lang=$this->getDefLang();
	$file=$this->langdir.'/'.$lang.'/'.$file;
	return $file;
	}

//retourne le contenu d'un fichier
//eventuellement limité à la partire entreun tag de debut et un tag de fin
public function i18nfilecontent($file,$lang='',$starttag='',$endtag='') {
	$fn=$this->i18nfile($file,$lang);
	if(!file_exists($fn)) return false;
	if($starttag=='') return file_get_contents($fn);
	if(!$endtag) $endtag='</'.substr($starttag,1);
	if(!($f=fopen($fn,'r'))) return false;
	$tagfound=false;
	$end=feof($f);
	//lecture jusqu'au starttag
	while(!$tagfound && !$end) {
		$l=fgets($f);
		$pos=stripos($l,$starttag);
		if(is_integer($pos)) {
			$tagfound=true;
			$l=substr($l,$pos+strlen($starttag));
			};
		$end=feof($f);
		};
	if(!$tagfound) {fclose($f); return false;};

	//lecture jusqu'au endtag
	$tagfound=false;
	$result='';
	while(!$tagfound && !$end) {
		$pos=stripos($l,$endtag);
		if(is_integer($pos)) {
			$tagfound=true;
			$l=substr($l,0,$pos);
			};
		$result.=$l;
		$end=feof($f);
		$l=fgets($f);
		};
	fclose($f);
	return $result;
	}

//retourne le contenu d'un fichier
//eventuellement limité à la partire entreun tag de debut et un tag de fin
public function i18nreadfile($file,$lang='') {
	$fn=$this->i18nfile($file,$lang);
	if(!file_exists($fn)) return false;
	return file($fn);
	}

public function i18nurl($file,$lang='') {
	if(!$lang) $lang=$this->getDefLang();
	$url=$this->langurl.'/'.$lang.'/'.$file;
	return $url;
	}

}

?>
