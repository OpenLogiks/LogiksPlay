<?php
if(!defined('ROOT')) exit('No direct script access allowed');

$page=explode("/",PAGE);
$sid="";

if(isset($_REQUEST['regenerate']) && $_REQUEST['regenerate']=="true") {
	$sid=substr(_randomid(),0,getConfig("GENERATED_CODE_LENGTH"));
	createCookie("LPLAY_SID",$sid);
	header("Location:"._link("home/{$sid}"));
	exit("<h3>Generating Workspace</h3>");
} elseif(isset($page[1]) && strlen($page[1])>0) {
	$sid=$page[1];
	createCookie("LPLAY_SID",$page[1]);
} elseif(isset($_COOKIE["LPLAY_SID"])) {
	$sid=$_COOKIE["LPLAY_SID"];
	header("Location:"._link("home/{$sid}"));
	exit("<h3>Accessing Existing Workspace</h3>");
} else {
	$sid=substr(_randomid(),0,getConfig("GENERATED_CODE_LENGTH"));
	createCookie("LPLAY_SID",$sid);
	header("Location:"._link("home/{$sid}"));
	exit("<h3>Generating Workspace</h3>");
}

loadModule("codeEditor");
?>
<script>
var editorList = {};
var logiksPlaySID="<?=$sid?>";
var maxCodeLength=<?=getConfig("GENERATED_CODE_LENGTH")?>;
$(function() {
	loadEditorSettings();

	$(".editor[type]").each(function() {
		name=$(this).attr('name');
		refid=$(this).attr('id');
		mode=$(this).attr('type');
		
		theme=editorConfig.theme;
		
		ex=initEditor(refid,mode,theme);

		//initAutocompletion(ex);
		addCustomCommands(ex);

		editorList[name]=ex;
	});

	//$("#editorToolbar .themelist li[rel='"+editorConfig.theme+"']").addClass("active");
});
function initAutocompletion(editor) {
	editor.completers.push({
		    getCompletions: function(editor, session, pos, prefix, callback) {
		      	var wordList = ["foo", "bar", "baz"];
		        callback(null, wordList.map(function(word) {
		            return {
		                caption: word,
		                value: word,
		                meta: "static"
		            };
		        }));
		    }
		  });

	// rhymeCompleter = {
 //        getCompletions: function(editor, session, pos, prefix, callback) {
 //            if (prefix.length === 0) { callback(null, []); return }
 //            // $.getJSON(
 //            //     "http://rhymebrain.com/talk?function=getRhymes&word=" + prefix,
 //            //     function(wordList) {
 //            //         // wordList like [{"word":"flow","freq":24,"score":300,"flags":"bc","syllables":"1"}]
 //            //         callback(null, wordList.map(function(ea) {
 //            //             return {name: ea.word, value: ea.word, score: ea.score, meta: "rhyme"}
 //            //         }));
 //            //     });
 //        }
 //    }
 //    langTools.addCompleter(rhymeCompleter);
}
function addCustomCommands(editor) {
	// add command to lazy-load keybinding_menu extension
    // editor.commands.addCommand({
    //     name: "showKeyboardShortcuts",
    //     bindKey: {win: "Ctrl-.", mac: "Command-."},
    //     exec: function(editor) {
    //         ace.config.loadModule("ace/ext/keybinding_menu", function(module) {
    //             module.init(editor);
    //             editor.showKeyboardShortcuts()
    //         })
    //     }
    // });
    editor.commands.addCommand({
    	name: "saveSource",
    	bindKey: {win: "Ctrl-s", mac: "Command-s"},
    	exec: function(editor) {
    		executeCode();
    	}
    });
    editor.execCommand("showKeyboardShortcuts");
}

function doEditorAction(cmd,src,editor) {
	switch(cmd) {
		case "language":
			lang=$(src).attr("rel");
			editor.session.setMode("ace/mode/"+lang);

			$("#editorToolbar .langlist .active").removeClass("active");
			$(src).addClass("active");
		break;
		case "theme":
			theme=$(src).attr("rel");
			editor.setTheme("ace/theme/"+theme);

			$("#editorToolbar .themelist .active").removeClass("active");
			$(src).addClass("active");

			saveEditorSettings('theme',theme);
		break;
		case "settings":
			editor.showSettingsMenu();
		break;
	}
}
</script>