<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

use function array_merge;
use function count;
use function current;
use function key;
use function next;
use function reset;

/**
 * Represents a collection of LDAP search filters.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapSearchFilterCollection implements LdapSearchFilterCollectionInterface
{
	/**
	 * Stores the internal list of LDAP search filters.
	 * @var LdapSearchFilterInterface[]
	 */
	private array $ldapSearchFilters = [];

	/**
	 * Constructor method.
	 * @param LdapSearchFilterInterface[] $ldapSearchFilters The initial LDAP search filters of the collection.
	 */
	public function __construct( LdapSearchFilterInterface ...$ldapSearchFilters )
	{
		$this->add( ...$ldapSearchFilters );
	}

	/**
	 * {@inheritDoc}
	 */
	public function count(): int
	{
		return count( $this->ldapSearchFilters );
	}

	/**
	 * {@inheritDoc}
	 */
	public function current(): LdapSearchFilterInterface
	{
		return current( $this->ldapSearchFilters );
	}

	/**
	 * {@inheritDoc}
	 */
	public function next(): void
	{
		next( $this->ldapSearchFilters );
	}

	/**
	 * {@inheritDoc}
	 */
	public function key(): ?string
	{
		return key( $this->ldapSearchFilters );
	}

	/**
	 * {@inheritDoc}
	 */
	public function valid(): bool
	{
		return null !== key( $this->ldapSearchFilters );
	}

	/**
	 * {@inheritDoc}
	 */
	public function rewind(): void
	{
		reset( $this->ldapSearchFilters );
	}

	/**
	 * {@inheritDoc}
	 */
	public function toArray(): array
	{
		return $this->ldapSearchFilters;
	}

	/**
	 * {@inheritDoc}
	 */
	public function add( LdapSearchFilterInterface ...$ldapSearchFilters ): void
	{
		$this->ldapSearchFilters = array_merge( $this->ldapSearchFilters, $ldapSearchFilters );
	}
}
