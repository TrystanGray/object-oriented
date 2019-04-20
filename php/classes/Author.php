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
}