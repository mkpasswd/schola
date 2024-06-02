<?
include('global.inc.php');
use LMKbits\T;

// $w=new WSTools(); tout passé en static

//ecrasage de $_POST dans le cas où un parm jp est passé et qu'il contient du json
// gp($name,$default=NULL,$maxlen=512,$maxtabentries=20)
if(($__jp_ret=T::gp('jp',false,4096)) && !empty($__jp_array=json_decode($__jp_ret,true)) && json_last_error()==JSON_ERROR_NONE) {
	$_POST=$__jp_array;
	$_POST['jp']='X';
	};
?>
