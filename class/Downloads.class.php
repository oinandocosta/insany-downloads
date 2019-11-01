<?php

/*!
 * Class Downloads
 * Programmer by Night Web (www.nightweb.com.br)
 */

class Downloads {

	private $url;
	private $error;
	private $download;

	public function setUrl($msg) {
		$this->url = $msg;
	}

	public function setError($msg) {
		$this->error = $msg;
	}

	public function setDownload($msg) {
		$this->download = $msg;
	}

	public function execPost($url = '', $fields = array(), $errors = array()) {
		$res = new stdClass();
		$res->status = true;
		if(!empty($url)) {
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			if(!empty($fields) && is_array($fields)) {
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			}
			$return = curl_exec($ch);
			curl_close($ch);
			$existing = false;
			foreach($errors as $error) {
				if(strpos($return, $error)) {
					$existing = true;
				}
			}
			if($existing) {
				$res->status   = false;
				$res->message  = 'existing';
			} else {
				$res->status   = true;
				$res->message  = 'registered';
				$res->download = $this->download;
			}
		} else {
			$res->status  = false;
			$res->message = 'url-empty';
		}
		return $res;
	}

	public function sendForm($email = '') {
		$res   = new stdClass();
		$email = filter_var($email, FILTER_SANITIZE_STRING);
		$email = trim($email);
		if(empty($email)) {
			$res->status  = false;
			$res->message = 'email-empty';
		} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$res->status  = false;
			$res->message = 'email-invalid';
		} else {
			$fields = array(
				'EMAIL' => $email
			);
			$res = $this->execPost($this->url, $fields, $this->error);
		}
		return $res;
	}

}