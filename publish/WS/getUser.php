<?
include('../mini.inc.php');
include('global.inc.php');
include('WSa.class.php');

if(!$SAP->gpaccess()) {$a=new WSa(false,1,'INVALIDACCESSKEY');$a->send();exit;};
$id=trim(T::gp('id',$SAP->recuser));
$load=$SAP->db->getUser($id);
if($SAP->db->wtf())  {$a=new WSa(false,1,'NORECORD');$a->send();exit;};
if(!$SAP->isAdmin()) $SAP->db->updateTS($id,'lastUserAccessTS');
$cury=$SAP->getConf()->cury;
$load['yearLabel']=$SAP->getConf()->years->$cury;
$load['currentUserIsAdmin']=($SAP->isAdmin())? '1':'';
$a=new WSa(true,0,'OK',$load);
$a->send();
?>

