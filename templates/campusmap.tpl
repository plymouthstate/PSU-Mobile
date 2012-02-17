{* Begin jQuery Mobile Page *}
{jqm_page id="campusmap" class="m-app"}
	{jqm_header title="Campus Map" back_button="true"}{/jqm_header}

	{jqm_content}
		{* Campus Map *}
		<div id="campus-google-map"></div>
		{* Campus Map *}
	{/jqm_content}

	{* Begin Page Specific JS *}

	<script src="{$PHP.BASE_URL}/js/jquery.ui.map.full.min.js"></script>

	{* End Page Specific JS *}
{/jqm_page}
{* End jQuery Mobile Page *}
