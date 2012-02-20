{* Begin jQuery Mobile Page *}
{jqm_page id="clusters" class="m-app"}
	{jqm_header title="Clusters" back_button="true"}{/jqm_header}

	{jqm_content}
		<ul data-role="listview" data-theme="a">
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
				<li class="cluster {if $free}available{else}full{/if}">
					<a href="{$cluster->id}">
						{$cluster->name}
						<span class="ui-li-count">{$free}</span>
					</a>
				</li>
				{/if}
			{/foreach}
		</ul>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
