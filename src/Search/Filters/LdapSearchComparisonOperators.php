<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

/**
 * Represents an enumeration of LDAP search comparison operators.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class LdapSearchComparisonOperators
{
	/**
	 * Represents an `equal to` operator.
	 * @var string
	 */
	public const EQUAL_TO = '=';

	/**
	 * Represents a `proximity` operator.
	 * @var string
	 */
	public const PROXIMITY = '~=';

	/**
	 * Represents a `less than` operator.
	 * @var string
	 */
	public const LESS_THAN = '<';

	/**
	 * Represents a `less than or equal to` operator.
	 * @var string
	 */
	public const LESS_THAN_EQUAL_TO = '<=';

	/**
	 * Represents a `greater than or equal to` operator.
	 * @var string
	 */
	public const GREATER_THAN = '>';

	/**
	 * Represents a `greater than` operator.
	 * @var string
	 */
	public const GREATER_THAN_EQUAL_TO = '>=';
}
