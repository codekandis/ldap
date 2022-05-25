<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Entries;

/**
 * Represents a LDAP entry.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapEntry implements LdapEntryInterface
{
	/**
	 * Stores the data
	 * @var array
	 */
	private array $data;

	/**
	 * Constructor method.
	 * @param array $data The data.
	 */
	public function __construct( array $data )
	{
		$this->data = $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDn(): string
	{
		return $this->data[ 'dn' ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function getData(): array
	{
		return $this->data;
	}
}
