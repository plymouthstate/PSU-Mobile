{* Begin jQuery Mobile Page *}
{jqm_page id="directory-results" class="m-app"}
	{jqm_header title="Directory" back_button="true"}{/jqm_header}

	{jqm_content}
		<h1>Results</h1>
		<ul id="directory-results" data-role="listview" data-inset="true" data-theme="d">
			{foreach from=$results item=result}
				<li class="result">
					<a href="{$PHP.BASE_URL}/directory/user/{$result->email}" data-ajax="false">
						<h1>{$result->name_full}</h1>
						{if $result->title}
							<p>{$result->title}</p>
						{elseif $result->major}
							<p>{$result->major}</p>
						{/if}
						<input type="hidden" name="user-details" value="{$result|@json_encode|@htmlspecialchars}">
					</a>
				</li>
			{/foreach}
		</ul>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
