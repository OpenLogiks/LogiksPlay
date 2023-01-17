<?php
if(!defined('ROOT')) exit('No direct script access allowed');

$playHookConfig = json_decode(file_get_contents(APPROOT."config/playhooks.json"), true);
if(!$playHookConfig) $playHookConfig = [];

$_SESSION['PLAYHOOKS'] = $playHookConfig;

$page=current(explode("/", PAGE));

if($page=="codespace") {
    if(isset($_SESSION['PLAYHOOKS']['preload'])) {
        foreach($_SESSION['PLAYHOOKS']['preload'] as $mod) {
            if(strlen($mod)>0) loadModule($mod);
        }
    }
}
if($page=="output") {
    if(isset($_SESSION['PLAYHOOKS']['output'])) {
        foreach($_SESSION['PLAYHOOKS']['output'] as $mod) {
            if(strlen($mod)>0) loadModule($mod);
        }
    }
}

?>
