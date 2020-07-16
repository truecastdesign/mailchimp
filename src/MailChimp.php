<?php
namespace Truecast;

/**
 * MailChimp
 *
 * @author Daniel Baldwin
 * @version 1.0.0
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
	public function __construct($apiKey)
	{		
		$this->apiKey = $apiKey;
	}
		
	public function add($member, $listId, $status)
	{ 
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

		throw new \Exception($result);		
	}	
}