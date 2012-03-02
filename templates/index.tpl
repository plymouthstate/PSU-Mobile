{* Begin jQuery Mobile Page *}
{jqm_page id="dashboard"}
	{jqm_header}{/jqm_header}

	{jqm_content}
	{* Start dashboard *}
		<nav id="dashboard">
			<ul id="dashboard-mapps">
				<li id="mapp-newsfeed">
					<a href="newsfeed/">
						{iconbox id="news" size="large"}
						News Feed
					</a>
				</li>
				<li id="mapp-campusmap">
					<a href="campusmap/">
						{iconbox id="map" size="large"}
						Campus Map
					</a>
				</li>
				<li id="mapp-directory">
					<a href="directory/">
						{iconbox id="directory" size="large"}
						Directory
					</a>
				</li>
				<li id="mapp-clusters">
					<a href="clusters/">
						{iconbox id="clusters" size="large"}
						Clusters
					</a>
				</li>
				<li id="mapp-feedback">
					<a href="feedback/">
						{iconbox id="feedback" size="large"}
						Feedback
					</a>
				</li>
			</ul>
		</nav>
	{* End dashboard *}
	{/jqm_content}

	{jqm_footer}
		<a id="footer-info-button" class="dashboard-ui-bar-button info-button info-button-open" data-role="button" data-iconpos="notext"></a>
	{/jqm_footer}

	<div id="hidden-info-div">
		<div class="ui-bar-a">
			<a id="hidden-info-button" class="dashboard-ui-bar-button info-button info-button-close" data-role="button" data-iconpos="notext"></a>
		</div>
		<div class="info-panel">
			<div class="big-color-logo"></div>
			<h1 class="app-title">PSU Mobile</h1>
			<h2 class="app-version">Version {$PHP.APP_VERSION}</h2>
			<h3 class="app-build">Build {$PHP.APP_BUILD_NAME} {$PHP.APP_BUILD_TYPE}</h3>
			<h4 class="copyright">Copyright &copy; {$smarty.now|date_format:"%Y"} by <a href="http://plymouth.edu/" target="_blank">Plymouth State University</a></h4>
			<ul class="app-frameworks">
				<li id="jquery-mobile">Proudly built with jQuery Mobile <span></span></li>
				<li class="phonegap-required" id="phonegap">Native API provided by PhoneGap <span></span></li>
			</ul>
		</div>
	</div>
{/jqm_page}
{* End jQuery Mobile Page *}
