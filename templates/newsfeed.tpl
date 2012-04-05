{* Begin jQuery Mobile Page *}
{jqm_page id="newsfeed" class="m-app"}
	{jqm_header title="News Feed" back_button="true"}{/jqm_header}

	{jqm_content}
		<ul id="newsfeed" data-role="listview" data-theme="d">
		{foreach from="$feed_data" item="item"}
			{* Set a lower cased variable of the source name for html attribute usage *}
			{if $item.source|lower != "rss"}
				{assign var='source' value=$item.source|lower}
			{else}
				{assign var='source' value="news"}
			{/if}

			<li class="newsfeed-item {$item.source|lower}">
				<div class="feed-icon">
					{icon id="$source-item" size="large"}
				</div>

				<h1 class="feed-title">{$item.title}</h1>
				<p>{$item.text}</p>
				<p class="ui-li-aside">
					<time datetime="{$item.datetime}">{$item.time_ago} ago</time>
				</p>
			</li>
		{/foreach}
		</ul>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
