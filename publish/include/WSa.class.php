<?
class WSa {
public $yes;
public $status;
public $message;
public $answer; // typiquement un tableau
function __construct () {
	$i=func_num_args();
	$a=func_get_args();
	switch($i) {
	case 0: $this->yes=true; break;

	case 2: $this->answer=$a[1];
	case 1: $this->yes=$a[0]; break;

	
	case 4: $this->answer=$a[3];
	case 3: $this->message=$a[2];
		$this->status=$a[1];
		$this->yes=$a[0]; break;
	default: $this->yes=false; break;
	};
	}

function send($optjson=0) {
	header("Content-type: text/plain");
	header('Access-Control-Allow-Origin: *');
	echo json_encode($this,$optjson);
	}

function sendXSOK($optjson=0) {
	header("Content-type: text/plain");
	if (isset($_SERVER['HTTP_ORIGIN']))
        	header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
		else header('Access-Control-Allow-Origin: *');
	echo json_encode($this,$optjson);
	}
};?>
