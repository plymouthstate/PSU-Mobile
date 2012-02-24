{* Begin jQuery Mobile Page *}
{jqm_page id="directory" class="m-app"}
	{jqm_header title="Directory" back_button="true"}{/jqm_header}

	{jqm_content}
		<h1>Search</h1>
		<form action="search" method="get" data-ajax="false">
			<input type="search" name="query" id="directory-search" data-theme="g">
		</form>

		<h2>Important Phone Numbers</h2>
		<ul data-role="listview" data-inset="true" data-theme="a">
			<li>
				ITS Helpdesk
				<p class="ui-li-aside">
					<a href="tel:(603) 535-2929">(603) 535-2929</a>
				</p>
			</li>
			<li>
				Office of the Registrar
				<p class="ui-li-aside">
					<a href="tel:(603) 535-2345">(603) 535-2345</a>
				</p>
			</li>
			<li>
				Student Account Services
				<p class="ui-li-aside">
					<a href="tel:(603) 535-2215">(603) 535-2215</a>
				</p>
				{* <p class="ui-li-aside">
					<a href="tel:or (877) 846-5755">or (877) 846-5755</a>
				</p> *}
			</li>
			<li>
				College of Graduate Studies
				<p class="ui-li-aside">
					<a href="tel:(603) 535-2636">(603) 535-2636</a>
				</p>
				{* <p class="ui-li-aside">
					<a href="tel:or (800) FOR-GRAD">or (800) FOR-GRAD</a>
				</p> *}
			</li>
		</ul>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
