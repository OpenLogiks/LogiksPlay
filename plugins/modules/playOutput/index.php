<?php
if(!defined('ROOT')) exit('No direct script access allowed');

include_once __DIR__."/api.php";

$arrOut=_slug("sid");

if(!isset($arrOut['sid']) || strlen($arrOut['sid'])<=1) {
	echo "<h1 align=center>Sorry, Session Not Identified</h1>";
	exit();
}

$sid=$arrOut['sid'];

$_ENV['SID'] = $arrOut['sid'];

error_reporting(1);
setConfig("ALLOW_ROOTDB_ACCESS","false");
define("ALLOW_ROOTDB_ACCESS",false);
define("DEBUG_LOG", false);

$codes_dir=getCodeDir($sid);
$code_cache_dir=getCodeCacheFile($sid);

if(!is_dir(dirname($code_cache_dir))) {
	exit("Sorry, Permission Denied to Create Session Cache Folder");
}

$arrData=array("css"=>"","js"=>"","php"=>"","cmd"=>"","tmpl"=>"");
foreach($arrData as $a=>$b) {
	$f="{$codes_dir}source.{$a}";
	if(file_exists($f)) {
		$arrData[$a]=file_get_contents($f);
	}
}
// printArray($arrData);exit();

$jsonConfig="{$codes_dir}config.json";
$jsonData=array();
if(file_exists($jsonConfig)) {
	$jsonData=file_get_contents($jsonConfig);
	if(strlen($jsonData)>0) {
		$jsonData=json_decode($jsonData,true);
	}
}
if(!is_array($jsonData)) $jsonData=array();

$arrData['phpx']="";
foreach ($jsonData as $key => $value) {
	if(strlen($value)<=0) continue;
	switch ($key) {
		case 'js_libs':
			$arrData['phpx']="<?php echo _js(array('".implode("', '", explode(",", $value))."')); ?>\n{$arrData['phpx']}";
		break;
		case 'css_libs':
			$arrData['phpx']="<?php echo _css(array('".implode("', '", explode(",", $value))."')); ?>\n{$arrData['phpx']}";
		break;
	}
}


$sesionCacheFile="{$code_cache_dir}.php";
$data="";
$data.=$arrData['phpx'];
$data.="<style>".$arrData['css']."</style>";
$data.=$arrData['php'];
$data.="<script>".$arrData['js']."</script>";
file_put_contents($sesionCacheFile,$data);

define("PLAYSID",$sid);

echo _css(explode(",", DEFAULT_OUTPUT_CSS));
echo _js(explode(",", DEFAULT_OUTPUT_JS));

loadModule("playScripts");
//printExtraScripts($sid);

include $sesionCacheFile;
unlink($sesionCacheFile);

?>
<script>
if(window==parent || parent.logiksPlaySID!="<?=$sid?>") {
	window.location="<?=_link('info')?>";
}
</script>