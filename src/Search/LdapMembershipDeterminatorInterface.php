<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search;

use CodeKandis\Ldap\Entries\LdapEntryInterface;

/**
 * Represents the interface of any LDAP membership determinator.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
interface LdapMembershipDeterminatorInterface
{
	/**
	 * Determines whether an LDAP entry is in a specific group.
	 * @param LdapEntryInterface $ldapEntry The entry to dtermine its membership.
	 * @param string $groupName The name of the group.
	 * @return bool True if the LDAP entry is member of the group, otherwise false.
	 */
	public function isInGroup( LdapEntryInterface $ldapEntry, string $groupName ): bool;
}
