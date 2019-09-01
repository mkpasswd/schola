<?php
interface stdErr {
//returns both number and error message
public function getErr(&$num,&$str);
//returns error message 
public function getErrStr();
//returns error message 
public function getErrNum();
//returns error number and message as a string 
public function getErrCombo();
//sets both number and error message
public function setErr($num,$str);
//both methods return true if something is wrong
public function deconne();
public function wtf();
//clears error status
public function clearErr();
}
