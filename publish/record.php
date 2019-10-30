<?
include('./mini.inc.php');
include('global.inc.php');
$SAP->header(translate('TITLEFICHE'));
?>
<!-- ================================= -->
<FIELDSET>
<!-- <INPUT type="hidden" id="id" class="TX"> -->
<LEGEND><?i18n('LEGENDPEDIGREE')?></LEGEND>
<LABEL for="sn"><?i18n('LABELNOM')?></LABEL>
<INPUT type="text" id="sn" class="TX STD">
<BR>

<LABEL for="givenName"><?i18n('LABELPRENOM')?></LABEL>
<INPUT type="text" id="givenName" class="TX STD">
</FIELDSET>

<!-- ================================= -->
<FIELDSET>
<LEGEND><?i18n('LEGENDINSCRIPTION')?> <SPAN id="yearLabel">20xx-20yy</SPAN></LEGEND>
<LABEL><?i18n('LABELDESINSCRIPTION')?></LABEL>
<DIV>
<INPUT name="hasResigned" type="radio" id="inscryes" class="TX" value='0'><LABEL for="inscryes"><?i18n('LABELINSCRYES')?></LABEL>
<BR>
<INPUT name="hasResigned" type="radio" id="inscrno" class="TX" value='1'><LABEL for="inscrno"><?i18n('LABELINSCRNO')?></LABEL>
<BR>
<DIV id="resexplik" style="display: none">
<INPUT name="resReason" type="text" id="resReason" class="TX STD" value=''><BR>
<?i18n('RESREASONTIP');?>
</DIV>
</DIV>
</FIELDSET>

<!-- ================================= -->
<FIELDSET>
<LEGEND><?i18n('LEGENDCONTACTER')?></LEGEND>

<LABEL for="mail"><?i18n('LABELMAIL')?></LABEL>
<INPUT type="text" id="mail" class="TX STD"><SPAN class="ui-icon ui-icon-help" title="<?asi18n('MULTIMAILTIP')?>">?</SPAN>
<BR>

<LABEL for="telephoneNumber"><?i18n('LABELTELEPHONE')?></LABEL>
<INPUT type="text" id="telephoneNumber" class="TX STD">
<BR>

<LABEL for="postalAddress"><?i18n('LABELADRESSE')?></LABEL>
<TEXTAREA id="postalAddress" class="TX STD" rows="3"></TEXTAREA>
</FIELDSET>

<!-- ================================= -->
<FIELDSET>
<LEGEND><?i18n('LEGENDAUTRE')?></LEGEND>

<LABEL><?i18n('LABELPUPITRE')?></LABEL>
<DIV>
<INPUT name="category" type="radio" id="S" value="S" class="TX"><LABEL for="S"><?i18n('LABELSOPRANO')?></LABEL>
<BR><INPUT name="category" type="radio" id="A" value="A" class="TX"><LABEL for="A"><?i18n('LABELALTO')?></LABEL>
<BR><INPUT name="category" type="radio" id="T" value="T" class="TX"><LABEL for="T"><?i18n('LABELTENOR')?></LABEL>
<BR><INPUT name="category" type="radio" id="B" value="B" class="TX"><LABEL for="B"><?i18n('LABELBASSE')?></LABEL>
<BR><INPUT name="category" type="radio" id="X" value="X" class="TX"><LABEL for="X"><?i18n('LABELAUTRE')?></LABEL>
</DIV>
<BR>

<LABEL><?i18n('LABELPUBLIC')?></LABEL><DIV>
<INPUT type="checkbox" id="showAddress" class="TX" value="1"><?i18n('PUBLICTIP')?>
</DIV>
<BR>
</FIELDSET>


<DIV class="actionbar">
<BUTTON id="record" title="<?i18n('RECORDBUTTONTIP');?>"><?i18n('RECORD');?><SPAN class="ui-icon ui-icon-check">S</SPAN></Button>
<BUTTON id="getcard" title="<?i18n('GETCARDBUTTONTIP');?>"><?i18n('GETCARD');?><SPAN class="ui-icon ui-icon-print">P</SPAN></Button>
<BUTTON id="listusers" class="admin" hidden title="<?i18n('LISTUSERBUTTONTIP');?>"><?i18n('LISTUSER');?><SPAN class="ui-icon ui-icon-folder-open">L</SPAN></Button>
</DIV>


<!-- ================================= -->
<FIELDSET id="ADMFS" class="admin" style="display: none">
<LEGEND><?i18n('LEGENDADMIN')?></LEGEND>

<LABEL for="year"><?i18n('LABELANNEE')?></LABEL>
<?=$SAP->yearselect();?>
<BR>

<LABEL for="akey"><?i18n('LABELAKEY')?></LABEL>
<INPUT type="text" id="akey" class="TX STD">
<BR>

