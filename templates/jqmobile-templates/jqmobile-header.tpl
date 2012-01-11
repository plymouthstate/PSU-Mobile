{if !$jqm_header.position}
	{assign var='jqm_header.position' value='fixed'}
{/if}

<header data-role="header" data-position="{$jqm_header.position}">
	{$jqm_header.content}
</header>
