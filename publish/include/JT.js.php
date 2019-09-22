<?header('Content-type: text/javascript; charset=utf-8');
include('../mini.inc.php');
include('global.inc.php');
?>
// <SCRIPT> balise bidon pour affiche syntaxe javascript

var SITE='<?echo SITE;?>'; 
var WSBASE='<?echo SITE;?>/WS'; 

// Initialisation
$(function() {
	$.ajaxSetup({dataType:'json'});
	$(document).ajaxError(function() {
		// console.log('erreur ajax');
		Mess.error("<?asi18n('ERRJSONDEFUNC');?>");
		JT.mainDisable();
		});
	$(document).ajaxSend(function() { Mess.loading(); });
	$(document).ajaxStop(function() { Mess.ready(); });
});

function JT() {};

//===================================

JT.getURLParameter=function(name,def) {
        var ret=decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
        if( !ret && def) return def
        return ret
        };

JT.mainDisable=function() {
	$('#MAIN input,#MAIN select,#MAIN button').attr('disabled',true);
	$('#MAIN *').addClass('disabled');
	$('#MAIN').addClass('disabled');
	};

//===================================
// AFFICHAGE DES ERREURS
JT.deferr=function(res) {
switch(res.message) {
	case 'NODATA': Mess.error("<?asi18n('ERRNODATA');?>",res.message);
		break;
	default : Mess.error("<?asi18n('ERRDEFAULT');?>",res.message);
	};
};
JT.defok=function(res) {
switch(res.message) {
	default: Mess.info("<?asi18n('BONNARD');?>");
	};
};

//===================================
//===================================
JT.mainEnable=function() {
	$('#MAIN input,#MAIN select,#MAIN button').attr('disabled',false);
	$('#MAIN').removeClass('disabled');
	};

//===================================
//===================================
JT.mailFormatOK=function(mail) {
	return mail.match(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i);
	};

//===================================
//===================================
// on prend tous les champs TX et on construit un tableau pdata
// si le name existe et que c'est un tableau (machin[]) pdata[machin] est un tableau de valeurs.
JT.retrieveTX=function() {
var pdata= {};
var regtab=/^(.*)\[\]$/;
 $('.TX').each(function(index) {
	var tab=false;
	var tag=$(this).prop('tagName');
	var type=$(this).attr('type');
	var id=$(this).attr('id');
	var name=$(this).attr('name');
	// console.log("checkbox "+id+"   "+name);
	if(name) {id=name;}; // name prioritaire sur id, en particulier pur gérer les radio
		// on peut avoir plusieurs ID pour un même name radio
	val='';
	//recuperation de la valeur dans val en fonction du type de champ de saisie
	switch(tag) {
	case 'INPUT' : 
		if(type=='radio') {
			//multi id pour meme name dans radio : on vhange d'id si name est defini
			if(pdata[id]) val=pdata[id]; //vraiment naze ce fonctionnement sur checkbox...
			if($(this).attr('checked')) {
				val=$(this).attr('value');
				// console.log("VALUE ="+val+"=");
				}
			break;
			};
		if(type=='checkbox') {
			// val=($(this).attr('checked'))? 'x':'';
			val='0';
			if($(this).attr('checked')) {
				val=$(this).attr('value');
				if(!val) val='1';
				};
			break;
			};
	// quid d'un select avec multiple selection ???
	case 'SELECT' :
	case 'DIV' :  //cas pour un datepicker
	case 'TEXTAREA' :
		val=$(this).val();
		break;
	};
	// enregistrement dans pdata, dans un tableau si c'est un champt HTML tableau
	// console.log('RetrieveTX Enregistrement valeur pour '+id+' ('+val+')');
	if(regtab.exec(id)) {
		tab=true;
		id=RegExp.$1;
		};
	if (tab) {
		if(!pdata[id]) pdata[id]=[];
		pdata[id][pdata[id].length]=val;
		}
	else { pdata[id]=val; };
	});
return pdata;
};


