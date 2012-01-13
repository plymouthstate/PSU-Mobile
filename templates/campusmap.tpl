{include file='_header.tpl' pre_jq_js=$pre_jq_js post_jq_js=$post_jq_js}
<!-- Begin jQuery Mobile Page -->
<div data-role="page">
	{jqm_header position="fixed"}
          <h1 id="header-logo"><span>PSU Mobile</span></h1>
     {/jqm_header}

	{jqm_content}
		<!-- Campus Map -->
		<div id="campus-google-map"></div>
		<!-- Campus Map -->
	{/jqm_content}

</div>
<!-- End jQuery Mobile Page -->

<!-- Page ending JS -->
<script type="text/javascript">
	$(function() {ldelim}
		// Create a Google Map
		var yourStartLatLng = new google.maps.LatLng(43.758976, -71.688709);
		$('div#campus-google-map').gmap({ldelim}'center': yourStartLatLng{rdelim});
	{rdelim});
</script>
<!-- Page ending JS -->

{include file='_footer.tpl'}
