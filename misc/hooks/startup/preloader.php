<?php
$page=explode("/", PAGE);

$fs=scandir(APPROOT.APPS_PLUGINS_FOLDER."modules/");
$fss=[];
foreach ($fs as $fname) {
	if(strpos($fname, "preload_{$page[0]}")===0) {
		$fss[]=$fname;
	}
}
foreach ($fss as $fname) {
	loadModule($fname);
}
?>
