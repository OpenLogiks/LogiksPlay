{module src='codeEditor'}
<div class="container-fluid containerMain">
    <div class="row">
        <div id='codespace' class="col-md-6 no-float left-pane">
			<ul id="codepaneTab" class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#tab_php">{_ling("HTML/PHP")}</a></li>
				<li role="presentation"><a href="#tab_css">{_ling("CSS")}</a></li>
				<li role="presentation"><a href="#tab_js">{_ling("JS")}</a></li>
				<li role="presentation"><a href="#tab_tmpl">{_ling("Template")}</a></li>
				<li role="presentation"><a href="#tab_scmd">{_ling("SCMD")}</a></li>
				<li role="presentation hidden-xs hidden-sm"><a href="#tab_opts">{_ling("Options")}</a></li>
				
				<li role="presentation" class='pull-right actioncmd' cmd='clearWorkspace' title='Clear Workspace'><a class='icon' href="#xxx1"><i class='fa fa-recycle'></i></a></li>
			</ul>        	
			<div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="tab_php">
			    	<div class="editor" name='php' type='php' id='editor_php'></div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab_css">
			    	<div class="editor" name='css' type='css' id='editor_css'></div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab_js">
			    	<div class="editor" name='js' type='javascript' id='editor_js'></div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab_tmpl">
			    	<div class="editor" name='tmpl' type='php' id='editor_tmpl'></div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab_scmd">
			    	<div class="editor" name='cmd' type='php' id='editor_cmd'></div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab_opts">
			    	<h1 align="center">COMING SOON!!!</h1>
			    </div>
			</div>
        </div>
        <div id='resultspace' class="col-md-6 no-float right-pane">
        	<ul id="resultpaneTab" class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#tab_output">{_ling("Result/Output")}</a></li>

				<li role="presentation" class='pull-right'><a href="#tab_help">{_ling("Help")}</a></li>
			</ul>        	
			<div class="tab-content" style='height: 100%;'>
			    <div role="tabpanel" class="tab-pane active" id="tab_output">
					<iframe id='opframe' name="opframe" width="100%" height="100%" frameborder="0" scrolling="auto" src='{_link("info")}'>
					</iframe>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab_help">
					<h1 align="center">COMING SOON!!!</h1>
			    </div>
			</div>
        </div>
    </div>
</div>
<script>
var editorList = {};
var logiksPlaySID="{$logiksPlaySID}";
var maxCodeLength={$GENERATED_CODE_LENGTH};
</script>