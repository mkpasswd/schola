<?
include('../mini.inc.php');
include('global.inc.php');
include('WSa.class.php');
include('TMail.class.php');

if(!$SAP->gpaccess()) {$a=new WSa(false,1,'INVALIDACCESSKEY');$a->send();exit;};
if(!$SAP->isAdmin()) {$a=new WSa(false,2,'NEEDADMINPRIV');$a->send();exit;};
$ids=T::gp('ids',array());
if(!is_array($ids)) {$a=new WSa(false,3,'INCORRECTPARM','ids');$a->send();exit;};
$numero=T::gp('numero',1);

$totdbproblem=0;
$totnoaddress=0;
$totmailsent=0;
$recipients=array();
$mail=new TMail();
$mcontent=$SAP->getTrad()->i18nfile("mails/sol-$numero.txt");
$urlformat=SITE."/record.php?id=%s&check=%s";
foreach($ids as $id) {
	$id=intval($id);
	if(!$SAP->db->updateTS($id,'lastCallTS')) {$totdbproblem++; continue;};
	if(!($fiche=$SAP->db->getUser($id))) {$totdbproblem++; continue;};
	if(!$fiche['mail']) {$totnoaddress++; continue;};
	$url=sprintf($urlformat,$fiche['id'],$fiche['akey']);
	$mail->importBody($mcontent);
	$mail->fillGaps(array('{{GIVENNAME}}'=>$fiche['givenName'],
	'{{FICHEPERSO}}'=>$url));
	$mail->mail($fiche['mail']);
	$recipients[]=$fiche['mail'];
	// $mail->mail('bob@localhost');
	$totmailsent++;
	};
$a=new WSa(true,0,'OK',array("totdbproblem"=>$totdbproblem,
	'totnoaddress'=>$totnoaddress,
	'totmailsent'=>$totmailsent,
	'recipients'=>$recipients));
$a->send();
exit();
?>
