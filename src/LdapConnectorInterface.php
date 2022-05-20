<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap;

use CodeKandis\Ldap\Credentials\LdapClientCredentialsInterface;
use CodeKandis\Ldap\Search\LdapMembershipDeterminatorInterface;
use CodeKandis\Ldap\Search\LdapSearchProviderInterface;

/**
 * Represents the interface of any LDAP connector.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapConnectorInterface extends LdapSearchProviderInterface, LdapMembershipDeterminatorInterface
{
	/**
	 * Gets the current state of the connector.
	 * @return int The current state of the connector.
	 */
	public function getState(): int;

	/**
	 * Gets the server DN based on the configured server DN or, if null, based on the configured server name.
	 * @return string The server DN.
	 */
	public function getServerDn(): string;

	/**
	 * Authenticates at the LDAP server.
	 * @param LdapClientCredentialsInterface $clientCredentials The credentials of the client.
	 */
	public function authenticate( LdapClientCredentialsInterface $clientCredentials ): void;
}
