<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap;

/**
 * Represents an enumeration of LDAP connector states.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class LdapConnectorStates
{
	/**
	 * Represents the state `instantiated`.
	 * @var string
	 */
	public const INSTANTIATED = 0;

	/**
	 * Represents the state `connection failed`.
	 * @var string
	 */
	public const CONNECTION_FAILED = 1;

	/**
	 * Represents the state `connected`.
	 * @var string
	 */
	public const CONNECTED = 2;

	/**
	 * Represents the state `binding failed`.
	 * @var string
	 */
	public const BINDING_FAILED = 3;

	/**
	 * Represents the state `bound`.
	 * @var string
	 */
	public const BOUND = 4;
}
