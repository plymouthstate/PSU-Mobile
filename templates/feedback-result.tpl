{* Set a response class based on the response *}
{if $response.success}
	{assign var='response_class' value='success'}
{elseif $response.error}
	{assign var='response_class' value='error'}
{/if}

{* Begin jQuery Mobile Page *}
{jqm_page id="feedback-results" class="m-app"}
	{jqm_header title="Feedback" back_button="true"}{/jqm_header}

	{jqm_content}
		{* Feedback results here *}
		<div class="vertically-centered">
			<div class="form-response {$response_class} ui-corner-all ui-shadow">
				<header>
					<h1>{$response.response.title}</h1>
				</header>
				<p>{$response.response.message}</p>
				<a href="{$PHP.BASE_URL}/" data-role="button" data-direction="reverse" {if !$response.success}data-rel="back"{/if}>Ok</a>
			</div>
		</div>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
