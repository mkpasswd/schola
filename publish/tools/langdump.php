<?
include('../mini.inc.php');
include('global.inc.php');
$SAP->header(translate('TITLELANGDUMP'));
echo'<TEXTAREA cols="80" rows="24">';
echo $SAP->getTrad()->xml();
echo'</TEXTAREA>';
$SAP->tailer();
?>

