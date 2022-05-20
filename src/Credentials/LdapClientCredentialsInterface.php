<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Credentials;

/**
 * Represents the interface of any LDAP client credentials.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapClientCredentialsInterface
{
	/**
	 * Gets the ID of the client.
	 * @return string The ID of the client.
	 */
	public function getId():string;

	/**
	 * Gets the passcode of the client.
	 * @return string The passcode of the client.
	 */
	public function getPasscode():string;
}
