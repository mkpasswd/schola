<?
class T {
public static function dealinput($inp,$maxlen,$maxtabentries) {
	if(is_array($inp)) {
		$ret=array();
		foreach($inp as $v) $ret[]=substr($v,0,$maxlen);
		return $ret;
		}
	else return substr($inp,0,$maxlen);
	}

public static function gp($name,$default=NULL,$maxlen=512,$maxtabentries=20) {
	if(isset($_POST[$name])) return self::dealinput($_POST[$name],$maxlen,$maxtabentries);
	if(isset($_GET[$name])) return self::dealinput($_GET[$name],$maxlen,$maxtabentries);
	if(isset($default)) return $default;
	return false;
	}

public static function cuts() {	return time();	}

public static function currenthttpdir() {
	$url='http'.((!empty($_SERVER['HTTPS']))? 's':'').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	preg_match('=^(.*)/=',$url,$match);
	return $match[1];
}

public static function uuidgen()
	{return exec("/usr/bin/uuidgen");}

public static function dump($v) 
	{echo "\n<PRE>"; var_dump($v); echo "</PRE>\n";}

public static function dump2s($v) {
	ob_start();
	print_r($v);
	$tag=ob_get_contents(); 
	ob_end_clean();
	return $tag;
}

public static function noaccent($s) {
//VERSION APPEL LIGNE DE COMMANDE
/*	putenv("LANG=en_US.UTF-8");
	//$s=addslashes($s);
	//$s=str_replace('"','\"',$s);
	$s=str_replace("'","",$s);
	$cmd="sh -c 'echo \"$s\" | /usr/bin/iconv -f UTF-8 -t ASCII//TRANSLIT '";
	if(exec($cmd,$out)) $s=$out[0];
	return $s;
*/
// l'appel en direct foire, ça remplace tous les caractère par '?'
// si LC_TYPE n'est pas renseigné
// Pour les valeurs acceptées par LC_TYPE : locale -a sous unix

	// traitement des cas non gérés par iconv
	$extra=array(
		'đ'=>'d',
		'Đ'=>'D'
		);
	$s=str_replace(array_keys($extra),array_values($extra),$s);
	setlocale(LC_CTYPE, 'en_US.utf8');
	$ret=@iconv('UTF-8','ASCII//TRANSLIT',$s);
	if(!$ret) $ret=@iconv('UTF-8','ASCII//TRANSLIT',@utf8_encode($s));
	return $ret;
}

public static function cillitbang($s) {
$ret=self::noaccent($s);
// suppression de tout ce qui n'est pas carractère et passage en uppercase
return strtoupper(preg_replace("/[^[:alpha:]]/u",'',$ret));
}

public static function startWith($haystack,$sora,$caseSensitive=false) {
if(is_string($sora)) $sora=array($sora);
foreach($sora as $v) {
	if($caseSensitive) {
		if(strpos($haystack,$v)===0) return $v;
		}
	else {
		if(stripos($haystack,$v)===0) return $v;
		};
	};
return false;
}

//=======================================================
//=======================================================
public static function gensalt() {
	$sbase='abcdefghijklmnopqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXY';
	$salt=$sbase[rand(0, strlen($sbase)-1)].$sbase[rand(0, strlen($sbase)-1)];
	return $salt;
}

static function preferred_language ($available_languages,$http_accept_language="auto") {
    // if $http_accept_language was left out, read it from the HTTP-Header
    if ($http_accept_language == "auto") $http_accept_language=(array_key_exists('HTTP_ACCEPT_LANGUAGE',$_SERVER))? $_SERVER['HTTP_ACCEPT_LANGUAGE']:'fr';

    // standard  for HTTP_ACCEPT_LANGUAGE is defined under
    // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4
    // pattern to find is therefore something like this:
    //    1#( language-range [ ";" "q" "=" qvalue ] )
    // where:
    //    language-range  = ( ( 1*8ALPHA *( "-" 1*8ALPHA ) ) | "*" )
    //    qvalue         = ( "0" [ "." 0*3DIGIT ] )
    //            | ( "1" [ "." 0*3("0") ] )
    preg_match_all('/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?' .
                   '(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/i',
                   $http_accept_language, $hits, PREG_SET_ORDER);

    // default language (in case of no hits) is the first in the array
    $bestlang = $available_languages[0];
    $bestqval = 0;

    foreach ($hits as $arr) {
        // read data from the array of this hit
        $langprefix = strtolower ($arr[1]);
        if (!empty($arr[3])) {
            $langrange = strtolower ($arr[3]);
            $language = $langprefix . "-" . $langrange;
        }
        else $language = $langprefix;
        $qvalue = 1.0;
        if (!empty($arr[5])) $qvalue = floatval($arr[5]);
     
        // find q-maximal language 
        if (in_array($language,$available_languages) && ($qvalue > $bestqval)) {
            $bestlang = $language;
            $bestqval = $qvalue;
        }
        // if no direct hit, try the prefix only but decrease q-value by 10% (as http_negotiate_language does)
        else if (in_array($langprefix,$available_languages) && (($qvalue*0.9) > $bestqval)) {
            $bestlang = $langprefix;
            $bestqval = $qvalue*0.9;
        }
    }
    return $bestlang;
}

}; // fin definition de la classe
?>
