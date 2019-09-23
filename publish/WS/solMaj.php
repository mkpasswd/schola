<?
include('../mini.inc.php');
include('global.inc.php');
include('WSa.class.php');

if(!$SAP->gpaccess()) {$a=new WSa(false,1,'INVALIDACCESSKEY');$a->send();exit;};
if(!$SAP->isAdmin()) {$a=new WSa(false,2,'NEEDADMINPRIV');$a->send();exit;};
$ids=T::gp('ids',array());
$a=new WSa(true,0,'OK',$ids);
$a->send();
exit();
var_dump($ids);
// echo $SAP->db->getErrCombo();
if($SAP->db->wtf())  {$a=new WSa(false,3,'REQERROR',$SAP->db->getErrCombo());$a->send();exit;};
$a=new WSa(true,0,'OK',$ret);
$a->send();
?>
