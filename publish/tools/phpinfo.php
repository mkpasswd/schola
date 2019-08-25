<?
include('../mini.inc.php');
include('global.inc.php');
$SAP->header(translate('TITLEDEBUG'));
echo "<H3>Singleton de session</H3>\n";
T::dump($SAP);
echo "<H3>phpinfo</H3>\n";
phpinfo(INFO_ENVIRONMENT| INFO_VARIABLES);
$SAP->tailer();
?>

