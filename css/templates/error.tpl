{$PAGE.CSS}
<div class='container error'>
	{viewpage}
</div>
<script>
if(typeof prettyPrint=='function') {
	$('pre[name=code]').addClass('prettyprint linenums:'+$('pre[name=code]').data('start'));
	prettyPrint();
	$($('.prettyprint .linenums li')[$('pre[name=code]').data('highlight')-$('pre[name=code]').data('start')-1])
	  .addClass('current');
	$($('.prettyprint .linenums li')[$('pre[name=code]').data('highlight')-$('pre[name=code]').data('start')])
	  .addClass('current active');
	$($('.prettyprint .linenums li')[$('pre[name=code]').data('highlight')-$('pre[name=code]').data('start')+1])
	  .addClass('current');
} else if(typeof dp.SyntaxHighlighter=='object') {
	$('pre[name=code]').addClass('php');
	dp.SyntaxHighlighter.HighlightAll('code',true,true,false,$('pre').data('start'),false);
	$($('.dp-highlighter>ol>li')[$('pre').data('highlight')-$('pre').data('start')]).addClass('active current');
}
</script>
