<?
include('../mini.inc.php');
include('global.inc.php');
include('WSa.class.php');
use LMKbits\WSa;
use LMKbits\T;

if(!$SAP->gpaccess()) {$a=new WSa(false,1,'INVALIDACCESSKEY');$a->send();exit;};
if(!$SAP->isAdmin()) {$a=new WSa(false,2,'NEEDADMINPRIV');$a->send();exit;};
$where=trim(T::gp('where',''));
$sort=trim(T::gp('sort',''));
// if(!$sort) $sort="concat(sn,'-',givenName)";
$ret=$SAP->db->listUsers($where,$sort);
// echo $SAP->db->getErrCombo();
if($SAP->db->wtf())  {$a=new WSa(false,3,'REQERROR',$SAP->db->getErrCombo());$a->send();exit;};
$a=new WSa(true,0,'OK',$ret);
$a->send();
?>
