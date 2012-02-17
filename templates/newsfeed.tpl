{* Begin jQuery Mobile Page *}
{jqm_page id="newsfeed" class="m-app"}
	{jqm_header title="News Feed" back_button="true"}{/jqm_header}

	{jqm_content}
		<ul id="newsfeed">
		{foreach from="$feed_data" item="item"}
			<li class="newsfeed-item {$item.source|lower}">
				<div class="feed-icon"></div>
				<header>
					{* Truncate the title to a maximum of 28 characters. *}
					<h1 class="feed-title">{$item.title|truncate:28}</h1>
					<time datetime="{$item.datetime}">{$item.time_ago} ago</time>
				</header>
				<p>{$item.text}</p>
			</li>
		{/foreach}
		</ul>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
