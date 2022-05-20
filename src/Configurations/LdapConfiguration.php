<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Configurations;

/**
 * Represents a LDAP configuration.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapConfiguration implements LdapConfigurationInterface
{
	/**
	 * Stores the name of the server to connect to.
	 * @var string
	 */
	private string $serverName = '';

	/**
	 * Stores the port of the server to connect to.
	 * @var int
	 */
	private int $serverPort = 389;

	/**
	 * Stores the distinguished name of the server to connect to.
	 * @var ?string
	 */
	private ?string $serverDn = null;

	/**
	 * Stores the LDAP protocol version.
	 * @var int
	 */
	private int $protocolVersion = 3;

	/**
	 * Stores the additional LDAP options.
	 * @var array
	 */
	private array $additionalOptions=[];

	/**
	 * {@inheritDoc}
	 */
	public function getServerName(): string
	{
		return $this->serverName;
	}

	/**
	 * Sets the name of the server to connect to.
	 * @param string $serverName The name of the server to connect to.
	 * @return self The LDAP configuration.
	 */
	public function setServerName( string $serverName ): self
	{
		$this->serverName = $serverName;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getServerPort(): int
	{
		return $this->serverPort;
	}

	/**
	 * Sets the port of the server to connect to.
	 * @param int $serverPort The port of the server to connect to.
	 * @return self The LDAP configuration.
	 */
	public function setServerPort( int $serverPort ): self
	{
		$this->serverPort = $serverPort;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getServerDn(): ?string
	{
		return $this->serverDn;
	}

	/**
	 * Sets the DN of the server to connect to.
	 * @param ?string $serverDn The DN of the server to connect to.
	 * @return self The LDAP configuration.
	 */
	public function setServerDn( ?string $serverDn ): self
	{
		$this->serverDn = $serverDn;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getProtocolVersion(): int
	{
		return $this->protocolVersion;
	}

	/**
	 * Sets the LDAP protocol version.
	 * @param int $protocolVersion The LDAP protocol version.
	 * @return self The LDAP configuration.
	 */
	public function setProtocolVersion( int $protocolVersion ): self
	{
		$this->protocolVersion = $protocolVersion;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAdditionalOptions(): array
	{
		return $this->additionalOptions;
	}

	/**
	 * Sets the additional LDAP options.
	 * @param array[] $additionalOptions The additional LDAP options.
	 * @return self The LDAP configuration.
	 */
	public function setAdditionalOptions( array $additionalOptions ): self
	{
		$this->additionalOptions = $additionalOptions;

		return $this;
	}
}
