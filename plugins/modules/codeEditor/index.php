<?php
if(!defined('ROOT')) exit('No direct script access allowed');

if(!isset($_REQUEST['theme'])) $_REQUEST['theme']="github";

$webpath=getWebPath(__DIR__)."/";
$webpath=$webpath."ace/";

$fss=scandir(__DIR__."/ace/");
$fsLang=[];
$fsTheme=[];

foreach ($fss as $fx) {
	if(substr($fx, 0, 5)=="mode-") {
		$fsLang[]=str_replace(".js", "", substr($fx, 5));
	} elseif(substr($fx, 0, 6)=="theme-") {
		$fsTheme[]=str_replace(".js", "", substr($fx, 6));
	}
}
$GLOBALS['CODEEDITOR']=["themes"=>$fsTheme,"langs"=>$fsLang];

?>
<script src="<?=$webpath?>ace.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=$webpath?>ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
<?=_css("cmsEditor")?>
<?=_js("cmsEditor")?>
<?=_js("md5")?>
<script>
var langTools = ace.require("ace/ext-language_tools");
//var beautify = ace.require("ace/ext/beautify");

var defaultEditorConfig={
		"theme":"<?=$_REQUEST['theme']?>",
		"fontsize":'14px',
		"tabsize":4,
		"showPrintMargin":false,
		"highlightActiveLine":true,
		"displayIndentGuides":true,
		"useWrapMode":true,
		"showInvisibles":false,
		"showGutter":true
	};
var editorConfig={};

function initEditor(editorID,mode,theme) {
	ex = ace.edit(editorID);
	ex.setTheme("ace/theme/"+theme);
	ex.session.setMode("ace/mode/"+mode);

	ex.setFontSize(editorConfig.fontsize);
	ex.setShowPrintMargin(editorConfig.showPrintMargin);
	ex.setHighlightActiveLine(editorConfig.highlightActiveLine);
	ex.setDisplayIndentGuides(editorConfig.displayIndentGuides);
	ex.setShowInvisibles(editorConfig.showInvisibles);
	
	ex.getSession().setUseWrapMode(editorConfig.useWrapMode);
	ex.getSession().setTabSize(editorConfig.tabsize);

	ex.renderer.setShowGutter(editorConfig.showGutter);

	ex.setOptions({
	        enableBasicAutocompletion: true,
	        enableSnippets: true,
	        enableLiveAutocompletion: false
	    });

	ex.getSession().setUseWorker(false);

	//initAutocompletion(ex);
	//addCustomCommands(ex);

	// ex.setReadOnly(true);

	return ex;
}

function saveEditorSettings(key,value) {
	editorConfig[key]=value;
	localStorage.setItem('codeEditor.editorconfig',JSON.stringify(editorConfig));
}
function loadEditorSettings() {
	config=localStorage.getItem('codeEditor.editorconfig');
	if(config==null || config.length<=2) {
		editorConfig=defaultEditorConfig;
		localStorage.setItem('codeEditor.editorconfig',JSON.stringify(editorConfig));
	} else {
		config=$.parseJSON(config);
		editorConfig=$.extend(defaultEditorConfig,config)
	}
}

</script>