{* Begin jQuery Mobile Page *}
{jqm_page id="clusters" class="m-app"}
	{jqm_header title="Clusters" back_button="true"}{/jqm_header}

	{jqm_content}
		<ul data-role="listview" data-theme="a" data-count-theme="d" data-filter="true" data-filter-theme="d">
			{foreach from=$clusters item=cluster}
				{* Clean up the returned data. Make sure it makes sense to display *}
				{* Don't let there ever show more computers being used than available *}
				{if $cluster->num_computers_used > $cluster->num_computers}
					{assign var="used" value=$cluster->num_computers}
				{else}
					{assign var="used" value=$cluster->num_computers_used}
				{/if}

				{* Don't show a negative number for the number of computers that are free *}
				{if $cluster->num_computers_free <= 0}
					{assign var="free" value=0}
				{else}
					{assign var="free" value=$cluster->num_computers_free}
				{/if}

				{if $cluster->public}
				<li data-filtertext="{$cluster->name} {$cluster->building} {if $cluster->room}{$cluster->room}{/if}" class="cluster {if $free}available{else}full{/if}">
					<h1>{$cluster->name}</h1>
					<h2>{$cluster->building} {if $cluster->room}{$cluster->room}{/if}</h2>
					<p>Total Computers: {$cluster->num_computers}</p>
					<span class="ui-li-count">{$free} free</span>
				</li>
				{/if}
			{/foreach}
		</ul>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
