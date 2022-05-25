<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap;

use CodeKandis\Ldap\Configurations\LdapConfigurationInterface;
use CodeKandis\Ldap\Credentials\LdapClientCredentialsInterface;
use CodeKandis\Ldap\Entries\LdapEntryCollectionInterface;
use CodeKandis\Ldap\Entries\LdapEntryInterface;
use CodeKandis\Ldap\Search\LdapMembershipDeterminator;
use CodeKandis\Ldap\Search\LdapSearchProvider;
use function array_map;
use function explode;
use function implode;
use function in_array;
use function ldap_bind;
use function ldap_connect;
use function ldap_set_option;
use function sprintf;
use const LDAP_OPT_PROTOCOL_VERSION;
use const LDAP_OPT_REFERRALS;

/**
 * Represents a LDAP connector.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapConnector implements LdapConnectorInterface
{
	/**
	 * Represents the error message if a LDAP connection has been failed.
	 * @var string
	 */
	protected const ERROR_CONNECTION_FAILED = 'The LDAP connection has been failed. %s.';

	/**
	 * Represents the error message if a LDAP connection has already been bound.
	 * @var string
	 */
	protected const ERROR_CONNECTION_BOUND = 'The LDAP connection has already been bound.';

	/**
	 * Represents the error message if a LDAP connection has not been bound.
	 * @var string
	 */
	protected const ERROR_CONNECTION_NOT_BOUND = 'The LDAP connection has not been bound.';

	/**
	 * Represents the error message if a LDAP authentication has been failed.
	 * @var string
	 */
	protected const ERROR_AUTHENTICATION_FAILED = 'The LDAP authentication has been failed. %s.';

	/**
	 * Represents the additional options excluded from beeing set while they are defined explicitely in the provided configuration.
	 * @var int[]
	 */
	private const   EXCLUDED_ADDITIONAL_OPTIONS = [
		LDAP_OPT_PROTOCOL_VERSION
	];

	/**
	 * Stores the LDAP handle of the connection.
	 * @var ?resource The LDAP handle of the connection.
	 */
	private $ldapHandle = null;

	/**
	 * Stores the server DN based on the configured server DN or, if null, based on the configured server name.
	 * @var string
	 */
	private string $serverDn;

	/**
	 * Stores the current state of the connector.
	 * @var int
	 */
	private int $state = LdapConnectorStates::INSTANTIATED;

	/**
	 * Stores the configuration of the LDAP connection.
	 * @var LdapConfigurationInterface
	 */
	private LdapConfigurationInterface $configuration;

	/**
	 * Stores the error message builder used to build error messages.
	 * @var LdapErrorMessageBuilderInterface
	 */
	private LdapErrorMessageBuilderInterface $errorMessageBuilder;

	/**
	 * Constructor method.
	 * @param LdapConfigurationInterface $configuration The configuration of the LDAP connection.
	 * @throws LdapConnectionFailedException The LDAP connection has been failed.
	 */
	public function __construct( LdapConfigurationInterface $configuration )
	{
		$this->configuration = $configuration;

		$this->connect();
		$this->setAdditionalOptions();
	}

	/**
	 * Gets the error message builder used to build error messages.
	 * @return LdapErrorMessageBuilderInterface The error message builder.
	 */
	private function getErrorMessageBuilder(): LdapErrorMessageBuilderInterface
	{
		return $this->errorMessageBuilder ?? $this->errorMessageBuilder = new LdapErrorMessageBuilder();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getState(): int
	{
		return $this->state;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getServerDn(): string
	{
		return $this->serverDn ??
			   $this->serverDn = (
				   $this->configuration->getServerDn() ??
				   implode(
					   ',',
					   array_map(
						   function ( string $serverNameSegment )
						   {
							   return sprintf(
								   'DC=%s',
								   $serverNameSegment
							   );
						   },
						   explode(
							   '.',
							   $this->configuration->getServerName()
						   )
					   )
				   )
			   );
	}

	/**
	 * Connects to the LDAP server.
	 * @throws LdapConnectionFailedException The LDAP connection has been failed.
	 */
	private function connect(): void
	{
		$ldapHandle = @ldap_connect(
			$this->configuration->getServerName(),
			$this->configuration->getServerPort(),
		);

		if ( false === $ldapHandle )
		{
			$this->state = LdapConnectorStates::CONNECTION_FAILED;
			throw new LdapConnectionFailedException(
				sprintf(
					static::ERROR_CONNECTION_FAILED,
					$this->getErrorMessageBuilder()
						 ->build( $this->ldapHandle )
				)
			);
		}

		$this->ldapHandle = $ldapHandle;
		$this->state      = LdapConnectorStates::CONNECTED;

		ldap_set_option( $this->ldapHandle, LDAP_OPT_PROTOCOL_VERSION, 3 );
		ldap_set_option( $this->ldapHandle, LDAP_OPT_REFERRALS, 0 );
	}

	/**
	 * Sets the additional options of the LDAP connection.
	 */
	private function setAdditionalOptions(): void
	{
		foreach ( $this->configuration->getAdditionalOptions() as $additionalOptionIdentifier => $additionalOptionValue )
		{
			if ( true === in_array( $additionalOptionIdentifier, static::EXCLUDED_ADDITIONAL_OPTIONS, true ) )
			{
				ldap_set_option( $this->ldapHandle, $additionalOptionIdentifier, $additionalOptionValue );
			}
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function authenticate( LdapClientCredentialsInterface $clientCredentials ): void
	{
		if ( LdapConnectorStates::BOUND === $this->state )
		{
			throw new LdapConnectionBoundException( static::ERROR_CONNECTION_BOUND );
		}

		$authenticated = @ldap_bind(
			$this->ldapHandle,
			sprintf(
				'%s@%s',
				$clientCredentials
					->getId(),
				$this->configuration->getServerName()
			),
			$clientCredentials
				->getPasscode()
		);

		if ( false === $authenticated )
		{
			$this->state = LdapConnectorStates::BINDING_FAILED;
			throw new LdapConnectionBindingFailedException(
				sprintf(
					static::ERROR_AUTHENTICATION_FAILED,
					$this->getErrorMessageBuilder()
						 ->build( $this->ldapHandle )
				)
			);
		}

		$this->state = LdapConnectorStates::BOUND;
	}

	/**
	 * {@inheritDoc}
	 */
	public function searchFirst( string $filter, bool $firstLevelOnly = false, ?string $context = null, array $attributes = [] ): ?LdapEntryInterface
	{
		if ( LdapConnectorStates::BOUND !== $this->state )
		{
			throw new LdapConnectionNotBoundException( static::ERROR_CONNECTION_NOT_BOUND );
		}

		return ( new LdapSearchProvider(
			$this->ldapHandle,
			$this->getServerDn(),
			$this->getErrorMessageBuilder()
		) )
			->searchFirst( $filter, $firstLevelOnly, $context, $attributes );
	}

	/**
	 * {@inheritDoc}
	 */
	public function search( string $filter, bool $firstLevelOnly = false, ?string $context = null, array $attributes = [] ): LdapEntryCollectionInterface
	{
		if ( LdapConnectorStates::BOUND !== $this->state )
		{
			throw new LdapConnectionNotBoundException( static::ERROR_CONNECTION_NOT_BOUND );
		}

		return ( new LdapSearchProvider(
			$this->ldapHandle,
			$this->getServerDn(),
			$this->getErrorMessageBuilder()
		) )
			->search( $filter, $firstLevelOnly, $context, $attributes );
	}

	/**
	 * {@inheritDoc}
	 */
	public function isInGroup( LdapEntryInterface $ldapEntry, string $groupName ): bool
	{
		if ( LdapConnectorStates::BOUND !== $this->state )
		{
			throw new LdapConnectionNotBoundException( static::ERROR_CONNECTION_NOT_BOUND );
		}

		return ( new LdapMembershipDeterminator(
			$this->ldapHandle,
			$this->getServerDn(),
			$this->errorMessageBuilder
		) )
			->isInGroup( $ldapEntry, $groupName );
	}
}
