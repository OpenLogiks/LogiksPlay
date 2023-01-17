<?php
if(!defined('ROOT')) exit('No direct script access allowed');

$page=current(explode("/", PAGE));

if($page=="codespace") {
    if(isset($_SESSION['PLAYHOOKS']['postload'])) {
        foreach($_SESSION['PLAYHOOKS']['postload'] as $mod) {
            if(strlen($mod)>0) loadModule($mod);
        }
    }
}
?>
