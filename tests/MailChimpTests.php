<?php

use PHPUnit\Framework\TestCase;

class MailChimpTests extends TestCase
{

	public function setUp(): void
	{
		
	}

	public function testAddingMemberToList()
	{
		$result = false;
		require dirname(__DIR__).'/src/MailChimp.php';
		
		$MailChimp = new \Truecast\MailChimp('apikeyhere');

		$member = ['first_name'=>'John', 'last_name'=>'Doe', 'email'=>'johndoe@gmail.com'];

		try {
			$MailChimp->add($member, 'listidhere', 'pending'); # member array, list id, status
			$result = true;
		} catch (\Exception $ex) {
			# failed
			trigger_error("We were not able to add you to our list. Error: ".$ex->getMessage(), 256);
		}

		$this->assertTrue($result);
	}
}