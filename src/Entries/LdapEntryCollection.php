<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Entries;

use BadMethodCallException;
use function array_key_exists;
use function array_merge;
use function count;
use function current;
use function get_called_class;
use function key;
use function next;
use function reset;
use function sprintf;

/**
 * Represents a collection of LDAP entries.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapEntryCollection implements LdapEntryCollectionInterface
{
	/**
	 * Represents the error message if a method has not been implemented.
	 * @var string
	 */
	protected const ERROR_METHOD_NOT_IMPLEMENTED = 'The method `%s::%s` has not been not implemented.';

	/**
	 * Represents the error message if a LDAP entry does not exist.
	 * @var string
	 */
	protected const ERROR_LDAP_ENTRY_NOT_FOUND = 'The LDAP entry with the index `%d` does not exist.';

	/**
	 * Stores the internal list of LDAP entries.
	 * @var LdapEntryInterface[]
	 */
	private array $ldapEntries = [];

	/**
	 * Constructor method.
	 * @param LdapEntryInterface[] $ldapEntries The initial LDAP entries of the collection.
	 */
	public function __construct( LdapEntryInterface ...$ldapEntries )
	{
		$this->add( ...$ldapEntries );
	}

	/**
	 * {@inheritDoc}
	 */
	public function count(): int
	{
		return count( $this->ldapEntries );
	}

	/**
	 * {@inheritDoc}
	 */
	public function current(): LdapEntryInterface
	{
		return current( $this->ldapEntries );
	}

	/**
	 * {@inheritDoc}
	 */
	public function next(): void
	{
		next( $this->ldapEntries );
	}

	/**
	 * {@inheritDoc}
	 */
	public function key(): ?string
	{
		return key( $this->ldapEntries );
	}

	/**
	 * {@inheritDoc}
	 */
	public function valid(): bool
	{
		return null !== key( $this->ldapEntries );
	}

	/**
	 * {@inheritDoc}
	 */
	public function rewind(): void
	{
		reset( $this->ldapEntries );
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetExists( $index ): bool
	{
		return array_key_exists( $index, $this->ldapEntries );
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetGet( $index ): LdapEntryInterface
	{
		if ( false === array_key_exists( $index, $this->ldapEntries ) )
		{
			throw new LdapEntryNotFoundException(
				sprintf(
					static::ERROR_LDAP_ENTRY_NOT_FOUND,
					$index
				)
			);
		}

		return $this->ldapEntries[ $index ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetSet( $index, $entities ): void
	{
		throw new BadMethodCallException(
			sprintf(
				static::ERROR_METHOD_NOT_IMPLEMENTED,
				get_called_class(),
				__METHOD__
			)
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetUnset( $index ): void
	{
		throw new BadMethodCallException(
			sprintf(
				static::ERROR_METHOD_NOT_IMPLEMENTED,
				get_called_class(),
				__METHOD__
			)
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function toArray(): array
	{
		return $this->ldapEntries;
	}

	/**
	 * {@inheritDoc}
	 */
	public function add( LdapEntryInterface ...$ldapEntries ): void
	{
		$this->ldapEntries = array_merge( $this->ldapEntries, $ldapEntries );
	}
}
