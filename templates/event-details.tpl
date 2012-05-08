{* Begin jQuery Mobile Page *}
{jqm_page id="events-details" class="m-app"}
	{jqm_header title="Events" back_button="true"}{/jqm_header}

	{jqm_content}
		<h1>{$event_data->text}</h1>

		{if !$event_data->date_end}
			<h2>{$event_data->date_start}</h2>
		{else}
			<h2>{$event_data->date_start} to {$event_data->date_end}</h2>
		{/if}

		{if !$event_data->time_start && !$event_data->time_end}
			<h3>All Day</h3>
		{else}
			<h3>{$event_data->time_start} to {$event_data->time_end}</h3>
		{/if}

		<p>{$event_data->description}<p>

	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
