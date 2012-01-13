{include file='_header.tpl'}
<!-- Begin jQuery Mobile Page -->
<div data-role="page">
	{jqm_header position="fixed"}
          <h1 id="header-logo"><span>PSU Mobile</span></h1>
     {/jqm_header}

	{jqm_content}
		<ul id="newsfeed">
		{foreach from="$feed_data" item="item"}
			<li class="newsfeed-item {$item->source|lower}">
				<div class="feed-icon"></div>
				<header>
					<h1 class="feed-title">{$item->title}</h1>
					<time datetime="{$item->datetime}">{$item->time_ago}ago</time>
				</header>
				<p>{$item->text}</p>
			</li>
		{/foreach}
		</ul>
	{/jqm_content}

</div>
<!-- End jQuery Mobile Page -->
{include file='_footer.tpl'}
