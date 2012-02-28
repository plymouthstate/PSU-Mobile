{* Begin jQuery Mobile Page *}
{jqm_page id="directory-details" class="m-app"}
	{jqm_header title="Directory" back_button="true"}{/jqm_header}

	{jqm_content}
		<h1>{$user_data->name}</h1>
		{if $user_data->title}
			<h2>{$user_data->title}</h2>
		{elseif $user_data->major}
			<h2>{$user_data->major}</h2>
		{/if}
		<ul id="directory-details" data-role="listview" data-inset="true" data-theme="d">
			{if $user_data->dept}
			<li>
				Department:
				<p class="ui-li-aside">
					{$user_data->dept}
				</p>
			</li>
			{/if}
			{if $user_data->email}
			<li>
				Email:
				<p class="ui-li-aside">
					<a href="mailto:{$user_data->email}@plymouth.edu">{$user_data->email}@plymouth.edu</a>
				</p>
			</li>
			{/if}
			{if $user_data->phone_office}
			<li>
				Office Phone:
				<p class="ui-li-aside">
					<a href="tel:{$user_data->phone_office}">{$user_data->phone_office}</a>
				</p>
			</li>
			{elseif $user_data->student_voicemail}
			<li>
				Voicemail:
				<p class="ui-li-aside">
					<a href="tel:{$user_data->student_voicemail}">{$user_data->student_voicemail}</a>
				</p>
			</li>
			{/if}
			{if $user_data->mailstop}
			<li>
				Mailbox:
				<p class="ui-li-aside">
					{$user_data->mailstop}
				</p>
			</li>
			{/if}
		</ul>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
