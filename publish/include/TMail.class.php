<?

class TMail {
var $from='';
var $body='';
var $subject='';
var $extraheader='';	
var $bary=false;

public function setExtraHeader($eh) {$this->extraheader=$eh;}
public function setBody($body) {$this->body=$body;}
public function addBody($suite) {
	if(is_array($suite)) $this->body=array_merge($this->body,$suite);
	else $this->body[]=$suite;
	}
public function setSubject($subject) {$this->subject=$subject;}
public function setFrom($from) {$this->from=$from;}

// gere la traduction et éventuellement les balises ^Subject: et ^From:
public function importBody($file) {
	$this->body=@file($file);
	//relecture comme un fichier
	if(is_array($this->body)) {
		foreach($this->body as $k=>$v) {
			if(strncasecmp($v,'Subject: ',9)===0) {
				// echo "sub trouve\n";
				$this->subject=substr($v,8);
				$usubject=$k;
				};
			if(strncasecmp($v,'From: ',6)===0) {
				// echo "from trouve\n";
				$this->from=substr($v,6);
				$ufrom=$k;
				};
			};
		if(isset($usubject)) unset($this->body[$usubject]);
		if(isset($ufrom)) unset($this->body[$ufrom]);
		}
	else $this->body=array('-0-');
	/* foreach($this->body as $k=>$v) {
		echo "$k --> $v";
		};
	*/
}

private function boundary() {
	if(!$this->bary) $this->bary=md5(time());
	return $this->bary;
	}
private function addboundary() {
	return "\r\n\r\n--".$this->boundary()."\r\n";
	}

private function head() {
	$header="MIME-Version: 1.0\r\n";
	$header.='Content-Type: multipart/mixed; boundary="'.$this->boundary()."\"\r\n";
	$header.='From: '.$this->from."\r\n";
	if($this->extraheader) $header.=$this->extraheader."\r\n";
	return $header;
	}
	
public function mail($recipient) {
	$header=$this->head();
	$mess='This is a MIME encoded message.';
	$mess.=$this->addboundary();
 	$mess.="Content-type: text/html;charset=utf-8\r\n\r\n";
 	$mess.='<html><head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		</head><body>';
	$mess.=(is_array($this->body))? implode("\n",$this->body):$this->body;
	$mess.='</body></html>';
	$mess.=$this->addboundary();
	mail($recipient,$this->subject,$mess,$header);
}

// les balises de mot-clef sont au format {{mot-clef}}
// par defaut on gère {{SITE}} et {{APPNAME}}
public function fillGaps($tabconv=array()) {
	if(!array_key_exists('{{SITE}}',$tabconv)) $tabconv['{{SITE}}']=SITE;
	if(!array_key_exists('{{APPNAME}}',$tabconv)) $tabconv['{{APPNAME}}']=APPNAME;
	$from=array_keys($tabconv);
	$to=array_values($tabconv);
	$this->subject=str_replace($from,$to,$this->subject);
	$this->from=str_replace($from,$to,$this->from);
	$this->body=str_replace($from,$to,$this->body);
	}

public function enumGaps() {
	}

public function addAttachment($content,$mimetype) {
	}
}

?>
