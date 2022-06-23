<?php

namespace user;

/**
 * A temporary token to maintain an user connection
 */
class Token extends \core\Token
{
	/**
	 * user id linked to the token
	 *
	 * @var int
	 */
	protected int $id;

}

?>
