<?
include('./mini.inc.php');
include('global.inc.php');
$SAP->header(translate('TITLEUSERLIST'));
?>
<!-- ================================= -->
<TABLE style="display: none">
<TBODY id="lmodel">
<TR>
<TD><INPUT type="checkbox" CLASS="recsel"></TD>
<TD class="category"></TD>
<TD class="givenName"></TD>
<TD class="sn"></TD>
<TD class="mail"><A href=""></A></TD>
<TD class="telephoneNumber"></TD>
<TD class="actions">
<A href="" class="record"><SPAN class="ui-icon ui-icon-link"></A>
</TD>
</TR>
<TBODY>
</TABLE>

<TABLE class="ULIST">
<THEAD>
<TR>
<TH><INPUT type="checkbox" id="selectAll"></TD>
<TH><?i18n('THCATEGORY')?></TH>
<TH><?i18n('THSN')?></TH>
<TH><?i18n('THGIVENNAME')?></TH>
<TH><?i18n('THMAIL')?></TH>
<TH><?i18n('THTELEPHONENUMBER')?></TH>
<TH><?i18n('THACTIONS')?></TH>
</TR>
</THEAD>
<TBODY id="ulist">
</TBODY>
<TFOOT>
</TFOOT>
</TABLE>

<DIV class="actionbar">
<BUTTON id="record" class="record"><?i18n('RECORD');?><SPAN class="ui-icon ui-icon-check">S</SPAN></Button>
</DIV>

<SCRIPT>
function addLine(res) {
	var html=$('#lmodel').html();
	console.log(html);
	$('#ulist').append(html);
	var wl=$('#ulist TR').last();
	$(wl).attr('DATA-ID',res.id);
	$(wl).children('.category').html(res.category);
	$(wl).children('.sn').html(res.sn);
	$(wl).children('.givenName').html(res.givenName);
	$(wl).find('.mail A').attr('href','mailto:'+res.mail).html(res.mail);
	$(wl).children('.telephoneNumber').html(res.telephoneNumber);
	$(wl).find('.actions A.record').attr('href','./record.php?id='+res.id);
	$(wl).show();
	}

function clearLines() {
	}

function init() {
	$('#selectAll').click(function() {
		if($(this).is(':checked')) $('input.recsel').attr('checked',true)
		else $('input.recsel').attr('checked',false);
		});
	}

function fillform(res) {
	//fill up form with user's data
	console.log(res);
	for( i=0;i<res.length;i++) addLine(res[i]);
	}

$(function(){
var pdata={};
pdata.check=JT.getURLParameter('check');
pdata.adm=JT.getURLParameter('adm');

$.post(WSBASE+'/listUsers.php',pdata,
	function(res) {
	if(res.yes)
		{fillform(res.answer);
		init();
		}
	else {
		JT.deferr(res);
		JT.mainDisable();
		};
	});
}
);

</SCRIPT>
<?
$SAP->tailer();
?>

