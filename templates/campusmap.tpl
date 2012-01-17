{include file='_header.tpl' pre_jq_js=$pre_jq_js post_jq_js=$post_jq_js}
<!-- Begin jQuery Mobile Page -->
<div data-role="page" id="page-campusmap">
	{jqm_header position="fixed"}
		<a href="/webapp/mobile/" class="ui-btn-icon-left" data-rel="back" data-theme="c">back</a>
          <h1 id="header-logo"><span>PSU Mobile</span></h1>
     {/jqm_header}

	{jqm_content}
		<!-- Campus Map -->
		<div id="campus-google-map"></div>
		<!-- Campus Map -->
	{/jqm_content}

</div>
<!-- End jQuery Mobile Page -->
{include file='_footer.tpl'}
