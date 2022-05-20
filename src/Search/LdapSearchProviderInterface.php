<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search;

use CodeKandis\Ldap\Entries\LdapEntryCollectionInterface;
use CodeKandis\Ldap\Entries\LdapEntryInterface;

/**
 * Represents the interface of any LDAP search provider.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapSearchProviderInterface
{
	/**
	 * Searches the LDAP connection for the first entry only.
	 * @param string The filter string to use for the search.
	 * @param bool $firstLevelOnly True if the search must be performed on the first level only, otherwise false.
	 * @param ?string $context The context to start the search from. If it's omitted the configured server DN will be used.
	 * @param string[] $attributes The list of attributes to search for.
	 * @return ?LdapEntryInterface The first entry of the search results, if any, otherwise null.
	 */
	public function searchFirst( string $filter, bool $firstLevelOnly, ?string $context, array $attributes ): ?LdapEntryInterface;

	/**
	 * Searches the LDAP connection.
	 * @param string $filter The filter string to use for the search.
	 * @param bool $firstLevelOnly True if the search must be performed on the first level only, otherwise false.
	 * @param ?string $context The context to start the search from. If it's omitted the configured server DN will be used.
	 * @param string[] $attributes The list of attributes to search for.
	 * @return LdapEntryCollectionInterface The search results.
	 */
	public function search( string $filter, bool $firstLevelOnly, ?string $context, array $attributes ): LdapEntryCollectionInterface;
}
