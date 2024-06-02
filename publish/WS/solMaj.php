<?
include('../mini.inc.php');
include('global.inc.php');
include('WSa.class.php');
include('TMail.class.php');
use LMKbits\WSa;
use LMKbits\T;
use LMKbits\TMail;

if(!$SAP->gpaccess()) {$a=new WSa(false,1,'INVALIDACCESSKEY');$a->send();exit;};
if(!$SAP->isAdmin()) {$a=new WSa(false,2,'NEEDADMINPRIV');$a->send();exit;};
$ids=T::gp('ids',array());
if(!is_array($ids)) {$a=new WSa(false,3,'INCORRECTPARM','ids');$a->send();exit;};
$msg=T::gp('msg','sol-1');
$testaddress=T::gp('testaddress');

$totdbproblem=0;
$totnoaddress=0;
$totmailsent=0;
$recipients=array();
$mail=new TMail();
$mcontent=$SAP->getTrad()->i18nfile("mails/$msg.txt");
$urlformat=SITE."/record.php?id=%s&check=%s";
$printcardformat=SITE."/WS/getCard.php?id=%s&check=%s&jpeg=X";
foreach($ids as $id) {
	$id=intval($id);
	if(!$SAP->db->updateTS($id,'lastCallTS')) {$totdbproblem++; continue;};
	if(!($fiche=$SAP->db->getUser($id))) {$totdbproblem++; continue;};
	if(!$fiche['mail']) {$totnoaddress++; continue;};
	$url=sprintf($urlformat,$fiche['id'],$fiche['akey']);
	$printcard=sprintf($printcardformat,$fiche['id'],$fiche['akey']);
	$mail->importBody($mcontent);
	$mail->fillGaps(array(
		'{{GIVENNAME}}'=>$fiche['givenName'],
		'{{FICHEPERSO}}'=>$url,
		'{{PRINTCARD}}'=>$printcard,
		));
	$dest=($testaddress)? $testaddress:implode(', ',preg_split('/[\s,]+/',trim($fiche['mail'])));
	$recipients[]=$fiche['mail'];
	$mail->mail($dest);
	//$mail->mail('maurice@localhost');
	$totmailsent++;
	};
$a=new WSa(true,0,'OK',array("totdbproblem"=>$totdbproblem,
	'totnoaddress'=>$totnoaddress,
	'totmailsent'=>$totmailsent,
	'realdest'=>$dest,
	'recipients'=>$recipients));
$a->send();
exit();
?>
