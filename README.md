MailChimp API v3 for signing people up to a mailing list
=======================================

Version: v1.0.1

This library provides a simple MailChimp API v3 to signup people to a mailing list.

Install
-------

To install with composer:

```sh
composer require truecastdesign/mailchimp
```

Requires PHP 7.1 or newer.

Usage
-----

Here's a basic usage example:

Get your API key and list id from MailChimp

Status options are 'pending', 

```php
# composer autoloader
require '/path/to/vendor/autoload.php';

$MailChimp = new \Truecast\MailChimp('kl32j4kl23jklj4l23j4kl23j34-us14');

$member = ['first_name'=>'John', 'last_name'=>'Doe', 'email'=>'johndoe@gmail.com'];

try {
	$MailChimp->add($member, 'listid123456', 'pending'); # member array, list id, status
	# success
	# display a notice or take them somewhere
} catch (\Exception $ex) {
	# failed
	trigger_error("We were not able to add you to our list. Error: ".$ex->getMessage(), 256);
}
```

