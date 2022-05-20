<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Entries;

use CodeKandis\Ldap\LdapException;

/**
 * Represents an exception thrown if a LDAP entry does not exist.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
class LdapEntryNotFoundException extends LdapException
{
}
