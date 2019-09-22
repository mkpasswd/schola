<?header('Content-type: text/javascript; charset=utf-8');?>
// <SCRIPT> balise bidon pour affiche syntaxe javascript
function Mess() {}

Mess.facto=function(mes,extra,addedclass,removedclass,pic) {
var plus='';
if(typeof extra != 'undefined') plus='<BR><TT>'+extra+'</TT>'; 
$("#MECONTENT").html('<IMG class="messicon" src="'+SITE+pic+'">'+mes+plus);
$("#MESSAGE").removeClass(removedclass);
$("#MESSAGE").addClass(addedclass);
}

Mess.error=function(mes,extra) {
$('#MEVALID').hide();
Mess.facto(mes,extra,'ui-state-error','ui-state-highlight','/images/mess-error.png');
$("#MESSAGE").slideDown(500,Mess.clear);
}

Mess.info=function(mes,extra) {
$('#MEVALID').hide();
Mess.facto(mes,extra,'ui-state-highlight','ui-state-error','/images/mess-info.png');
$("#MESSAGE").slideDown(500,Mess.clear);
}

Mess.infostay=function(mes,extra) {
$('#MEVALID').show();
Mess.facto(mes,extra,'ui-state-highlight','ui-state-error','/images/mess-info.png');
$("#MESSAGE").slideDown(500);
}

Mess.errorstay=function(mes,extra) {
$('#MEVALID').show();
Mess.facto(mes,extra,'ui-state-error','ui-state-highlight','/images/mess-error.png');
$("#MESSAGE").slideDown(500);
}

Mess.clear=function(lapse) {
if(typeof lapse=='undefined') lapse=3000; 
$("#MESSAGE").fadeOut(lapse);
}

Mess.loading=function() {
     $('#LOADING').show();
	}
	
Mess.ready=function() {
     $('#LOADING').hide();
	}
	
$(function() {
	$('#MECLOSE').click(function() {
		Mess.clear(300);	
	});
})

