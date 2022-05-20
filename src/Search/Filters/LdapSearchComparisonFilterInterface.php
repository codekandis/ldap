<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

/**
 * Represents the interface of any LDAP search key-value filter.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapSearchComparisonFilterInterface extends LdapSearchFilterInterface
{
	/**
	 * Gets the operator.
	 * @return string The operator.
	 */
	public function getOperator(): string;

	/**
	 * Gets the name of the attribute.
	 * @return string The name of the attribute.
	 */
	public function getAttributeName(): string;

	/**
	 * Gets the value of the attribute.
	 * @return string The value of the attribute.
	 */
	public function getAttributeValue(): string;
}
