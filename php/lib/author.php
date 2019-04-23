<?php namespace tgray19\ObjectOriented; /*include("Author.php");
	$stefan = new \tgray19\ObjectOriented\ Author(251561,"aviurl","none",
		"testattest", "password", "Stefan M");
	$jimmy = new \tgray19\ObjectOriented\Author(335695, "avatar", "none",
	"emailbro", "password1", "Nick W"
	);

	$stefan-> setAuthorUsername("Stefan Mischook");
	$jimmy->setAuthorUsername("Nick Waddles");

	echo "Stefan's full name: " . $stefan->getAuthorUsername();
	echo "Nick's full name: " . $jimmy->getAuthorUsername();
*/?>
<?php
require_once("Author.php");
require_once(dirname(__DIR__) . "/classes/autoload.php");

use Ramsey\Uuid\Uuid;
use tgray19\ObjectOriented\Author;
$object = new \tgray19\ObjectOriented\Author("9bfacccd-75fe-413e-9886-2bf4e0d7f89e",
	"avatar", "none ", "newemail",
	"dumb dumb", "newAuthorUsername");
