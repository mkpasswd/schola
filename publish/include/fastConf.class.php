<?
class fastConf {

static $path=false;
var $___name=false;

public static function setPath($path) {
	if(!is_writeable($path)) return false;
	self::$path=$path;
	return true;
	}

public static function boolstate($state,&$match=false) {
	$state=trim(strtolower($state));
	if(in_array($state,array('yes','y','true','oui','1','on','vrai'))) {
		$ret=true;
		return true;
		};
	if(in_array($state,array('no','n','false','non','0','off','faux'))) {
		$ret=true;
		return false;
		};
	$match=false;
	return false;
	}
	
public function __construct($name=false) {
	if(!$name) return;
	$this->___name=$name;
	$this->load();
	}

private function calfp($pname) {
	$ln=($pname)? $pname:$this->___name;
	if(!$ln) return false;
	return (self::$path)? self::$path.'/'.$ln:$ln;
	}
	
public function name() {return $___name;}
	
public function load($name=false) {
	$fp=$this->calfp($name);
	if(!$fp) return false;
	if(!is_readable($fp)) return false;
	if(($cnt=@file_get_contents($fp))===false) return false;
	$data=json_decode($cnt);
	if($data==null) return false;
	if($name) $this->___name=$name;
	foreach($data as $k=>$v) $this->$k=$v;
	}

public function save($name=false) {
	$fp=$this->calfp($name);
	if(!$fp) return false;
	$data=json_encode($this);
	if(!file_put_contents($fp,$data)) return false;
	return true;
	}

}
?>
