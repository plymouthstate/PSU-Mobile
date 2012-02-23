{* Begin jQuery Mobile Page *}
{jqm_page id="directory-results" class="m-app"}
	{jqm_header title="Directory" back_button="true"}{/jqm_header}

	{jqm_content}
		<h1>Results</h1>
		<ul data-role="listview" data-inset="true" data-theme="a">
			{foreach from=$results item=result}
				<li class="result">
					<h1>{$result->name}</h1>
					{if $result->title}
						<h2>{$result->title}</h2>
					{/if}
				</li>
			{/foreach}
		</ul>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
