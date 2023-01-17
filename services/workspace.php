<?php
if(!defined('ROOT')) exit('No direct script access allowed');
//checkServiceSession();

if(!isset($_REQUEST["action"])) {
	printServiceErrorMsg(500,"Action Not Defined.");
	exit();
}

if(isset($_REQUEST["sid"])) {
	$sid=$_REQUEST["sid"];
} elseif(isset($_COOKIE["LPLAY_SID"])) {
	$sid=$_COOKIE["LPLAY_SID"];
} else {
	printServiceErrorMsg("Sorry, No Active Code Session Found");
	exit();
}


$codes_dir=getCodeDir($sid);

if(!is_dir($codes_dir)) {
	printServiceErrorMsg("Sorry, Permission Denied to Create Session Folder");
	exit();
}

$arrData=array("css"=>"","js"=>"","php"=>"","cmd"=>"","tmpl"=>"");


$a=strtolower($_REQUEST['action']);
//$arrData[strtolower($_REQUEST['action'])]

switch (strtoupper($_REQUEST['action'])) {
	case 'PHP':
	case 'JS':
	case 'CSS':
	case 'TMPL':
    case 'TPL':
	case 'CMD':
		$f="{$codes_dir}source.{$a}";
		if(file_exists($f)) {
			readfile($f);
		} else {
			echo "";
		}
		break;

	case 'OPTS':
		$f="{$codes_dir}config.json";

		if(file_exists($f)) {
			$data=file_get_contents($f);
			if(strlen($data)>=2) {
				$json=json_decode($data,true);
				printServiceMsg($json);
			} else {
				printServiceMsg([]);
			}
		} else {
			printServiceMsg([]);
		}
		break;

	case 'INFO':
		$f="{$codes_dir}info.json";

		printServiceMsg([]);
		break;
}
?>