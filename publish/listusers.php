<?
include('./mini.inc.php');
include('global.inc.php');
$SAP->header(translate('TITLEUSERLIST'));
?>
<!-- REQUEST PARAMETERS ============================ -->
<STYLE>
DIV.conflist {
	width: 32%;
	vertical-align: top;
	display: inline-block;
	}
</STYLE>
<!-- === -->
<DIV id="where" class="conflist">
<H3><?i18n('WHERESELECTION')?></H3>
<INPUT class='WHEREDEFAULT' TYPE="radio" name="where" id="w4" value="year=<?=$SAP->getConf()->cury?> and hasResigned=false"><LABEL for="w4"><?i18n('WHERECURRENTYEAR')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w8" value="year=<?=$SAP->getConf()->cury?> and hasResigned=false and showAddress=true"><LABEL for="w8"><?i18n('WHERECURRENTYEARANDSHOWADDRESS')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w1" value="" checked><LABEL for="w1"><?i18n('WHEREDEFAULT')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w2" value="hasResigned=false"><LABEL for="w2"><?i18n('WHERENOTRESIGNED')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w3" value="hasResigned=true"><LABEL for="w3"><?i18n('WHERERESIGNED')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w5" value="hasResigned=false and mail<>'' and year=<?=$SAP->getConf()->cury?>"><LABEL for="w5"><?i18n('WHEREYEARNOTRESIGNEDMAIL')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w6" value="lastUserAccessTS is null OR lastUserAccessTS <= DATE_SUB(NOW(), INTERVAL 1 MONTH)"><LABEL for="w6"><?i18n('WHEREFARACCESS')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w7" value="lastUserAccessTS > DATE_SUB(NOW(), INTERVAL 1 MONTH)"><LABEL for="w7"><?i18n('WHERECLOSEACCESS')?></LABEL><BR>
</DIV>
<!-- === -->
<DIV id="sort" class="conflist">
<H3><?i18n('SORTSELECTION')?></H3>
<INPUT class='SORTDEFAULT' TYPE="radio" name="sort" id="s2" value="concat(category,'-',sn,'-',givenName)"><LABEL for="s2"><?i18n('SORTCATEGORY')?></LABEL><BR>
<INPUT TYPE="radio" name="sort" id="s1" value="concat(sn,'-',givenName)" checked><LABEL for="s1"><?i18n('SORTDEFAULT')?></LABEL><BR>
<INPUT TYPE="radio" name="sort" id="s3" value="lastUserAccessTS"><LABEL for="s3"><?i18n('SORTLASTACESS')?></LABEL><BR>
<INPUT TYPE="checkbox" id="reverseOrder"><LABEL for="reverseOrder"><?i18n('SORTREVERSEORDER')?></LABEL>
</DIV>
<!-- === -->
<DIV id="show" class="conflist">
<H3><?i18n('SHOWSELECTION')?></H3>
<INPUT TYPE="checkbox" id="showLastAccess"><LABEL for="showLastAccess"><?i18n('SHOWLASTACESS')?></LABEL><BR>
</DIV>

<!-- ACTION BUTTONS ================================ -->
<DIV class="actionbar">
<BUTTON id="list" title="<?i18n('LISTBUTTONTIP');?>"><?i18n('LISTBUTTON');?><SPAN class="ui-icon ui-icon-gear">S</SPAN></Button>
<BR>
<BUTTON id="solmaj" title="<?i18n('SOLMAJBUTTONTIP');?>" disabled><?i18n('SOLMAJBUTTON');?><SPAN class="ui-icon ui-icon-mail-closed">S</SPAN></Button>
<INPUT id="msg1" type="radio" NAME="msg" value="sol-1" class="msgselect"><Label for="msg1"><?i18n('SOLMAJMSG1LABEL');?></LABEL>
<INPUT id="msg2" type="radio" NAME="msg" value="sol-2" class="msgselect"><Label for="msg2"><?i18n('SOLMAJMSG2LABEL');?></LABEL>
<INPUT id="msg3" type="radio" NAME="msg" value="print-card" class="msgselect"><Label for="msg3"><?i18n('PRINTCARDMSGLABEL');?></LABEL>
<BR>
<BUTTON id="create" title="<?i18n('CREATEBUTTONTIP');?>"><?i18n('CREATEBUTTON');?><SPAN class="ui-icon ui-icon-circle-plus">C</SPAN></Button>
<BUTTON id="csvoutput" title="<?i18n('CSVBUTTONTIP');?>"><?i18n('CSVBUTTON');?><SPAN class="ui-icon ui-icon-disk">D</SPAN></Button>
<INPUT id="flatify" type="checkbox" value="X" ><Label for="flatify"><?i18n('FLATIFYLABEL');?></LABEL>
<BUTTON id="mailinglist" title="<?i18n('MAILINGLISTBUTTONTIP');?>"><?i18n('MAILINLISTBUTTON');?><SPAN class="ui-icon ui-icon-mail-closed">D</SPAN></Button>

