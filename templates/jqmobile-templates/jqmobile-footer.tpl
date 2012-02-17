{if !$jqm_footer.position}
	{assign var='position' value='fixed'}
{else}
	{assign var='position' value=$jqm_footer.position}
{/if}

<footer data-role="footer" data-position="{$position}">
	{$jqm_footer.content}
</footer>
