<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap;

/**
 * Represents the interface of any LDAP error message builder.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapErrorMessageBuilderInterface
{
	/**
	 * Builds the LDAP error message.
	 * @param resource $ldapHandle The LDAP handle of the connection.
	 * @return string The LDAP error message.
	 */
	public function build( $ldapHandle ): string;
}
