<?
class scholaDB implements stdErr{
var dblink=false;

include('stdErr.impl.php');
function dealDBErr() {
	$this->clearErr();
	if(!($this->dblink)) $this->setErr(666,'Not connected')
	else $this->setErr($this->dblink->connect_errno,$this->dblink->connect_error);
	return $this->wtf();
	}

__construct($host,$user,$pass,$db,$port=3306) {
	$this->dblink=new mysqli($host,$user,$pass,$db,$port);
	if($this->DBErr) return;
	//DB opened
	}

public getDBLink() { return $this->dblink; }

public directSQL($req) {
	$res=$this->dblink->query($sql);
	$this->dealDBErr();
	if($this->wtf()) return false;
	return $res;
	}

public function listUsers($extra='') {
	$sql="select * from adh $extra";
	$res=$this->directSQL($sql)
	if($this->wtf()) return false;
	$ret=array();
	while($row=$res->fetch_assoc()) {
		//traitement JSON à implanter
		$ret[$row->id]=$row;
		};
	$res->free();
	return $ret;	
	}

public function getUser($id) {
	$sql="select * from adh where id=$id";
	$res=$this->directSQL($sql)
	if($this->wtf()) return false;
	if($res->num_rows!=1) return $this->setErr(667,'Unknown User ID');
	$row=$res->fetch_assoc();
	//traitement JSON à implanter
	$ret=$row;
	$res->free();
	return $ret;	
	}

public function deleteUser($id) {
	$sql="delete from adh where id=$id";
	$res=$this->directSQL($sql);
	return $this->dealDBErr();
	}

public function replaceUser($id,$values=array()) {
	}

public function keyOK($id,$key) {
	$sql="select id from adh where id=$id and akey='$key'";
	$res=$this->directSQL($sql);
	return $this->dealDBErr();
	}

public function isAdmin($id) {
	$sql="select id from adh where id=$id and isadmin=true";
	$res=$this->directSQL($sql);
	return $this->dealDBErr();
	}

}
?>
