<?
//stdErr implementation to be included in class
//if not entirely rewritten from scratch
private $errn=0;
private $errstr='';

public function getErr(&$num,&$str) {
	$num=$this->errn;
	$str=$this->errstr;
	}

public function getErrStr() { return $this->errstr;}
public function getErrNum() { return $this->errn;}
public function getErrCombo() { return '['.$this->errn.'] '.$this->errstr;}

public function setErr($num,$str) {
	$this->errn=$num;
	$this->errstr=$str;
	return ($num===0);
	}

public function deconne() {return ($this->errn!==0);}
public function wtf() {return $this->deconne();}

public function clearErr() {
	$this->setErr(0,'');
	}

?>
