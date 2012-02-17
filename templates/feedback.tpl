{* Begin jQuery Mobile Page *}
{jqm_page id="feedback" class="m-app"}
	{jqm_header title="Feedback" back_button="true"}{/jqm_header}

	{jqm_content}
		{* Feedback form here *}
		<form action="submit" method="post">
			<fieldset>
				<label for="feedback-email">Your Email Address</label>
				<div class="input-container">
					<input type="email" name="email" id="feedback-email" />
				</div>
			</fieldset>
			<fieldset>
				<label for="feedback-title">Subject/Title</label>
				<div class="input-container">
					<input type="text" name="title" id="feedback-title" />
				</div>
			</fieldset>
			<fieldset>
				<label for="feedback-message">Feedback</label>
				<div class="input-container">
					<textarea name="message" id="feedback-message"></textarea>
				</div>
			</fieldset>
			<fieldset>
				<label for="feedback-feeling">How does it make you feel?</label>
				<div class="input-container">
					<select name="feeling" id="feedback-feeling" data-theme="a">
						<option>Happy</option>
						<option>Silly</option>
						<option>Indifferent</option>
						<option>Sad</option>
					</select>
				</div>
			</fieldset>
			<fieldset>
				<div class="input-container">
					<input type="submit" value="Submit Feedback" id="feedback-submit" />
				</div>
			</fieldset>
		</form>
	{/jqm_content}

{/jqm_page}
{* End jQuery Mobile Page *}
