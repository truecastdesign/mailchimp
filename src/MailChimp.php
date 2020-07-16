<?php
namespace Truecast;

/**
 * MailChimp
 *
 * @author Daniel Baldwin
 * @version 1.0.1
 * @copyright 2020 Truecast Design Studio
 */
class MailChimp
{
	private $apiKey;
	/**
	 * construct
	 *
	 * @param 
	 * @author Daniel Baldwin
	 */
	public function __construct(string $apiKey)
	{		
		if (empty($apiKey)) {
			throw new \Exception("API key is missing!");
		}
		$this->apiKey = $apiKey;
	}
		
	public function add(array $member, string $listId, string $status): bool
	{ 
		if (empty($member['email'])) {
			throw new \Exception("Email address is missing!");
		}

		if (empty($member['first_name'])) {
			throw new \Exception("First name is missing!");
		}

		if (empty($listId)) {
			throw new \Exception("List id is missing!");
		}

		if (empty($status)) {
			throw new \Exception("Status is missing!");
		}
		
		$memberId = md5(strtolower($member['email']));

		$dataCenter = substr($this->apiKey, strpos($this->apiKey,'-')+1);
		$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

		$json = json_encode([
		  'email_address' => $member['email'],
		  'status'        => $status, // "subscribed","unsubscribed","cleaned","pending"
		  'merge_fields'  => [
				'FNAME'     => $member['first_name'],
				'LNAME'     => $member['last_name']
		  ]
		]);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $this->apiKey);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);	                                                                                                              
		$result = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($httpCode == 200) {
			return true;
		}

		throw new \Exception($result.' Code:'.$httpCode);		
	}	
}