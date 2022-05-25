<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Entries;

/**
 * Represents the interface of any LDAP entry.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapEntryInterface
{
	/**
	 * Gets the distinguished name.
	 * @return string The distinguished name.
	 */
	public function getDn(): string;

	/**
	 * Gets the data.
	 * @return array The data.
	 */
	public function getData(): array;
}
