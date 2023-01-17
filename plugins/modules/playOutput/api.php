<?php
//Additional functions that can be used to by the users
if(!defined('ROOT')) exit('No direct script access allowed');

if(!function_exists("__template")) {
    
    function __template($data = [], $sqlQuerySet=null) {
        $sid = $_ENV['SID'];
        
        $codes_dir=getCodeDir($sid);
        $code_cache_dir=getCodeCacheFile($sid);

        $tmplFile = "{$codes_dir}source.tpl";
        
        if(file_exists($tmplFile)) {
            return _template($tmplFile, $data, $sqlQuerySet);
        }
        
        return false;
    }
    
    function __templateFetch($data = [], $sqlQuerySet=null) {
        $sid = $_ENV['SID'];
        
        $codes_dir=getCodeDir($sid);
        $code_cache_dir=getCodeCacheFile($sid);

        $tmplFile = "{$codes_dir}source.tpl";
        
        if(file_exists($tmplFile)) {
            return _templateFetch($tmplFile, $data, $sqlQuerySet);
        }
        
        return false;
    }
    
    function __templateData($templateData,$dataArr=null,$sqlData="",$tmplID=null,$editable=true) {
        return _templateData($templateData,$dataArr,$sqlData,$tmplID,$editable);
    }
    
    //function _template($file,$dataArr=null,$sqlQuerySet=null,$tmplID=null) {}
    //function _templateFetch($file,$dataArr=null,$sqlQuerySet=null,$tmplID=null) {}
    //function _templateData($templateData,$dataArr=null,$sqlData="",$tmplID=null,$editable=true) {}
}
?>