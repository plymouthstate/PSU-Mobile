{* Clean up the returned data. Make sure it makes sense to display *}
{* Don't let there ever show more computers being used than available *}
{if $cluster.num_computers_used > $cluster.num_computers}
	{assign var="used" value=$cluster.num_computers}
{else}
	{assign var="used" value=$cluster.num_computers_used}
{/if}

{* Don't show a negative number for the number of computers that are free *}
{if $cluster.num_computers_free <= 0}
	{assign var="free" value=0}
{else}
	{assign var="free" value=$cluster.num_computers_free}
{/if}

{* Begin jQuery Mobile Page *}
{jqm_page id="clusters-details" class="m-app"}
	{jqm_header title="Clusters" back_button="true"}{/jqm_header}

	{jqm_content}
		<h1>{$cluster.name}</h1>
		<h2>{$cluster.building} {if $cluster.room}{$cluster.room}{/if}</h2>
		<ul class="cluster-details" data-role="listview" data-inset="true" data-theme="a">
			<li>Total Computers <span class="ui-li-count">{$cluster.num_computers}</span></li>
			<li>Used <span class="ui-li-count">{$used}</span></li>
			<li>Free <span class="ui-li-count">{$free}</span></li>
		</ul>
		<p class="disclaimer">Cluster availability is approximate and does not factor in general classroom usage.</p>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
