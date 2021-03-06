<?php

namespace tgray19\ObjectOriented;

require_once(dirname(__DIR__) . "/vendor/autoload.php");
require_once("autoload.php");
require_once("author.php");


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
class Author {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id and P.K. for author
	 * @var string Uuid $authorId
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
	 * constructor for this Author
	 *
	 * @param string|Uuid $newAuthorId id of this Author or null if a new Author.
	 * @param string $newAuthorAvatarUrl url for authors avatar.
	 * @param string $newAuthorActivationToken string containing activation token.
	 * @param string $newAuthorEmail authors email address.
	 * @param string $newAuthorHash string for authors password.
	 * @param string $newAuthorUsername string containing authors username.
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newAuthorId, string $newAuthorAvatarUrl, string $newAuthorActivationToken,
										 string $newAuthorEmail, string $newAuthorHash, string $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 *Accessor method for authorId
	 * @return string|Uuid for authorId (or null if new Profile)
	 */
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param  string $newAuthorId value of new author id
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
	 * @return string for avatarUrl
	 */
	public function getAuthorAvatarUrl(): ?string {
		return ($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author avatar url
	 *
	 * @param  string $newAuthorAvatarUrl value of new author url
	 * @throws \InvalidArgumentException if $newAuthorAvatarUrl is not a valid url or insecure
	 * @throws \RangeException if $newAuthorAvatarUrl is over charset
	 * @throws \TypeError if the author avatar url is not a string
	 **/
	public function setAuthorAvatarUrl(?string $newAuthorAvatarUrl): void {
// verify the avatar content is secure
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_URL, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorAvatarUrl) === true) {
			throw(new \InvalidArgumentException("Avatar url is empty or insecure"));
		}

		// verify the avatar content will fit in the database
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw(new \RangeException("avatar content too large"));
		}

		// store the avatar content
		$this->$newAuthorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 *Accessor method for authorActivationToken
	 * @return string for authorActivationToken
	 */
	public function getAuthorActivationToken(): ?string {
		return ($this->authorActivationToken);
	}

	/**
	 * mutator method for author activation token
	 *
	 * @param  string $newAuthorActivationToken value of new author activation token
	 * @throws \InvalidArgumentException if $newAuthorActivationToken is not a valid url or insecure
	 * @throws \RangeException if $newAuthorActivationToken is over charset
	 * @throws \TypeError if the author avatar activation is not a string
	 **/
	public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = $newAuthorActivationToken;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\TypeError("user activation is not valid"));
		}
		//make sure author avatar url is less than 32 characters
		if(strlen($newAuthorActivationToken) > 32) {
			throw(new\RangeException("user activation token has to be less than 32"));
		}
		// convert and store the activation token
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 *Accessor method for authorEmail
	 * @return string for authorEmail
	 */
	public function getAuthorEmail(): ?string {
		return ($this->authorEmail);
	}

	/**
	 * mutator method for author email
	 *
	 * @param  string $newAuthorEmail value of new author email
	 * @throws \InvalidArgumentException if $newAuthorEmail is not a valid email or insecure
	 * @throws \RangeException if $newAuthorEmail is over charset
	 * @throws \TypeError if the author email is not a string
	 **/
	public function setAuthorEmail(?string $newAuthorEmail): void {
// verify the email content is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorEmail) === true) {
			throw(new \InvalidArgumentException("Email is empty or insecure"));
		}

		// verify the email content will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("email content too large"));
		}

		// store the email content
		$this->$newAuthorEmail = $newAuthorEmail;
	}

	/**
	 *Accessor method for authorHash
	 * @return string for authorHash
	 */
	public function getAuthorHash(): ?string {
		return ($this->authorHash);
	}

	/**
	 * mutator method for author hash
	 *
	 * @param  string $newAuthorHash value of new author email
	 * @throws \InvalidArgumentException if $newAuthorHash is not a valid hash key or insecure
	 * @throws \RangeException if $newAuthorHash is over charset
	 * @throws \TypeError if the author hash is not a string
	 **/
	public function setAuthorHash(?string $newAuthorHash): void {
//enforce that the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("Author password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$profileHashInfo = password_get_info($newAuthorHash);
		if($profileHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("Author hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("Author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	}

	/**
	 *Accessor method for authorUsername
	 * @return string for authorUsername
	 */
	public function getAuthorUsername(): ?string {
		return ($this->authorUsername);
	}

	/**
	 * mutator method for author username
	 *
	 * @param  string $newAuthorUsername value of new author username
	 * @throws \InvalidArgumentException if $newAuthorUsername is not a valid hash key or insecure
	 * @throws \RangeException if $newAuthorUsername is over charset
	 * @throws \TypeError if the author username is not a string
	 **/
	public function setAuthorUsername(?string $newAuthorUsername): void {
		// verify the at handle is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("author username is empty or insecure"));
		}
		// verify the username will fit in the database
		if(strlen($newAuthorUsername) > 32) {
			throw(new \RangeException("Username is too large"));
		}
		// store the username
		$this->authorUsername = $newAuthorUsername;
	}

	/**
	 * inserts into authors mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) 
VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl,
			"authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail,
			"authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}


	/**
	 * deletes this Author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE author SET authorEmail = :authorEmail, authorUsername = :authorUsername, 
	authorAvatarUrl = :authorAvatarUrl, authorActivationToken = :authorActivationToken, authorHash = :authorHash  WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl,
			"authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail,
			"authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}
public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
	// sanitize the authorId before searching
	try {
		$authorId = self::validateUuid($authorId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	// create query template
	$query = "SELECT aurthorId, authorProfileId, authorContent, authorDate FROM author WHERE authorId = :authorId";
	$statement = $pdo->prepare($query);
	// bind the author id to the place holder in the template
	$parameters = ["authorId" => $authorId->getBytes()];
	$statement->execute($parameters);
	// grab the author from mySQL
	try {
		$author = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$author = new author($row["authorId"], $row["authorProfileId"], $row["authorContent"], $row["authorDate"]);
		}
	} catch(\Exception $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($author);
}
/**
 * gets the Author by profile id
 *
 * @param \PDO $pdo PDO connection object
 * @param Uuid|string $authorProfileId profile id to search by
 * @return \SplFixedArray SplFixedArray of autuhors found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getAuthorsByAuthorUsername(\PDO $pdo, string $authorUsername) : \SplFixedArray {
	$authorUsername = trim($authorUsername);
	$authorUsername = filter_var($authorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($authorUsername) === true) {
		throw(new \PDOException("Username content is not valid"));
	}
	// create query template
	$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author 
WHERE authorUsername LIKE :authorUsername";
	$statement = $pdo->prepare($query);
	// bind the author profile id to the place holder in the template
	$authorUsername = "%$authorUsername%";
	$parameters = ["authorUsername" => $authorUsername];
	$statement->execute($parameters);
	// build an array of authors
	$authors = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"],
				$row["authorHash"], $row["authorUsername"]);
			$authors[$authors->key()] = $author;
			$authors->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($authors);
}}