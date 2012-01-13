<?php

namespace Mobile;

class Feedback {

	/**
	 * Validate the posted data 
	 * @param array &$postData An array containing the data that was posted with the form
	 * @param array &$responseData A blank array that will, upon completion, contain the data for the JSON response
	 */
	public static function validate_data(&$postData, &$responseData) {
		// Settings
		$salt = 'q3;hlsd0izsdf9qij345';

		// Create response array
		$responseData = array(
			'success' => false,
			'error' => false,
			'response' => array(
				'title' => 'Feedback Processing Error',
				'message' => 'There was a problem validating your submission.'
			)
		);

		// Clean/Filter the data
		$postData['emailAddress'] = filter_var($postData['emailAddress'], FILTER_SANITIZE_EMAIL);
		$postData['title'] = filter_var($postData['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
		$postData['message'] = filter_var($postData['message'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
		$postData['feeling'] = filter_var($postData['feeling'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);

		// Loop through the post data
		foreach ($postData as $dataKey => $data) {
			// Skip the hidden info
			if ($dataKey == 'hiddenInfo') {
				continue;
			}

			// Check if all data has been filled out
			$trimmed_data = trim($data);
			if (empty($trimmed_data)) {
				$responseData['error'] = true;
				$responseData['response']['title'] = 'Form Validation Error';
				$responseData['response']['message'] = 'Please fill in all fields';
			}
		}

		// Validate the email address
		if (!filter_var($postData['emailAddress'], FILTER_VALIDATE_EMAIL)) {
			$responseData['error'] = true;
			$responseData['response']['title'] = 'Form Validation Error';
			$responseData['response']['message'] = 'Please enter a valid email address';
		}

		// For security, we've sent a timestamp and an MD5 hash
		// Let's take the email address, timestamp, and a shared-salt, and get a MD5 hash from them and compare
		// If they don't check out, we know it wasn't the app :)
		$hash = md5($postData['emailAddress'].$postData['timestamp'].$salt);
		if ($hash != $postData['hash']) {
			$responseData['error'] = true;
			$responseData['response']['title'] = 'Security Error';
			$responseData['response']['message'] = 'Unauthorized request detected';
		}

		return ! $responseData['error'];
	} // End validate_data

	/**
	 * Actually submit the feedback 
	 * @param array &$postData An array containing the data that has been validated
	 * @param array &$responseData An array containing the data for the JSON response
	 */
	public static function submit_feedback(&$postData, &$responseData) {
		// Email settings
		$email_settings = array(
			'email_recip_address' => 'helpdesk@plymouth.edu',
			'subject_prefix' => 'PSU Mobile Feedback'
		);

		// Create headers
		$mail_to = $email_settings['email_recip_address'];
		$mail_subject = $email_settings['subject_prefix'].' - '.$postData['title'];
		$mail_message = 'Feedback:'."\r\n".$postData['message']."\r\n\r\n"
					.'How does it make you feel?:'."\r\n".$postData['feeling']."\r\n\r\n"
					.'Hidden Technical Info:'."\r\n".print_r($postData['hiddenInfo'], true);
		$mail_headers = 'From: '.$postData['emailAddress']."\r\n".'Reply-To: '.$postData['emailAddress'];

		// Mail the recipient
		if (PSU::mail($mail_to, $mail_subject, $mail_message, $mail_headers)) {
			$responseData['success'] = true;
			$responseData['error'] = false;
			$responseData['response']['title'] = 'Feedback Sent Successfully!';
			$responseData['response']['message'] = 'Your feedback was submitted! Thank you!';

			return true;
		}
		else {
			$responseData['error'] = true;
			$responseData['response']['title'] = 'Feedback Processing Error';
			$responseData['response']['message'] = 'There was a processing error. Please try again later.';
		}

		return false;
	} // End submit_feedback

} // End class Feedback