<A id="download" download="schola.csv" style="display: none"><SPAN class="ui-icon ui-icon-link">L</SPAN></A>
</DIV>

<!-- <TEXTAREA id="csvtext" cols="128" rows="10"></TEXTAREA>-->

<!-- HTML OUTPUT ZONE ============================== -->
<!-- =======LINE MODEL========= -->
<TABLE style="display: none">
<TBODY id="lmodel">
<TR>
<TD class="numli"></TD>
<TD><INPUT type="checkbox" CLASS="recsel"></TD>
<TD class="category"></TD>
<TD class="givenName"></TD>
<TD class="sn"></TD>
<TD class="mail"><A href=""></A></TD>
<TD class="telephoneNumber"></TD>
<TD class="lastUserAccessTS" style="display: none"></TD>
<TD class="actions">
<A href="" class="record"><SPAN class="ui-icon ui-icon-link"></A>
<A href="" class="userrecord"><SPAN class="ui-icon ui-icon-person"></A>
</TD>
</TR>
<TBODY>
</TABLE>
<!-- =======/LINE MODEL========= -->

<!-- ======= ACTUAL LIST ======= -->
<TABLE class="ULIST">
<THEAD>
<TR>
<TH class="numli"><SPAN id="selcount">0</SPAN>/<SPAN id="count">0</SPAN></TH>
<TH><INPUT type="checkbox" id="selectAll"></TD>
<TH><?i18n('THCATEGORY')?></TH>
<TH><?i18n('THSN')?></TH>
<TH><?i18n('THGIVENNAME')?></TH>
<TH><?i18n('THMAIL')?></TH>
<TH><?i18n('THTELEPHONENUMBER')?></TH>
<TH class="lastUserAccessTS" style="display: none"><?i18n('THLASTUSERACCESSTS')?></TH>
<TH><?i18n('THACTIONS')?></TH>
</TR>
</THEAD>
<TBODY id="ulist">
</TBODY>
<TFOOT>
</TFOOT>
</TABLE>

<SCRIPT>
//CSV CONFIGURATION ==============================
var SEP=';';
var QUOTE='"';
var CR="\n";

// GLOBALS =======================================
var numli=0;
var numsel=0;

// MAIN ==========================================
$(function(){
	$('.WHEREDEFAULT').first().attr('checked',true);
	$('.SORTDEFAULT').first().attr('checked',true);
	postAndFill();
	init();
	});

function init() {
	$('#selectAll').click(function() {
		if($(this).is(':checked')) {
			$('input.recsel').attr('checked',true);
			numsel=numli;
			setselcount();
			}	
		else {
			$('input.recsel').attr('checked',false);
			numsel=0;
			setselcount();
			};
		});
	$('#list').click(function() {
		clearLines();
		postAndFill();
		});
	$('#create').click(create);
	$('#mailinglist').click(mailinglistOutput);
	$('#csvoutput').click(csvOutput);
	$('#solmaj').click(solmaj);
	$('.msgselect').click(function() {
		$('#solmaj').attr('disabled',false);
		});
	$('.recsel').live('click',function() {
		if($(this).is(':checked')) numsel++
		else numsel--;
		setselcount();
		});
	}

// HTML TABLE OUTPUT ==================================
function addLine(res) {
	numli++;
	var html=$('#lmodel').html();
	// console.log(html);
	$('#ulist').append(html);
	var wl=$('#ulist TR').last();
	$(wl).addClass('userline');
	$(wl).find('.recsel').attr('title',res.id).attr('DATA-ID',res.id);
	$(wl).children('.numli').html(numli);
	$(wl).children('.category').html(res.category);
	$(wl).children('.sn').html(res.sn);
	$(wl).children('.givenName').html(res.givenName);
	$(wl).children('.lastUserAccessTS').html(res.lastUserAccessTS);
	$(wl).find('.mail A').attr('href','mailto:'+res.mail).html(res.mail.replace(',','<BR>'));
	$(wl).children('.telephoneNumber').html(res.telephoneNumber);
	$(wl).find('.actions A.record').attr('href','./record.php?id='+res.id);
	$(wl).find('.actions A.userrecord').attr('href','./record.php?id='+res.id+'&check='+res.akey);
	$(wl).show();
	setcount();
	}

function clearLines() {
	numli=numsel=0;
	setcount();
	setselcount();
	// $('.userline').slideUp(400,function() {$(this).remove();});
	$('.userline').remove();
	if(!($('#showLastAccess').is(':checked'))) 
		$('TABLE.ULIST .lastUserAccessTS').hide();
	}

// UTILITIES =====================================
function buildSearchParms() {
	var pdata={};
	pdata.check=JT.getURLParameter('check');
	pdata.adm=JT.getURLParameter('adm');
	pdata.sort=$('input[name=sort]:checked').val();
	if(pdata.sort && $('#reverseOrder').is(':checked')) pdata.sort+=' DESC'; 
	pdata.where=$('input[name=where]:checked').val();
	return pdata;
	}

