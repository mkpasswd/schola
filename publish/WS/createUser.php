<?
include('../mini.inc.php');
include('global.inc.php');
include('WSa.class.php');
use LMKbits\WSa;

if(!$SAP->gpaccess()) {$a=new WSa(false,1,'INVALIDACCESSKEY');$a->send();exit;};
if(!$SAP->isAdmin()) {$a=new WSa(false,2,'NEEDADMINPRIV');$a->send();exit;};
$ret=$SAP->db->insertUser();
if($SAP->db->wtf()) {$a=new WSa(false,1,'CANTCREATE',$SAP->db->getErrCombo());$a->send();exit;};
//return newly create #id
$a=new WSa(true,0,'OK',$ret);
$a->send();
?>

