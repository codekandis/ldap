<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

/**
 * Represents the interface of any LDAP search logical operator filter.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapSearchLogicalOperatorFilterInterface extends LdapSearchFilterInterface
{
	/**
	 * Gets the operator.
	 * @return string The operator.
	 */
	public function getOperator(): string;

	/**
	 * Gets the operands.
	 * @return LdapSearchFilterCollectionInterface The operands.
	 */
	public function getOperands(): LdapSearchFilterCollectionInterface;
}
