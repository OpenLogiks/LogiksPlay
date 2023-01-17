<script type="text/javascript">
$(function() {
	tryLoadHistory();
});

function tryLoadHistory() {
	try {
		workspaceList=localStorage.getItem('lgksplay.workspacelist');

		if(workspaceList==null || workspaceList.length<=2) workspaceList={};
		else workspaceList=$.parseJSON(workspaceList);

		workspaceList[logiksPlaySID]=logiksPlaySID;

		localStorage.setItem('lgksplay.workspacelist',JSON.stringify(workspaceList));

		$("#header .actionbar").prepend("<li class='dropdown'><a href='#' class='actioncmd' cmd='workspaceListUI'><i class='fa fa-tasks fa-fw'></i></a></li>");

		// $("#header .actionbar").prepend("<li class='dropdown workspacelist'><a class='dropdown-toggle' data-toggle='dropdown' href='#'><i class='fa fa-tasks fa-fw'></i>  <i class='fa fa-caret-down'></i></a><ul class='dropdown-menu'></ul></li>");// dropdown-messages

		// defLink=_link("codespace/xxxx");
		// $.each(workspaceList,function(key,title) {
		// 	lx=defLink.replace('xxxx',key);
		// 	$("#header .actionbar .workspacelist ul.dropdown-menu").append("<li><a href='"+lx+"'>"+title+"</a></li>");
		// });
	} catch(e) {
		console.warn("Local Storage Not Supported/Error");
	}
}
function workspaceListUI() {
	alert("LIST");
}
</script>