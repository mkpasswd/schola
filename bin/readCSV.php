#!/usr/bin/php
<?php
include('../publish/mini.inc.php');
// echo SITE."\n";
// echo ROOT."\n";
// echo ini_get('include_path')."\n";
// return;
include('../publish/include/fastConf.class.php');
include('../publish/include/scholaDB.class.php');
$conf=new fastConf('../publish/data/schola-conf.json');
// var_dump($conf);
$sdb=new scholaDB($conf->dbhost,$conf->dbuser,$conf->dbpass,$conf->dbname);

$tkey=array();
$f=fopen('./export.csv','rt');
while($brutevals=fgetcsv($f)) {
	foreach($brutevals as $k=>$v)
		if(preg_match('/^"(.*)"$/',$v,$matches)) $brutevals[$k]=$matches[1];
	if(empty($tkey)) {
		$tkey=$brutevals;
		echo implode(',',$tkey)."\n";
		continue;
		};
	$vals=array();
	for($i=0;$i<count($tkey);$i++) 
		$vals[$tkey[$i]]=$brutevals[$i];
	$sqvals=array();
	$sqvals['sn']=$vals['Nom'];
	$sqvals['givenName']=$vals['Prenom'];
	$sqvals['mail']=$vals['Email'];
	$sqvals['category']=$vals['Pupitre'];
	$sqvals['year']='2019';
	$sqvals['hasResigned']=false;
	$sqvals['isActive']=true;
	$sqvals['showAddress']=false;
	$sqvals['isAdmin']=false;
	$sqvals['isCAMember']=false;
	$sqvals['isBureauMember']=false;
	$sqvals['telephoneNumber']=trim($vals['MOBILE'].' '.$vals['FIXE']);
	$sqvals['postalAddress']=$vals['Adresse']."\n".$vals['Code Postal']."\n".$vals['Ville'];
	$sqvals['arrivee']=$vals['ARRIVEE'];
	$sdb->insertUser($sqvals);
	// break;
	};
fclose($f);
?>
