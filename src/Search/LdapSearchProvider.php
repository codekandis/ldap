<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search;

use CodeKandis\Ldap\Entries\LdapEntry;
use CodeKandis\Ldap\Entries\LdapEntryCollection;
use CodeKandis\Ldap\Entries\LdapEntryCollectionInterface;
use CodeKandis\Ldap\Entries\LdapEntryInterface;
use CodeKandis\Ldap\LdapErrorMessageBuilderInterface;
use CodeKandis\Ldap\LdapHandleInvalidException;
use function count;
use function get_resource_type;
use function is_array;
use function is_int;
use function is_resource;
use function ldap_get_entries;
use function ldap_list;
use function ldap_search;
use function sprintf;

/**
 * Represents a LDAP search provider.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapSearchProvider implements LdapSearchProviderInterface
{
	/**
	 * Represents the error message if a LDAP handle is invalid.
	 * @var string
	 */
	protected const ERROR_INVALID_LDAP_HANDLE = 'The type of the LDAP handle is invalid. Resource of type `ldap link` expected.';

	/**
	 * Represents the error message if a LDAP search has been failed.
	 * @var string
	 */
	protected const ERROR_SEARCH_FAILED = 'The LDAP search failed. %s.';

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
	 * Executes a native PHP LDAP search.
	 * @param string $filter The filter string to use for the search.
	 * @param bool $firstLevelOnly True if the search must be performed on the first level only, otherwise false.
	 * @param ?string $context The context to start the search from. If it's omitted the configured server DN will be used.
	 * @param string[] $attributes The list of attributes to search for.
	 * @return resource The search results.
	 */
	private function executeNativeSearch( string $filter, bool $firstLevelOnly, ?string $context, array $attributes )
	{
		$preparedContext = null === $context
			? $this->serverDn
			: $context;

		$searchResult = false === $firstLevelOnly
			? @ldap_search( $this->ldapHandle, $preparedContext, $filter, $attributes )
			: @ldap_list( $this->ldapHandle, $preparedContext, $filter, $attributes );

		if ( false === $searchResult )
		{
			throw new LdapSearchFailedException(
				sprintf(
					static::ERROR_SEARCH_FAILED,
					$this->errorMessageBuilder
						->build( $this->ldapHandle )
				)
			);
		}

		return $searchResult;
	}

	/**
	 * Purges the clutter from the search results.
	 * @param array $searchResultData The search results to purge.
	 * @return array The purged search results.
	 */
	private function getPurgedSearchResultData( array $searchResultData ): array
	{
		unset( $searchResultData[ 'count' ] );

		$purgedSearchResultData = [];
		foreach ( $searchResultData as $attributeName => $attributeValue )
		{
			if ( true === is_int( $attributeName ) )
			{
				continue;
			}

			if ( true === is_array( $attributeValue ) )
			{
				unset( $attributeValue[ 'count' ] );
			}

			$purgedSearchResultData[ $attributeName ] = $attributeValue;
		}

		return $purgedSearchResultData;
	}

	/**
	 * Converts the search result into a list of LDAP entries.
	 * @param resource $searchResult The search result to convert.
	 * @param bool $firstLevelOnly True if the conversion must be on the first level only, otherwise false.
	 * @return LdapEntryCollectionInterface The list of LDAP entries.
	 */
	private function convertSearchResult( $searchResult, bool $firstLevelOnly ): LdapEntryCollectionInterface
	{
		$convertedSearchResult = ldap_get_entries( $this->ldapHandle, $searchResult );

		$ldapEntries = new LdapEntryCollection();

		$ldapEntriesCount  = count( $convertedSearchResult ) - 1;
		$upperLoopBoundary = false === $firstLevelOnly
			? $ldapEntriesCount
			: ( 0 === $ldapEntriesCount
				? 0
				: 1 );
		for ( $n = 0; $n < $upperLoopBoundary; $n++ )
		{
			$ldapEntries->add(
				new LdapEntry(
					$this->getPurgedSearchResultData( $convertedSearchResult[ $n ] )
				)
			);
		}

		return $ldapEntries;
	}

	/**
	 * {@inheritDoc}
	 */
	public function searchFirst( string $filter, bool $firstLevelOnly = false, ?string $context = null, array $attributes = [] ): ?LdapEntryInterface
	{
		$ldapEntries = $this->convertSearchResult(
			$this->executeNativeSearch( $filter, $firstLevelOnly, $context, $attributes ),
			true
		);

		return 0 === count( $ldapEntries )
			? null
			: $ldapEntries[ 0 ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function search( string $filter, bool $firstLevelOnly = false, ?string $context = null, array $attributes = [] ): LdapEntryCollectionInterface
	{
		return $this->convertSearchResult(
			$this->executeNativeSearch( $filter, $firstLevelOnly, $context, $attributes ),
			false
		);
	}
}
