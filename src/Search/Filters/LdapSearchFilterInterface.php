<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

/**
 * Represents the interface of any LDAP search filter.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapSearchFilterInterface
{
	/**
	 * Gets the filter string of the filter.
	 * @return string The filter string of the filter.
	 */
	public function getFilterString(): string;
}
