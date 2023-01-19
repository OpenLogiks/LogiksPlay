<?php
if(!defined('ROOT')) exit('No direct script access allowed');
//checkServiceSession();
if(isset($_REQUEST['cmd2']) && $_REQUEST['cmd2']=="ping") {
    echo "ok";
} elseif(isset($_REQUEST['lpgsid'])) {
	$sid=$_REQUEST['lpgsid'];
	$codes_dir=getCodeDir($sid);
	$code_cache_dir=getCodeCacheFile($sid);

	if(!is_dir($codes_dir)) {
		printServiceErrorMsg("Sorry, Permission Denied to Create Session Folder");
		exit();
	}

	$f="{$codes_dir}source.cmd";
	if(file_exists($f)) {
	    include $f;
	    handleActionMethodCalls();
	} else {
	    printErr("WrongFormat","Service Not Found");
	}
} else {
	printErr("WrongFormat","Requested Format Ommits Required Fields");
}
?>
