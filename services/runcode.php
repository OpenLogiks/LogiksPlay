<?php
if(!defined('ROOT')) exit('No direct script access allowed');
//checkServiceSession();

if(isset($_REQUEST["sid"])) {
	$sid=$_REQUEST["sid"];
} elseif(isset($_COOKIE["LPLAY_SID"])) {
	$sid=$_COOKIE["LPLAY_SID"];
} else {
	printServiceErrorMsg(500, "Sorry, No Active Code Session Found");
	exit();
}

$codes_dir=getCodeDir($sid);
	
if(!is_dir($codes_dir)) {
	printServiceErrorMsg(400, "Sorry, Permission Denied to Create Session Folder");
	exit();
}

if(isset($_POST)) {
	$arrData=array("css"=>"","js"=>"","php"=>"","cmd"=>"","tmpl"=>"");
	foreach($arrData as $a=>$b) {
		$f="{$codes_dir}source.{$a}";
		if(isset($_POST[$a])) {
			file_put_contents($f,trim($_POST[$a]));
			//$_SESSION[$sid][$a]=trim($_POST[$a]);
			unset($_POST[$a]);
		}
	}
	if(isset($_POST['options'])) {
		$jsonData=json_encode($_POST['options']);
	} else {
		$jsonData=json_encode([]);
	}
	$f="{$codes_dir}config.json";
	file_put_contents($f,$jsonData);

	printServiceMSG(["sid"=>$sid,"timestamp"=>date("Y-m-d H:i:s")]);
} else {
	printServiceErrorMsg(404,"Sorry, Content Not Found");
}
?>
