{config_load file="template.conf" section="footer"}
<div class="footer">
	{#photoCopyright#}<br />
	{#appCopyright#}
	<p>
		<a href="BUG/rss.php">BUG! Subscribe to my RSS Feed</a>
	</p>
</div>
{if $debug_output}
<pre style="text-align:left;">
	{$debug_output}
</pre>
{/if}