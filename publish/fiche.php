<?
include('./mini.inc.php');
include('global.inc.php');
$SAP->header(translate('TITLEFICHE'));
?>
<!-- ================================= --!>
<FIELDSET>
<LEGEND><?i18n('LEGENDPEDIGREE')?></LEGEND>
<LABEL for="nom"><?i18n('LABELNOM')?></LABEL>
<INPUT type="text" id="nom" class="TX STD">
<BR>

<LABEL for="prenom"><?i18n('LABELPRENOM')?></LABEL>
<INPUT type="text" id="prenom" class="TX STD">
</FIELDSET>

<!-- ================================= --!>
<FIELDSET>
<LEGEND><?i18n('LEGENDCONTACTER')?></LEGEND>

<LABEL for="mail"><?i18n('LABELMAIL')?></LABEL>
<INPUT type="text" id="mail" class="TX STD">
<BR>

<LABEL for="telephone"><?i18n('LABELTELEPHONE')?></LABEL>
<INPUT type="text" id="telephone" class="TX STD">
<BR>

<LABEL for="adresse"><?i18n('LABELADRESSE')?></LABEL>
<TEXTAREA id="adresse" class="TX STD" rows="3"></TEXTAREA>
</FIELDSET>

<!-- ================================= --!>
<FIELDSET>
<LEGEND><?i18n('LEGENDAUTRE')?></LEGEND>

<LABEL><?i18n('LABELPUPITRE')?></LABEL>
<DIV>
<INPUT name="pupitre" type="radio" id="soprano" class="TX"><LABEL for="soprano"><?i18n('LABELSOPRANO')?></LABEL>
<BR><INPUT name="pupitre" type="radio" id="alto" class="TX"><LABEL for="alto"><?i18n('LABELALTO')?></LABEL>
<BR><INPUT name="pupitre" type="radio" id="tenor" class="TX"><LABEL for="tenor"><?i18n('LABELTENOR')?></LABEL>
<BR><INPUT name="pupitre" type="radio" id="basse" class="TX"><LABEL for="basse"><?i18n('LABELBASSE')?></LABEL>
<BR><INPUT name="pupitre" type="radio" id="autre" class="TX"><LABEL for="autre"><?i18n('LABELAUTRE')?></LABEL>
</DIV>
<BR>

<LABEL><?i18n('LABELPUBLIC')?></LABEL><DIV>
<INPUT type="radio" id="public" class="TX"><?i18n('PUBLICTIP')?>
</DIV>
<BR>
</FIELDSET>

<!-- ================================= --!>
<FIELDSET id="ADMFS" class="admin">
<LEGEND><?i18n('LEGENDADMIN')?></LEGEND>

<LABEL for="annee"><?i18n('LABELANNEE')?></LABEL>
<SELECT id="annee">
</SELECT>
<BR>

<LABEL><?i18n('LABELTAG')?></LABEL>
<DIV>
<INPUT type="checkbox" id="valide" class="TX"><LABEL for="valide"><?i18n('LABELVALIDE')?></LABEL>
<BR>
<INPUT type="checkbox" id="ca" class="TX"><LABEL for="ca"><?i18n('LABELCA')?></LABEL>
<BR>
<INPUT type="checkbox" id="bureau" class="TX"><LABEL for="bureau"><?i18n('LABELBUREAU')?></LABEL>
<BR>
<INPUT type="checkbox" id="dbadm" class="TX"><LABEL for="dbadm"><?i18n('LABELDBADM')?></LABEL>
</DIV>
</FIELDSET>

<FIELDSET id="DATEFS" class="admin">
<LEGEND><?i18n('LEGENDDATES')?></LEGEND>

<LABEL for="usermodif"><?i18n('LABELUSERMODIF')?></LABEL>
<INPUT type="text" id="usermodif" class="DATE" readonly>
<BR>

<LABEL for="admmodif"><?i18n('LABELADMMODIF')?></LABEL>
<INPUT type="text" id="admmodif" class="DATE" readonly>
<BR>

<LABEL for="soluser"><?i18n('LABELSOLUSER')?></LABEL>
<INPUT type="text" id="soluser" class="DATE" readonly>
</FIELDSET>

<?
$SAP->tailer();
?>

