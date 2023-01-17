<?php
if(!defined('ROOT')) exit('No direct script access allowed');

$page=explode("/",PAGE);
$sid="";

if(isset($_REQUEST['regenerate']) && $_REQUEST['regenerate']=="true") {
	$sid=substr(_randomid(),0,getConfig("GENERATED_CODE_LENGTH"));
	createCookie("LPLAY_SID",$sid);
	header("Location:"._link("codespace/{$sid}"));
	exit("<h3>Generating Workspace</h3>");
} elseif(isset($page[1]) && strlen($page[1])>0) {
	$sid=$page[1];
	createCookie("LPLAY_SID",$page[1]);
} elseif(isset($_COOKIE["LPLAY_SID"])) {
	$sid=$_COOKIE["LPLAY_SID"];
	header("Location:"._link("codespace/{$sid}"));
	exit("<h3>Accessing Existing Workspace</h3>");
} else {
	$sid=substr(_randomid(),0,getConfig("GENERATED_CODE_LENGTH"));
	createCookie("LPLAY_SID",$sid);
	header("Location:"._link("codespace/{$sid}"));
	exit("<h3>Generating Workspace</h3>");
}

_pageVar("logiksPlaySID", $sid);
_pageVar("GENERATED_CODE_LENGTH", getConfig("GENERATED_CODE_LENGTH"));

//loadModule("codeEditor");
?>
