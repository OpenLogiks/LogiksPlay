<?php
if(!defined('ROOT')) exit('No direct script access allowed');

if(!function_exists("__resetEnviroment")) {

	loadHelpers("cookies");

	function __resetEnviroment() {
		setConfig("ALLOW_ROOTDB_ACCESS","true");
	}

	function getCodeDir($sid) {
		//{$_SESSION['SESS_USER_ID']}/{$sid}/
		if(isset($_SESSION['SESS_USER_ID']) && strlen($_SESSION['SESS_USER_ID'])>0 && $_SESSION['SESS_USER_ID']!="guest") {
			$dir=getStorageDir("codes/{$_SESSION['SESS_USER_ID']}/{$sid}");
		} else {
			$dir=getStorageDir("codes/{$sid}");
		}
		if(!is_dir($dir)) {
			mkdir($dir,0777,true);
		}
		return $dir;
	}

	function getCodeCacheFile($sid) {
		$dir=_dirTemp("code_cache");
		if(!is_dir($dir)) {
			mkdir($dir,0777,true);
		}
		return "{$dir}/{$_SESSION['SESS_USER_ID']}-{$sid}";
	}

	function getStorageDir($dir) {
		$baseDir=null;
		if(defined("APPS_STORAGE_FOLDER") && file_exists(APPS_STORAGE_FOLDER) && is_dir(APPS_STORAGE_FOLDER)) {
			if(!is_writable(APPS_STORAGE_FOLDER)) {
				echo "<h3>Code Storage Not Writable.</h3>";
				exit();
			}
			$baseDir=APPS_STORAGE_FOLDER;
		} else {
			$baseDir=ROOT.CACHE_APPS_FOLDER.SITENAME."/";
		}
		
		$fx=$baseDir."{$dir}/";
		if(!is_dir($fx)) {
			mkdir($fx,0777,true);
		}
		return $fx;
	}

	// Returns only the file extension (without the period).
	function file_ext($filename) {
	    if( !preg_match('/./', $filename) ) return '';
	    return preg_replace('/^.*./', '', $filename);
	}
	// Returns the file name, less the extension.
	function file_ext_strip($filename){
	    return preg_replace('/.[^.]*$/', '', $filename);
	}

	register_shutdown_function("__resetEnviroment");

	getStorageDir("code");

	if(!isset($_SESSION['SESS_USER_ID']) || strlen($_SESSION['SESS_USER_ID'])<=1) {
		$_SESSION['SESS_USER_ID']="guest";
	}
}
?>
