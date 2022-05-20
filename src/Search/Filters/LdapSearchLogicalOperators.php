<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

/**
 * Represents an enumeration of LDAP search logical operators.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class LdapSearchLogicalOperators
{
	/**
	 * Represents an `and` operator.
	 * @var string
	 */
	public const AND = '&';

	/**
	 * Represents an `or` operator.
	 * @var string
	 */
	public const OR  = '|';

	/**
	 * Represents an `not` operator.
	 * @var string
	 */
	public const NOT = '!';
}
