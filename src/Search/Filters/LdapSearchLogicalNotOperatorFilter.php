<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

/**
 * Represents a LDAP search logical `not` operator filter.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapSearchLogicalNotOperatorFilter extends AbstractLdapSearchLogicalOperatorFilter
{
	/**
	 * Constructor method.
	 * @param LdapSearchFilterInterface $operand The filter operand.
	 */
	public function __construct( LdapSearchFilterInterface $operand )
	{
		parent::__construct( LdapSearchLogicalOperators::NOT, $operand );
	}
}