function setselcount() { $('#selcount').html(numsel); }
function setcount() { $('#count').html(numli); }
function csvquotes(s) {
	if(!s) return '';
	return s.replace(/^\s*[\r\n]/gm,'').trim().replace('"','""');
	}

// MAILING LIST OUTPUT ===========================
// unlike CSV output we do not re-read WS
function mailinglistOutput() {
if(numsel<1) {
	Mess.error("<?asi18n('ERRNOSELECTION');?>");
	return;
	};
var ml=[];
$('input.recsel:checked').each(function() {
	var mails=$(this).parent().parent().find('TD.mail A').attr('href').split(',');
	for(var i=0;i<mails.length;i++) {
		var mail=mails[i].trim().replace('mailto:','');
		if(mail) ml.push(mail.toLowerCase());
		};
	});
ml.sort();
//remove duplicates
ml=Array.from(new Set(ml));
$('#download').attr('href','data:text/plain;charset=utf-8,'+encodeURI(ml.join(CR)));
$('#download').attr('download','schola-emails.txt');
var b=document.getElementById('download');
b.click();
}


// ============= WS Calls functions ==============

// CSV OUTPUT ====================================
function csvOutput() {
if(numsel<1) {
	Mess.error("<?asi18n('ERRNOSELECTION');?>");
	return;
	};
var pdata=buildSearchParms();
$.post(WSBASE+'/listUsers.php',pdata,
	function(res) {
	if(!res.yes) {
		JT.deferr(res);
		JT.mainDisable();
		};
	var count=0;
	var csvheader='';
	var cvsfile='';
	var flatify=$('#flatify').is(':checked');
	console.log('flatify : '+flatify);
	for( i=0;i<res.answer.length;i++) {
		var line=res.answer[i];
		id=line.id;
		if(!(line.id) || !($('input.recsel[DATA-ID='+line.id+']').is(':checked'))) continue;
		count++;
		var csvline='';
		for (var key in line) {
			if(key=='jsonVals'||key=='akey') continue;
			if (line.hasOwnProperty(key)) {
				// console.log('KEY='+key+' VALUE='+line[key]);
				if(count==1) {
					if(csvheader) csvheader+=SEP;
					csvheader+=QUOTE+csvquotes(key)+QUOTE;
					};
				if(csvline) csvline+=SEP;
				if(flatify) csvline+=QUOTE+csvquotes(line[key]).replace(/(\r\n|\r|\n)/g,' ')+QUOTE
				else csvline+=QUOTE+csvquotes(line[key])+QUOTE;
				}		
			};
		if(count==1) csvfile=csvheader;
		csvfile+=CR+csvline;
		};
	// $('#csvtext').html(csvfile);
	// $('#download').attr('href','data:text/csv;charset=utf-8;base64,'+btoa(csvfile));
	$('#download').attr('href','data:text/csv;charset=utf-8,'+encodeURI(csvfile));
	$('#download').attr('download','schola-'+(new Date().toISOString().substr(0,10))+'.csv');
	// $('#download').show();	
	// $('#download').trigger('click');
	var b=document.getElementById('download');
	b.click();
	});
}

// SEARCH AND CRETE HTML TABLE ===================
function postAndFill() {
var pdata=buildSearchParms();
$.post(WSBASE+'/listUsers.php',pdata,
	function(res) {
	if(res.yes)
		{
		for( i=0;i<res.answer.length;i++) addLine(res.answer[i]);
		if($('#showLastAccess').is(':checked')) {
			// console.log('=================');
			$('TABLE.ULIST .lastUserAccessTS').show();
			};
		}
	else {
		JT.deferr(res);
		JT.mainDisable();
		};
	});
}

// CREATE NEW ENTRY ==============================
function create() {
var pdata={};
$.post(WSBASE+'/createUser.php',pdata,
	function(res) {
	if(res.yes)
		{
		window.location='./record.php?id='+res.answer;
		}
	else {
		JT.deferr(res);
		JT.mainDisable();
		};
	});
}

// MAILING BATCH =================================
function solmaj() {
	var ids=[];
	$('.recsel:checked').each(function() {ids.push($(this).attr('DATA-ID'));});
	console.log(ids);
	pdata={};
	pdata.ids=ids;
	// pdata.testaddress='one@toreceiveall';
	pdata.msg=$('input[NAME=msg]:checked').val();
	
	$.post(WSBASE+'/solMaj.php',pdata,
		function(res) {
		if(res.yes)
			{
			JT.defok(res);
			$('.recsel:checked').attr('checked',false).attr('disabled',true);
			}
		else {
			JT.deferr(res);
			};
		});
	}
</SCRIPT>

<?
$SAP->tailer();
?>

