{include file='_header.tpl'}
<!-- Begin jQuery Mobile Page -->
<div data-role="page" id="page-newsfeed" class="m-app">
	{jqm_header position="fixed"}
		<a href="{$PHP.BASE_URL}" class="ui-btn-icon-left" data-rel="back" data-theme="c">back</a>
          <h1 id="header-logo"><span>News Feed</span></h1>
     {/jqm_header}

	{jqm_content}
		<ul id="newsfeed">
		{foreach from="$feed_data" item="item"}
			<li class="newsfeed-item {$item.source|lower}">
				<div class="feed-icon"></div>
				<header>
					{* Truncate the title to a maximum of 28 characters. *}
					<h1 class="feed-title">{$item.title|truncate:28}</h1>
					<time datetime="{$item.datetime}">{$item.time_ago}ago</time>
				</header>
				<p>{$item.text}</p>
			</li>
		{/foreach}
		</ul>
	{/jqm_content}

</div>
<!-- End jQuery Mobile Page -->
{include file='_footer.tpl'}