<LABEL><?i18n('LABELTAG')?></LABEL>
<DIV>
<INPUT type="checkbox" id="isActive" class="TX" value="1"><LABEL for="isActive"><?i18n('LABELVALIDE')?></LABEL>
<BR>
<INPUT type="checkbox" id="isCAMember" class="TX" value="1"><LABEL for="isCAMember"><?i18n('LABELCA')?></LABEL>
<BR>
<INPUT type="checkbox" id="isBureauMember" class="TX" value="1"><LABEL for="isBureauMember"><?i18n('LABELBUREAU')?></LABEL>
<BR>
<INPUT type="checkbox" id="isAdmin" class="TX" value="1"><LABEL for="isAdmin"><?i18n('LABELDBADM')?></LABEL>
</DIV>
<BR>

<LABEL><?i18n('LABELUSERACCESS')?></LABEL>
<A id="useraccess" HREF=""><SPAN class="ui-icon ui-icon-link">l</SPAN></A>
</FIELDSET>

<FIELDSET id="DATEFS" class="admin" style="display: none">
<LEGEND><?i18n('LEGENDDATES')?></LEGEND>

<LABEL for="lastUserAccessTS"><?i18n('LABELLASTUSERACCESSTS')?></LABEL>
<INPUT type="text" id="lastUserAccessTS" class="DATE" readonly>
<BR>
<LABEL for="lastUserModTS"><?i18n('LABELLASTUSERMODTS')?></LABEL>
<INPUT type="text" id="lastUserModTS" class="DATE" readonly>
<BR>
<LABEL for="modifyTS"><?i18n('LABELMODIFYTS')?></LABEL>
<INPUT type="text" id="modifyTS" class="DATE" readonly>
<BR>
<LABEL for="lastCallTS"><?i18n('LABELLASTCALLTS')?></LABEL>
<INPUT type="text" id="lastCallTS" class="DATE" readonly>
<BR>
<LABEL for="createTS"><?i18n('LABELCREATETS')?></LABEL>
<INPUT type="text" id="createTS" class="DATE" readonly>
<BR>
</FIELDSET>

<A id="download" download="member-card.jpg" hidden><SPAN class="ui-icon ui-icon-link">L</SPAN></A>

<SCRIPT>
var idmember=0;

function fillform(res) {
	//fill up form with user's data
	console.log(res);
//	$('#id').val(res.sn);
	$('#sn').val(res.sn);
	$('#givenName').val(res.givenName);
	$('#mail').val(res.mail);
	$('#year').val(res.year);
	$('#akey').val(res.akey);
	$('#postalAddress').val(res.postalAddress);
	$('#telephoneNumber').val(res.telephoneNumber);
	$('#year').val(res.year);
	$('#modifyTS').val(res.modifyTS);
	$('#createTS').val(res.createTS);
	$('#lastUserAccessTS').val(res.lastUserAccessTS);
	$('#lastCallTS').val(res.lastCallTS);
	$('#lastUserModTS').val(res.lastUserModTS);
	$('#resReason').val(res.resReason);

	if(res.isActive=='1') $('#getcard').show();
	
	//radiobuttons
	if(res.hasResigned=='1') {
		$('#inscrno').attr('checked',true);
		$('#resexplik').slideDown();}
	else $('#inscryes').attr('checked',true);
	$('#'+res.category).attr('checked',true);

	//checkboxes
	$('#showAddress').attr('checked',(res.showAddress=='1'));
	$('#isActive').attr('checked',(res.isActive=='1'));
	$('#isAdmin').attr('checked',(res.isAdmin=='1'));
	$('#isCAMember').attr('checked',(res.isCAMember=='1'));
	$('#isBureauMember').attr('checked',(res.isBureauMember=='1'));

	//other stuff
	var url=SITE+'/record.php?id='+res.id+'&check='+res.akey;
	$('#useraccess').attr('HREF',url);
	$('#yearLabel').html(res.yearLabel);
	
	if(res.currentUserIsAdmin=='1') $('.admin').slideDown();

	$('#listusers').click(function() {document.location='./listusers.php';});

	$('#record').click(function() {
		var pdata=JT.retrieveTX();
		console.log(pdata);
		$.post(WSBASE+'/setUser.php?id='+idmember,pdata,
			function(res) {
				if(res.yes)
				{JT.defok(res);
				console.log(res.answer);
				}
			else {
				JT.deferr(res);
				// JT.mainDisable();
				};
			});
		});

	$('#getcard').click(function() {
		var pdata={};
		$.post(WSBASE+'/getCard.php?id='+idmember,pdata,
			function(res) {
				if(res.yes)
				{
				$('#download').attr('href','data:image/jpeg;base64,'+res.answer);
				var b=document.getElementById('download');
				b.click();
				}
			else {
				JT.deferr(res);
				// JT.mainDisable();
				};
			});
		});
	}

$(function(){
var pdata={};
idmember=pdata.id=JT.getURLParameter('id');
pdata.check=JT.getURLParameter('check');
pdata.adm=JT.getURLParameter('adm');

$('#inscrno').click(function() {$('#resexplik').slideDown();});
$('#inscryes').click(function() {$('#resexplik').slideUp();});

$.post(WSBASE+'/getUser.php',pdata,
	function(res) {
	if(res.yes)
		{fillform(res.answer);}
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

