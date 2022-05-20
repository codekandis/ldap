<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

/**
 * Represents a LDAP search `equal to` comparison filter.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapSearchComparisonEqualToFilter extends AbstractLdapSearchComparisonFilter
{
	/**
	 * Constructor method.
	 * @param string $attributeName The name of the attribute.
	 * @param string $attributeValue The value of the attribute.
	 */
	public function __construct( string $attributeName, string $attributeValue )
	{
		parent::__construct( LdapSearchComparisonOperators::EQUAL_TO, $attributeName, $attributeValue );
	}
}
