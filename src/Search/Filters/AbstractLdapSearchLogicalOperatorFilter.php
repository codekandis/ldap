<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

/**
 * Represents the interface of any LDAP search logical operator filter.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class AbstractLdapSearchLogicalOperatorFilter implements LdapSearchLogicalOperatorFilterInterface
{
	/**
	 * Stores the operator.
	 * @var string
	 */
	private string $operator;

	/**
	 * Stores the operands.
	 * @var LdapSearchFilterCollectionInterface[]
	 */
	private array $operands;

	/**
	 * Constructor method.
	 * @param string $operator The operator.
	 * @param LdapSearchFilterInterface[] $operands The operands.
	 */
	public function __construct( string $operator, LdapSearchFilterInterface ...$operands )
	{
		$this->operator = $operator;
		$this->operands = $operands;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getOperator(): string
	{
		return $this->operator;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getOperands(): LdapSearchFilterCollectionInterface
	{
		return new LdapSearchFilterCollection( ...$this->operands );
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFilterString(): string
	{
		return sprintf(
			'(%s%s)',
			$this->operator,
			implode(
				'',
				array_map(
					function ( LdapSearchFilterInterface $operand ): string
					{
						return $operand->getFilterString();
					},
					$this->operands
				)
			)
		);
	}
}
