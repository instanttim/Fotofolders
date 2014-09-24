{config_load file="template.conf" section="footer"}
<div class="footer">
	{#photoCopyright#}<br />
	Fotofolders v{$version} — {#appCopyright#}
</div>
{if $debug_output}
<pre style="text-align:left;">
	{$debug_output}
</pre>
{/if}