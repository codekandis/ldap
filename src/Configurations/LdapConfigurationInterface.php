<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Configurations;

/**
 * Represents the interface of any LDAP configuration.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapConfigurationInterface
{
	/**
	 * Gets the name of the server to connect to.
	 * @return string The name of the server to connect to.
	 */
	public function getServerName(): string;

	/**
	 * Gets the port of the server to connect to.
	 * @return int The port of the server to connect to.
	 */
	public function getServerPort(): int;

	/**
	 * Gets the distinguished name of the server to connect to.
	 * @return ?string The distinguished name of the server to connect to.
	 */
	public function getServerDn(): ?string;

	/**
	 * Gets the LDAP protocol version.
	 * @return int The LDAP protocol version.
	 */
	public function getProtocolVersion(): int;

	/**
	 * Gets the additional LDAP options.
	 * @return array[] The additional LDAP options.
	 */
	public function getAdditionalOptions(): array;
}
