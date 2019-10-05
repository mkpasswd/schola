<?
include('./mini.inc.php');
include('global.inc.php');
$SAP->header(translate('TITLEUSERLIST'));
?>
<!-- ================================= -->
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
<INPUT TYPE="radio" name="where" id="w1" value="" checked><LABEL for="w1"><?i18n('WHEREDEFAULT')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w2" value="hasResigned=false"><LABEL for="w2"><?i18n('WHERENOTRESIGNED')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w3" value="hasResigned=true"><LABEL for="w3"><?i18n('WHERERESIGNED')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w5" value="hasResigned=false and mail<>'' and year=<?=$SAP->getConf()->cury?>"><LABEL for="w5"><?i18n('WHEREYEARNOTRESIGNEDMAIL')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w4" value="year=<?=$SAP->getConf()->cury?>"><LABEL for="w4"><?i18n('WHERECURRENTYEAR')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w6" value="lastUserAccessTS is null OR lastUserAccessTS <= DATE_SUB(NOW(), INTERVAL 1 MONTH)"><LABEL for="w6"><?i18n('WHEREFARACCESS')?></LABEL><BR>
<INPUT TYPE="radio" name="where" id="w7" value="lastUserAccessTS > DATE_SUB(NOW(), INTERVAL 1 MONTH)"><LABEL for="w7"><?i18n('WHERECLOSEACCESS')?></LABEL><BR>
</DIV>
<!-- === -->
<DIV id="sort" class="conflist">
<H3><?i18n('SORTSELECTION')?></H3>
<INPUT TYPE="radio" name="sort" id="s1" value="concat(sn,'-',givenName)" checked><LABEL for="s1"><?i18n('SORTDEFAULT')?></LABEL><BR>
<INPUT TYPE="radio" name="sort" id="s2" value="concat(category,'-',sn,'-',givenName)"><LABEL for="s2"><?i18n('SORTCATEGORY')?></LABEL><BR>
<INPUT TYPE="radio" name="sort" id="s3" value="lastUserAccessTS"><LABEL for="s3"><?i18n('SORTLASTACESS')?></LABEL><BR>
<INPUT TYPE="checkbox" id="reverseOrder"><LABEL for="reverseOrder"><?i18n('SORTREVERSEORDER')?></LABEL>
</DIV>
<!-- === -->
<DIV id="show" class="conflist">
<H3><?i18n('SHOWSELECTION')?></H3>
<INPUT TYPE="checkbox" id="showLastAccess"><LABEL for="showLastAccess"><?i18n('SHOWLASTACESS')?></LABEL><BR>
</DIV>

<DIV class="actionbar">
<BUTTON id="list" class="record"><?i18n('LISTBUTTON');?><SPAN class="ui-icon ui-icon-gear">S</SPAN></Button>
<BR>
<BUTTON id="solmaj" class="record" disabled><?i18n('SOLMAJBUTTON');?><SPAN class="ui-icon ui-icon-mail-closed">S</SPAN></Button>
<INPUT id="msg1" type="radio" NAME="msg" value="sol-1" class="msgselect"><Label for="msg1"><?i18n('SOLMAJMSG1LABEL');?></SPAN>
<INPUT id="msg2" type="radio" NAME="msg" value="sol-2" class="msgselect"><Label for="msg2"><?i18n('SOLMAJMSG2LABEL');?></SPAN>
<BR>
<BUTTON id="create" class="record"><?i18n('CREATEBUTTON');?><SPAN class="ui-icon ui-icon-circle-plus">C</SPAN></Button>
</DIV>

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

<TABLE class="ULIST">
<THEAD>
<TR>
<TH>#</TH>
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
var numli=0;

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
	}

function clearLines() {
	numli=0;
	// $('.userline').slideUp(400,function() {$(this).remove();});
	$('.userline').remove();
	if(!($('#showLastAccess').is(':checked'))) 
		$('TABLE.ULIST .lastUserAccessTS').hide();
	}

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

function init() {
	$('#selectAll').click(function() {
		if($(this).is(':checked')) $('input.recsel').attr('checked',true)
		else $('input.recsel').attr('checked',false);
		});
	$('#list').click(function() {
		clearLines();
		postAndFill();
		});
	$('#create').click(create);
	$('#solmaj').click(solmaj);
	$('.msgselect').click(function() {
		$('#solmaj').attr('disabled',false);
		});
	}

function postAndFill() {
var pdata={};
pdata.check=JT.getURLParameter('check');
pdata.adm=JT.getURLParameter('adm');
pdata.sort=$('input[name=sort]:checked').val();
if(pdata.sort && $('#reverseOrder').is(':checked')) pdata.sort+=' DESC'; 
pdata.where=$('input[name=where]:checked').val();
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

$(function(){
	postAndFill();
	init();
	});
</SCRIPT>
<?
$SAP->tailer();
?>

