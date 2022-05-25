<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search;

use CodeKandis\Ldap\Entries\LdapEntryInterface;
use CodeKandis\Ldap\LdapErrorMessageBuilderInterface;
use CodeKandis\Ldap\LdapHandleInvalidException;
use CodeKandis\Ldap\Search\Filters\LdapSearchComparisonEqualToFilter;
use CodeKandis\Ldap\Search\Filters\LdapSearchLogicalAndOperatorFilter;
use function array_map;
use function count;
use function get_resource_type;
use function in_array;
use function is_resource;

/**
 * Represents a LDAP membership determinator.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapMembershipDeterminator implements LdapMembershipDeterminatorInterface
{
	/**
	 * Represents the error message if a LDAP handle is invalid.
	 * @var string
	 */
	protected const ERROR_INVALID_LDAP_HANDLE = 'The type of the LDAP handle is invalid. Resource of type `ldap link` expected.';

	/**
	 * Stores the LDAP handle of the connection.
	 * @var ?resource The LDAP handle of the connection.
	 */
	private $ldapHandle;

	/**
	 * Stores the distinguished name of the server.
	 * @var string The distinguished name of the server.
	 */
	private string $serverDn;

	/**
	 * Stores the error message builder used to build error messages.
	 * @var LdapErrorMessageBuilderInterface
	 */
	private LdapErrorMessageBuilderInterface $errorMessageBuilder;

	/**
	 * Constructor method.
	 * @param resource $ldapHandle The LDAP handle of the connection.
	 * @param string $serverDn The distinguished name of the server.
	 * @param LdapErrorMessageBuilderInterface $errorMessageBuilder The error message builder to use to build error messages.
	 */
	public function __construct( $ldapHandle, string $serverDn, LdapErrorMessageBuilderInterface $errorMessageBuilder )
	{
		if ( false === is_resource( $ldapHandle ) || 'ldap link' !== get_resource_type( $ldapHandle ) )
		{
			throw new LdapHandleInvalidException( static::ERROR_INVALID_LDAP_HANDLE );
		}

		$this->ldapHandle          = $ldapHandle;
		$this->serverDn            = $serverDn;
		$this->errorMessageBuilder = $errorMessageBuilder;
	}

	/**
	 * {@inheritDoc}
	 */
	public function isInGroup( LdapEntryInterface $ldapEntry, string $groupName ): bool
	{
		$searchProvider = new LdapSearchProvider( $this->ldapHandle, $this->serverDn, $this->errorMessageBuilder );

		$recursiveDeterminator = function ( LdapEntryInterface $ldapEntryCurrent ) use ( &$recursiveDeterminator, $ldapEntry, $groupName, $searchProvider )
		{
			$foundEntries = $searchProvider->search(
				( new LdapSearchLogicalAndOperatorFilter(
					new LdapSearchComparisonEqualToFilter( 'objectClass', 'Group' ),
					new LdapSearchComparisonEqualToFilter(
						'member',
						$ldapEntryCurrent->getDn()
					)
				) )
					->getFilterString(),
				false,
				null,
				[
					'dn',
					'name'
				]
			);

			if ( 0 === count( $foundEntries ) )
			{
				return false;
			}

			$transformedFoundEntries = array_map(
				function ( LdapEntryInterface $foundEntry ): string
				{
					return $foundEntry->getData()[ 'name' ][ 0 ];
				},
				$foundEntries->toArray()
			);

			if ( true === in_array( $groupName, $transformedFoundEntries ) )
			{
				return true;
			}

			foreach ( $foundEntries as $foundEntry )
			{
				if ( true === $recursiveDeterminator( $foundEntry ) )
				{
					return true;
				}
			}

			return false;
		};

		return $recursiveDeterminator( $ldapEntry );
	}
}
