<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap;

use function get_resource_type;
use function is_resource;
use function ldap_errno;
use function ldap_error;
use function ldap_get_option;
use function sprintf;
use const LDAP_OPT_DIAGNOSTIC_MESSAGE;

/**
 * Represents an error message builder.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapErrorMessageBuilder implements LdapErrorMessageBuilderInterface
{
	/**
	 * Represents the error message if a LDAP handle is invalid.
	 * @var string
	 */
	protected const ERROR_INVALID_LDAP_HANDLE = 'The type of the LDAP handle is invalid. Resource of type `ldap link` expected.';

	/**
	 *  {@inheritDoc}
	 */
	public function build( $ldapHandle ): string
	{
		if ( false === is_resource( $ldapHandle ) || 'ldap link' !== get_resource_type( $ldapHandle ) )
		{
			throw new LdapHandleInvalidException( static::ERROR_INVALID_LDAP_HANDLE );
		}

		$diagnosticErrorMessage = '';
		ldap_get_option( $ldapHandle, LDAP_OPT_DIAGNOSTIC_MESSAGE, $diagnosticErrorMessage );

		return sprintf(
			'%s: %s. %s.',
			ldap_errno( $ldapHandle ),
			ldap_error( $ldapHandle ),
			$diagnosticErrorMessage
		);
	}
}
