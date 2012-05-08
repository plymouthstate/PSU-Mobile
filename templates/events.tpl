{* Begin jQuery Mobile Page *}
{jqm_page id="events" class="m-app"}
	{jqm_header title="Events" back_button="true"}{/jqm_header}

	{jqm_content}
		<ul id="events" data-role="listview" data-theme="d" data-filter="true" data-filter-theme="d">
		{foreach from="$feed_data" item="item"}
			<li class="event">
				<a href="{$PHP.BASE_URL}/events/details/{$item.timestamp}" data-ajax="false">
					<h1 class="event-title">{$item.text}</h1>
					<h2>{$item.date_start}</h2>

					{if !$item.time_start && !$item.time_end}
						<p>All Day</p>
					{else}
						<p>{$item.time_start} to {$item.time_end}</p>
					{/if}

					<input type="hidden" name="event-details" value="{$item|@json_encode|@htmlspecialchars}">
				</a>
			</li>
		{/foreach}
		</ul>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
