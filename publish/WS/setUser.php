<?
include('../mini.inc.php');
include('global.inc.php');
include('WSa.class.php');
use LMKbits\WSa;
use LMKbits\T;

function unsetgp($v) {
	if(isset($_GET[$v])) unset($_GET[$v]);
	if(isset($_POST[$v])) unset($_POST[$v]);
	};

if(!$SAP->gpaccess()) {$a=new WSa(false,1,'INVALIDACCESSKEY');$a->send();exit;};
$id=intval(trim(T::gp('id')));
if(!$id) {$a=new WSa(false,1,'MISSINGID');$a->send();exit;};

//suppress admin only fields for simple users
//brute but safe.
$isadreq=$SAP->isAdmin();
if(!$isadreq)
	foreach(scholaDB::$ADMINFIELDS as $v) unsetgp($v);
// var_dump(scholaDB::$ALLFIELDS);
foreach(scholaDB::$ALLFIELDS as $f=>$ft) {
	$v=T::gp($f,false);
	if($v!==false) $dbup[$f]=$v;
	};
$SAP->db->updateUser($id,$dbup);
if($SAP->db->wtf()) {$a=new WSa(false,1,'CANTUPDATE',$SAP->db->getErrCombo());$a->send();exit;};
if(!$isadreq) $SAP->db->updateTS($id,'lastUserModTS');
$a=new WSa(true,0,'OK');
$a->send();
?>

