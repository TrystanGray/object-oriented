<?php

namespace tgray19\ObjectOriented;

require_once(dirname(__DIR__,2) . "/composer.json/autoload.php");


use Ramsey\Uuid\Uuid;
/**
 * Cross Section of an Author
 *
 * This is a cross section of what is probably stored about an author. This entity is a top level entity that
 * holds the keys to the other entities in this example.
 *
 * @author Trystan Gray <trystangray19@cnm.edu>
 * @version 1.0.0
 **/
class Author  {
	use ValidateUuid;
	/**
	 * id and P.K. for author
	 * @var Uuid $authorId
	 */
	private $authorId;
	/**
	 * Avatar for this Profile;
	 * @var  $authorAvatarUrl
	 **/
	private $authorAvatarUrl;
	/**
	 *This is the activation token verifying author isn't malicious
	 * @var $authorActivationToken
	 */
	private $authorActivationToken;
	/**
	 * This is the authors email, this is a unique index;
	 * @var $authorEmail
	 */
	private $authorEmail;
	/**
	 * This is part of password protection;
	 * @var $authorHash
	 */
	private $authorHash;
	/**
	 * This is the authors username, its unique;
	 * @var $authorUsername
	 */
	private $authorUsername;
	/**
	 *Accessor method for authorId
	 *@return Uuid value of author id (or null if new Profile)
	 */
	public function getAuthorId():Uuid {
		return ($this->authorId);
	}
	/**
	 * mutator method for author id
	 *
	 * @param  Uuid| string $newAuthorId value of new author id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if the author Id is not positive
	 **/
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::ValidateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the author id
		$this->authorId = $uuid;
	}
	/**
	 *Accessor method for authorAvatarUrl
	 *@return avatar url string
	 */
	public function getAuthorAvatarUrl(): ?string {
		return ($this->authorAvatarUrl);
	}
	/**
	 * mutator method for author avatar url
	 *
	 * @param  $string| string $newauthorAvatarUrl value of new author url
	 * @throws \InvalidArgumentException if $newAuthorAvatarUrl is not a valid url or insecure
	 * @throws \RangeException if $newAuthorAvatarUrl is over charset
	 * @throws \TypeError if the author avatar url is not a string
	 **/
	public function setAuthorAvatarUrl(?string $newAuthorAvatarUrl): void {
		if($newAuthorAvatarUrl === null) {
			$this->$authorAvatarUrl = null;
			return;
		}
		$newAuthorAvatarUrl = strtolower(trim($newAuthorAvatarUrl));
		if(ctype_xdigit($newAuthorAvatarUrl) === false) {
			throw(new\RangeException("user url is not valid"));
		}
		//make sure author avatar url is less than 255 characters
		if(strlen($newAuthorAvatarUrl) >255) {
			throw(new\RangeException("user url has to be less than 255"));
		}
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}
		// convert and store the avatar url
		$this->authorAvatarUrl = $string;
	}
/**
 *Accessor method for authorActivationToken
 *@return authorActivationToken string
 */
public function getAuthorActivationToken(): ?string {
	return ($this->authorActivationToken);
}
/**
 * mutator method for author activation token
 *
 * @param  $string| string $newAuthorActivationToken value of new author activation token
 * @throws \InvalidArgumentException if $newAuthorActivationToken is not a valid url or insecure
 * @throws \RangeException if $newAuthorActivationToken is over charset
 * @throws \TypeError if the author avatar activation is not a string
 **/
public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
	if($newAuthorActivationToken === null) {
		$this->$authorActivationToken = null;
		return;
	}
	$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
	if(ctype_xdigit($newAuthorActivationToken) === false) {
		throw(new\RangeException("user activation is not valid"));
	}
	//make sure author avatar url is less than 32 characters
	if(strlen($newAuthorActivationToken) >32) {
		throw(new\RangeException("user activation token has to be less than 32"));
	}
	$this->authorActivationToken = $newAuthorActivationToken;
}
// convert and store the activation token
$this->authorActivationToken = $string;
}

}