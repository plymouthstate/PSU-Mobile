{include file='_header.tpl'}
<!-- Begin jQuery Mobile Page -->
<div data-role="page">
	{jqm_header position="fixed"}
          <h1 id="header-logo"><span>PSU Mobile</span></h1>
     {/jqm_header}

	{jqm_content}
		<p>Newsfeed here</p>
	{/jqm_content}

	{jqm_footer position="fixed"}
		<a href="#" id="footer-info-button" class="dashboard-ui-bar-button info-button info-button-open" data-role="button" data-iconpos="notext"></a>
	{/jqm_footer}

	<div id="hidden-info-div">
		<div class="ui-bar-a">
			<a href="#" class="dashboard-ui-bar-button info-button info-button-close" data-role="button" data-iconpos="notext"></a>
		</div>
		<ul id="mobile-info"></ul>
	</div>
</div>
<!-- End jQuery Mobile Page -->
{include file='_footer.tpl'}
