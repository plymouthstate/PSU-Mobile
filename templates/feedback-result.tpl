{* Set a response class based on the response *}
{if $response.success}
	{assign var='response_class' value='success'}
{elseif $response.error}
	{assign var='response_class' value='error'}
{/if}

{include file='_header.tpl'}
<!-- Begin jQuery Mobile Page -->
<div data-role="page" id="page-feedback-results" class="m-app">
	{jqm_header position="fixed"}
		<a href="{$PHP.BASE_URL}/" class="ui-btn-icon-left" data-rel="back" data-theme="c">back</a>
          <h1 id="header-logo"><span>Feedback</span></h1>
     {/jqm_header}

	{jqm_content}
		<!-- Feedback results here -->
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

</div>
<!-- End jQuery Mobile Page -->
{include file='_footer.tpl'}
