<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search;

/**
 * Represents the interface of any LDAP search filter builder.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapSearchFilterBuilderInterface
{
	/**
	 * Builds the filter string.
	 * @return string The filter string.
	 */
	public function build(): string;
}
