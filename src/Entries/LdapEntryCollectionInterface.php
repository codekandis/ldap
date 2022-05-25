<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Entries;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Represents the interface of any LDAP entries collection.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapEntryCollectionInterface extends Countable, Iterator, ArrayAccess
{
	/**
	 * Gets the amount of LDAP entries in the collection.
	 * @return int The amount of LDAP entries in the collection.
	 */
	public function count(): int;

	/**
	 * Gets the current LDAP entry.
	 * @return LdapEntryInterface The current LDAP entry.
	 */
	public function current(): LdapEntryInterface;

	/**
	 * Moves the internal pointer to the next LDAP entry.
	 */
	public function next(): void;

	/**
	 * Gets the name of the current LDAP entry.
	 * @return ?string The name of the current LDAP entry, null if the internal pointer does not point to any LDAP entry.
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
	 * Determines if a specified index exists.
	 * @param int $index The index to determine.
	 * @return bool True if the specified index exists, otherwise false.
	 */
	public function offsetExists( $index ): bool;

	/**
	 * Gets the entry at the specified index.
	 * @param int $index The index of the entry.
	 * @return LdapEntryInterface The entry to get.
	 */
	public function offsetGet( $index ): LdapEntryInterface;

	/**
	 * Sets the entry at the specified index.
	 * @param int $index The index of the entry.
	 * @param LdapEntryInterface $entry The entry to set.
	 */
	public function offsetSet( $index, $entry ): void;

	/**
	 * Unsets the entry at a specified index.
	 * @param int $index The index of the entry.
	 */
	public function offsetUnset( $index ): void;

	/**
	 * Converts the collection into an array.
	 * @return array The converted array.
	 */
	public function toArray(): array;

	/**
	 * Adds LDAP entries to the collection.
	 * @param LdapEntryInterface[] $ldapEntries The LDAP entries to add.
	 */
	public function add( LdapEntryInterface ...$ldapEntries ): void;
}
