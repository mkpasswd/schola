<?
session_name('SCHOLA');
include('Translation.class.php');
include('T.class.php');
include('fastConf.class.php');
include('APSCHOLA.class.php');

@session_start();
if(isset($_SESSION['SAP'])) { $SAP=$_SESSION['SAP']; $SAP->fitLang();}
else {$SAP=new APSCHOLA();$_SESSION['SAP']=$SAP;};

//Translation shortcuts
function i18nurl($u) {global $SAP; echo $SAP->getTrad()->i18nurl($u);};
function i18n($v) {global $SAP; $SAP->getTrad()->i18n(APSCHOLA::ONE,$v);};
function asi18n($v) {global $SAP; $SAP->getTrad()->asi18n(APSCHOLA::ONE,$v);}; //pour javascript
function translate($v) {global $SAP; return $SAP->getTrad()->translate(APSCHOLA::ONE,$v);};
//function i18ncontent($f) {global $tick; return $tick->trad->i18nfilecontent($f);};
function gtrad() {global $SAP; return $SAP->getTrad();};
?>
