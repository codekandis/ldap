<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

/**
 * Represents a LDAP search logical `and` operator filter.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapSearchLogicalAndOperatorFilter extends AbstractLdapSearchLogicalOperatorFilter
{
	/**
	 * Constructor method.
	 * @param LdapSearchFilterInterface[] $operands The operands.
	 */
	public function __construct( LdapSearchFilterInterface ...$operands )
	{
		parent::__construct( LdapSearchLogicalOperators::AND, ...$operands );
	}
}
