{if !$jqm_footer.position}
	{assign var='jqm_footer.position' value='fixed'}
{/if}

<footer data-role="footer" data-position="{$jqm_footer.position}">
	{$jqm_footer.content}
</footer>
