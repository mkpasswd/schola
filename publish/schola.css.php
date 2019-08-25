<?header('Content-type: text/css; charset=utf-8');?>
/* <STYLE> */

FIELDSET.fset .SUBSEL, FIELDSET.fset .SEL {display: inline-block}

DIV.BIGINFO H1 {
	color: Gray ;
	text-align: center;
	}

LABEL.OBLIG:before {
	content: "\2663";
	color: tomato;
	}
 
PRE#transcript {background-color: silver;}

.FBLOCK {
	display: inline-block;
	}

INPUT[readonly] {
	background-color: LightGray;
	color: #303030;
	}
.disabled {
	font-family: italic;
	color: silver;
	}

span.ui-icon {
	display: inline-block;
	}

BODY {font-family: sans-serif;
	margin: 0 0 0 0;
	padding: 10px 10px 10px 10px}

P { text-align: justify }

SPAN.period { font-weight: bold ;
	color: silver;
	}

#TAILER { min-height: 35px;}

#HEAD {
	/* padding: 5px 5px 5px 5px; */
	/* height: 110px */
	}
#HEAD IMG {
/* 	height: 85px; */
	margin-top: 0px;
	margin-left: 5px;
	margin-right: 20px;
	margin-bottom: 5px;
	float: left
	}
#HEAD H1 {
	display: inline-block;
	}

#TAILER {
	text-align:left;
	}

#FOOTERAPPNAME {
	display: inline-block;
	text-align:left;
	margin-top: 5px;
	margin-left: 10px;
	}
#ASPROSLOGO {
	float: left;
	}

	
#MAIN {
	position: relative;
	clear: both;
	min-height: 300px;
	margin-top: 5px;
	margin-bottom: 5px;
	padding-left: 5px;
	padding-right: 5px;
	}

#MAIN.disabled * {
	color: silver;
	font-style: italic;
	}

#MAIN .ui-icon {
	display: inline-block;
	}

.iconlink:hover {
	border-radius: 3px;
	background-color: tomato;
	}

.actionbar {
	text-align: center;
	width: 80%;
	margin-left: 10%;
	margin-top: 10px;
	margin-bottom: 10px;
	}
	
/* FIELDSET.fset {
	border-top: 2px dashed goldenrod;
	border-right: 0;
	border-bottom: 0;
	border-left:  0;
	}
*/

INPUT.STD, TEXTAREA.STD {
	width: 50%;
	}

INPUT.DATE {
	width: 20%;
	}

INPUT[readonly] {
	font-style: italic;
	/* color: silver; */
	background-color: kaki;	
	}

#MAIN FIELDSET.admin {
	background-color: lemonchiffon;
	}

#MAIN FIELDSET LABEL, #MAIN FIELDSET LABEL + * {
	display: inline-block;
	}

#MAIN FIELDSET LABEL + * {
	max-width: 75%;
	}

#MAIN FIELDSET LABEL + P {
	margin-top: 0;
	}

#MAIN FIELDSET LABEL + * LABEL {
	border-bottom: 1px dotted silver;
	}

#MAIN FIELDSET > LABEL {
	margin-left: 10px; 
	margin-bottom: 10px;
	margin-right: 10px;
	text-align: right;
	vertical-align: top;
	width: 20%;
/*	height: 100%; pourri dans chrome */
	font-weight: bold;
/*	float: left; */
/*	display: inline-block; */
	}

@media screen and (max-width: 500px) {
	#HEAD IMG { display: none }
	#MAIN FIELDSET LABEL, #MAIN FIELDSET LABEL + * { display: block }
	#MAIN FIELDSET LABEL { 
		margin-bottom: 2px;
		text-align: left; 
		width:85%
		}
	#MAIN FIELDSET LABEL + * { margin-left: 10%; width: 85% }
	#MAIN { min-height: inherit;}
	}

TEXTAREA.SS {
	min-width: 400px
	}

LEGEND {
	font-size: larger;
	font-weight: bold
	}

