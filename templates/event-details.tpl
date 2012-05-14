{* Begin jQuery Mobile Page *}
{jqm_page id="events-details" class="m-app"}
	{jqm_header title="Events" back_button="true"}{/jqm_header}

	{jqm_content}
		<h2>{$event_data->text}</h2>

		{if !$event_data->date_end}
			<h3>{$event_data->date_start}</h3>
		{else}
			<h3>{$event_data->date_start} to {$event_data->date_end}</h3>
		{/if}

		{if !$event_data->time_start && !$event_data->time_end}
			<h4>All Day</h4>
		{else}
			<h4>{$event_data->time_start} to {$event_data->time_end}</h4>
		{/if}

		<div class="event-content">{$event_data->content}</div>

	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
