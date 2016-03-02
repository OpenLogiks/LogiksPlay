<?php
if(!defined('ROOT')) exit('No direct script access allowed');

$sid=substr(_randomid(),0,getConfig("GENERATED_CODE_LENGTH"));
createCookie("LPLAY_SID",$sid);
header("Location:"._link("home/{$sid}"));
exit("<h3>Generating Workspace</h3>");
?>