{include file='_header.tpl'}
<!-- Begin jQuery Mobile Page -->
<div data-role="page" id="page-feedback-results" class="m-app">
	{jqm_header position="fixed"}
		<a href="{$PHP.BASE_URL}" class="ui-btn-icon-left" data-rel="back" data-theme="c">back</a>
          <h1 id="header-logo"><span>Feedback</span></h1>
     {/jqm_header}

	{jqm_content}
		<!-- Feedback results here -->
		{php}

		$var = $this->get_template_vars('response'); var_dump($var);

		{/php}
	{/jqm_content}

</div>
<!-- End jQuery Mobile Page -->
{include file='_footer.tpl'}
