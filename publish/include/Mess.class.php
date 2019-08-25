<?
//
class Mess {
function output() {
?>
<link rel="stylesheet" href="<?echo SITE;?>/mess.css.php">
<DIV id="MESSAGE" class="ui-widget ui-widget-content ui-corner-all info" style="display:none">
<DIV id="MEVALID"><SPAN id="MECLOSE" class="ui-icon ui-icon-circle-close"></SPAN></DIV>
<DIV id="MECONTENT"></DIV>
</DIV>
<DIV id="LOADING" class="loading" style="display:none"><IMG src="<?echo SITE;?>/images/loading.gif"></DIV>
<script src="<?echo SITE;?>/include/Mess.js.php"></script>
<?
} //fin de output
}
?>
