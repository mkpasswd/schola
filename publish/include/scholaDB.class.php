<?
include('ErrDeal.trait.php');

class scholaDB{

use LMKbits\ErrDeal;

var $dblink=false;
static $DEBUG=false;

static $ADMINFIELDS=array(
	'id',
	'akey',
	'sn',
	'givenName',
	'isActive',
	'isAdmin',
	'isCAMember',
	'isBureauMember',
	'createTS',
	'modifyTS',
	'lastCallTS',
	'lastUserModTS',
	'lastAdminModTS',
	'lastUserAccessTS'
	);

static $DIRECTFIELDS=array(
	'id'=>'i',
	'akey'=>'a',
	'sn'=>'a',
	'givenName'=>'a',
	'mail'=>'a',
	'category'=>'a',
	'year'=>'a',
	'hasResigned'=>'b',
	'isActive'=>'b',
	'showAddress'=>'b',
	'isAdmin'=>'b',
	'isCAMember'=>'b',
	'isBureauMember'=>'b',
	'lastCallTS'=>'ts',
	'lastUserModTS'=>'ts',
	'lastAdminModTS'=>'ts',
	'lastUserAccessTS'=>'ts'
	);

static $JSONFIELDS=array(
	'resReason'=>'a',
	'telephoneNumber'=>'a',
	'postalAddress'=>'a',
	'arrivee'=>'a'
	);

static $ALLFIELDS=false;

function dealDBErr() {
	$this->clearErr();
	if(!($this->dblink)) $this->setErr(666,'Not connected');
	else $this->setErr($this->dblink->errno,$this->dblink->error);
	return $this->wtf();
	}

function __construct($host,$user,$pass,$db,$port=3306) {
	// echo "$host,$user,$pass,$db,$port";
	$this->dblink=new mysqli($host,$user,$pass,$db,$port);
	if(!($this->dblink)) $this->setErr($this->dblink->connect_errno,$this->dblink->connect_error);
	else $this->dblink->set_charset('utf8');
	if(!self::$ALLFIELDS) 
		self::$ALLFIELDS=array_merge(
			self::$DIRECTFIELDS,
			self::$JSONFIELDS);
	// $this->dealDBErr(); // if($this->DBErr) return;
	//DB opened
	}

public function getDBLink() { return $this->dblink; }

public function directSQL($req) {
	if(self::$DEBUG) echo "\nREQ:".$req;
	$res=$this->dblink->query($req);
	if(self::$DEBUG)	echo "\nDBERR:".$this->dblink->errno.','.$this->dblink->error."\n";
	$this->dealDBErr();
	if($this->wtf()) return false;
	return $res;
	}

private function addJsonFields(&$row) {
	$extra=json_decode($row['jsonVals'],true);
	/*	if($extra) $row=array_merge($row,$extra);
	foreach(self::$JSONFIELDS as $f)
		if (!isset($row[$f])) $row[$f]='';
	*/
	//make sure all records have the same number of fields
	//in the same order, otherwise CSV export pb
	foreach(array_keys(self::$JSONFIELDS) as $f) {
		$row[$f]=(is_array($extra) && isset($extra[$f]))? $extra[$f]:'';
		};
	}

public function listUsers($where='',$sort='') {
	$sql='select * from adh';
	if($where) $sql.=" WHERE $where";
	if($sort) $sql.=" ORDER BY $sort";
	// echo "$sql\n";
	$res=$this->directSQL($sql);
	if($this->wtf()) return false;
	$ret=array();
	while($row=$res->fetch_assoc()) {
		$this->addJsonFields($row);
		$ret[]=$row;
		};
	$res->free();
	return $ret;	
	}

public function getUser($id) {
	$id=intval($id);
	$sql="select * from adh where id=$id";
	$res=$this->directSQL($sql);
	if($this->wtf()) return false;
	if($res->num_rows!=1) return $this->setErr(667,'Unknown User ID');
	$row=$res->fetch_assoc();
	// $extra=json_decode(base64_decode($row['jsonVals']),true);
	$this->addJsonFields($row);
	$ret=$row;
	$res->free();
	return $ret;	
	}

public function deleteUser($id) {
	$id=intval($id);
	$sql="delete from adh where id=$id";
	$res=$this->directSQL($sql);
	$this->dealDBErr();
	return !$this->wtf();
	}

public function updateTS($id,$tsfield) {
	$id=intval($id);
	$sql="update adh set `$tsfield`=now() where id=$id";
	$res=$this->directSQL($sql);
	$this->dealDBErr();
	return !$this->wtf();
	}

public function inactivateAll() {
	$sql="update adh set isActive=false";
	$res=$this->directSQL($sql);
	$this->dealDBErr();
	return !$this->wtf();
	}

public function insertUser($values=array()) {
	$sql='insert into adh set akey=md5(concat(rand(),rand()))';
	$res=$this->directSQL($sql);
	if($this->dealDBerr()) return false;
	$id=$this->dblink->insert_id;
	// echo "Insert ion $id\n";
	if(!$this->updateUser($id,$values)) return false;
	return $id;
	}

public function updateUser($id,$values=array()) {
	$this->clearErr();
	if(empty($values)) return true;
	// var_dump($values);
	$req='UPDATE adh SET ';
	$addvirg='';
	foreach(self::$DIRECTFIELDS as $k=>$t) {
		if(isset($values[$k])) {
			$req.=$addvirg;
			$addvirg=', ';
			$fvalue=$values[$k];
			switch($t) {
			case 'i':
				$req.="`$k`=$fvalue";
				break;
			case 'ts':
				$req.="`$k`=now()";
				break;
			case 'a':
				$req.="`$k`='".addslashes($fvalue)."'";
				break;
			case 'b':
				$fvalue=($fvalue=='yes'||$fvalue=='X'||$fvalue==1)? 'true':'false';
				$req.="`$k`=$fvalue";
				break;
				};
			unset($values[$k]);
			};
		}; //fin de boucle sur les champs SQL
	
	// on enregistre tout ce qui reste dans jsonVals
	// ça suppose qu'on a repris toutes les valeurs initiales.
	if(!empty($values) && ($fvalue=json_encode($values)))
		// $req.="$addvirg `jsonVals`='".base64_encode($fvalue)."'";
		$req.="$addvirg `jsonVals`='".addslashes($fvalue)."'";

	$req.=" WHERE id=$id";
	//echo "$req\n";
	$res=$this->directSQL($req);
	// echo $this->getErrCombo()."\n";
	$this->dealDBErr();		
	return !$this->wtf();
	}

public function keyOK($id,$key) {
	$id=intval($id);
	$key=addslashes($key);
	if(!$id||!$key) return $this->setErr(668,'keyOK Empty parameters');
	$sql="select id from adh where id=$id and akey='$key'";
	$res=$this->directSQL($sql);
	if($this->wtf()) return false;
	if($res->num_rows!=1) return $this->setErr(669,'Not single result');
	return true;
	}

public function isAdmin($id) {
	$id=intval($id);
	$sql="select id from adh where id=$id and isadmin=true";
	$res=$this->directSQL($sql);
	if($this->wtf()) return false;
	if($res->num_rows!=1) return $this->setErr(669,'Not single result');
	return true;
	}

}
?>
