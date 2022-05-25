<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

use Countable;
use Iterator;

/**
 * Represents the interface of any LDAP search filter collection.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapSearchFilterCollectionInterface extends Countable, Iterator
{
	/**
	 * Gets the amount of LDAP search filters in the collection.
	 * @return int The amount of LDAP search filters in the collection.
	 */
	public function count(): int;

	/**
	 * Gets the current LDAP search filter.
	 * @return LdapSearchFilterInterface The current LDAP search filter.
	 */
	public function current(): LdapSearchFilterInterface;

	/**
	 * Moves the internal pointer to the next LDAP search filter.
	 */
	public function next(): void;

	/**
	 * Gets the name of the current LDAP search filter.
	 * @return ?string The name of the current LDAP search filter, null if the internal pointer does not point to any LDAP search filter.
	 */
	public function key(): ?string;

	/**
	 * Determines if the current internal pointer position is valid.
	 * @return bool True if the current internal pointer position is valid, otherwise false.
	 */
	public function valid(): bool;

	/**
	 * Rewinds the internal pointer.
	 */
	public function rewind(): void;

	/**
	 * Converts the collection into an array.
	 * @return array The converted array.
	 */
	public function toArray(): array;

	/**
	 * Adds LDAP search filters to the collection.
	 * @param LdapSearchFilterInterface[] $ldapSearchFilters The LDAP search filters to add.
	 */
	public function add( LdapSearchFilterInterface ...$ldapSearchFilters ): void;
}
