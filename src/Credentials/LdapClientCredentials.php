<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Credentials;

/**
 * Represents LDAP client credentials.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapClientCredentials implements LdapClientCredentialsInterface
{
	/**
	 * Stores the ID of the client.
	 * @var string
	 */
	private string $id;

	/**
	 * Stores the passcode of the client.
	 * @var string
	 */
	private string $passcode;

	/**
	 * Constructor method.
	 * @param string $id The ID of the client.
	 * @param string $passcode The passcode of the client.
	 */
	public function __construct( string $id, string $passcode )
	{
		$this->id       = $id;
		$this->passcode = $passcode;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPasscode(): string
	{
		return $this->passcode;
	}
}
