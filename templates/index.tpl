{include file='_header.tpl'}
<!-- Begin jQuery Mobile Page -->
<div data-role="page" id="page-dashboard">
	{jqm_header position="fixed"}
          <h1 id="header-logo"><span>PSU Mobile</span></h1>
     {/jqm_header}

	{jqm_content}
	<!-- Start dashboard -->
		<nav id="dashboard">
			<ul id="dashboard-mapps">
				<li id="mapp-newsfeed"><a href="newsfeed/">News Feed</a></li>
				<li id="mapp-campusmap"><a href="campusmap/">Campus Map</a></li>
				<li id="mapp-feedback"><a href="feedback/">Feedback</a></li>
			</ul>
		</nav>
	<!-- End dashboard -->
	{/jqm_content}

	{jqm_footer position="fixed"}
		<a href="#" id="footer-info-button" class="dashboard-ui-bar-button info-button info-button-open" data-role="button" data-iconpos="notext"></a>
	{/jqm_footer}

	<div id="hidden-info-div">
		<div class="ui-bar-a">
			<a href="#" id="hidden-info-button" class="dashboard-ui-bar-button info-button info-button-close" data-role="button" data-iconpos="notext"></a>
		</div>
		<ul id="mobile-info"></ul>
	</div>
</div>
<!-- End jQuery Mobile Page -->
{include file='_footer.tpl'}
