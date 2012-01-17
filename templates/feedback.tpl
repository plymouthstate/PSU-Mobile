{include file='_header.tpl'}
<!-- Begin jQuery Mobile Page -->
<div data-role="page" id="page-feedback">
	{jqm_header position="fixed"}
		<a href="/webapp/mobile/" class="ui-btn-icon-left" data-rel="back" data-theme="c">back</a>
          <h1 id="header-logo"><span>PSU Mobile</span></h1>
     {/jqm_header}

	{jqm_content}
		<!-- Feedback form here -->
		<form action="#" method="post">
			<fieldset>
				<label for="feedback-email">Your Email Address</label>
				<input type="email" name="email" id="feedback-email" />
			</fieldset>
			<fieldset>
				<label for="feedback-title">Subject/Title</label>
				<input type="text" name="title" id="feedback-title" />
			</fieldset>
			<fieldset>
				<label for="feedback-message">Feedback</label>
				<textarea name="message" id="feedback-message"></textarea>
			</fieldset>
			<fieldset>
				<label for="feedback-feeling">How does it make you feel?</label>
				<select name="feeling" id="feedback-feeling" data-theme="a">
					<option>Happy</option>
					<option>Silly</option>
					<option>Indifferent</option>
					<option>Sad</option>
				</select>
			</fieldset>
			<input type="submit" value="Submit Feedback" />
		</form>
	{/jqm_content}

</div>
<!-- End jQuery Mobile Page -->
{include file='_footer.tpl'}
