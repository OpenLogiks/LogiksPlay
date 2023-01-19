var popupDlg=null;
var maxExecuteTime = 3;
$(function() {
	$('#codepaneTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		});
	$('#resultpaneTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		});
	$("body").delegate(".actioncmd[cmd]","click",function(e) {
			cmd=$(this).attr('cmd');
			takeAction(cmd,this);
		});
		
	setInterval(function() {
        processAJAXQuery(_service("ping"))
    }, 300000);
});

function takeAction(cmd,src) {
	switch(cmd) {
		case "runCode":
			executeCode();
		break;
		case "resetWorkspace":
			lgksConfirm("Are you sure about reseting your workspace?","Reset Workspace !",function(a) {
				if(a) {
					window.location=_link("regenerate");
				}
			})
		break;
		case "clearWorkspace":
			lgksConfirm("Are you sure about clearing all the editors, this is irreverisble?","Clear Workspace !",function(a) {
				if(a) {
					$.each(editorList,function(k,v) {
							v.setValue("");
						});
				}
			})
		break;
		case "saveWorkspace":
			lgksAlert("Please login to save and share the Playspace.");
		break;

		default:
			if(typeof window[cmd]=="function") {
				window[cmd](src);
			} else {
				console.warn("Cmd Not Supported : "+cmd);
			}
	}
}
function showExcecuteLoader() {
    $(".modal").detach();
    waitingDialog.show(`Running ... <span id='loaderCounter' class='pull-right' data-refid='${maxExecuteTime}'>${maxExecuteTime}</span>`);
    
    setTimeout(function() {
        waitingDialog.hide();
    }, maxExecuteTime*1000);
    
    var a1 = setInterval(function() {
        var counterIndex = $("#loaderCounter").data("refid")-1;
        $("#loaderCounter").data("refid", counterIndex).html(counterIndex);
        if(counterIndex<=0) clearInterval(a1);
    }, 1000);
}
function executeCode() {
	//console.log("Executing Workspace Code");
    showExcecuteLoader();
	arr=getCodeData();
	if($("#codespace .optsTable").length>0) {
		$("select,input","#codespace .optsTable").each(function() {
				nm=$(this).attr("name");
				v=$(this).val();
				if(v!=null) {
					arr.push("options["+nm+"]"+"="+encodeURIComponent(v));
				}
			});
	}
	sid=logiksPlaySID;

	l=_service("runcode")+"&sid="+sid;
	q=arr.join("&");
	processAJAXPostQuery(l,q,function(txt) {
			if(txt.length>0) {
				try {
					json=$.parseJSON(txt);
					if(json.Data.sid!=null) {
						$("#opframe").attr("src",_link("output/"+json.Data.sid));
						//$("#opframe").parents("div.tabs").tabs("select","#tab_op");
						$('#resultpaneTab a[href="#tab_output"]').tab('show')
					} else if(json.ErrorCode!=null) {
						lgksAlert(json.error);
					} else {
						lgksAlert("Code Session Not Found.");
					}
				} catch(e) {
					console.error(e);
					lgksAlert("Code Session Not Found.");
				}
			} else
				lgksAlert("Code Session Not Found.");
		});
}

function checkAll(v,div) {
	$(div).each(function() {this.checked=v;});
}
function closeDialog() {
	popupDlg.dialog("close");
}


function getCodeData() {
	arr=[];
	$.each(editorList,function(k,v) {
		arr.push(k+"="+encodeURIComponent(v.getValue()));
	});
	return arr;
}

function tryLoadSession() {
	//console.log("Trying To Load Old Workspace");

	loadEditorRemote('php');
	loadEditorRemote('css');
	loadEditorRemote('js');
	loadEditorRemote('cmd');
// 	loadEditorRemote('tmpl');
	loadEditorRemote('tpl');

	// $.get(_service('workspace',"opts")+"&sid="+logiksPlaySID,function(txt) {
	// 	try {
	// 		json=$.parseJSON(txt);
	// 		if(json.Data!=null) {

	// 		}
	// 	} catch(e) {
	// 		console.error(e);
	// 	}
	// });

	// $.get(_service('workspace',"info")+"&sid="+logiksPlaySID,function(txt) {
	// 	try {
	// 		json=$.parseJSON(txt);
	// 		if(json.Data!=null) {
				
	// 		}
	// 	} catch(e) {
	// 		console.error(e);
	// 	}
	// });
}
function loadEditorRemote(src) {
	editorList[src].setReadOnly(true);
	//editorList[src].setValue("Loading ...");
	editorList[src].session.getUndoManager().reset();
	$.get(_service('workspace',src)+"&sid="+logiksPlaySID,function(txt) {
		editorList[src].setValue(txt);

		editorList[src].selection.clearSelection()
		editorList[src].setReadOnly(false);
		editorList[src].session.getUndoManager().reset();
	});
}
