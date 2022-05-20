<?php declare( strict_types = 1 );
namespace CodeKandis\Ldap\Search\Filters;

use function sprintf;

/**
 * Represents a LDAP search comparison filter.
 * @package codekandis/ldap
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class AbstractLdapSearchComparisonFilter implements LdapSearchComparisonFilterInterface
{
	/**
	 * Stores the operator.
	 * @var string
	 */
	private string $operator;

	/**
	 * Stores the name of the attribute.
	 * @var string
	 */
	private string $attributeName;

	/**
	 * Stores the value of the attribute.
	 * @var string
	 */
	private string $attributeValue;

	/**
	 * Constructor method.
	 * @param string $operator The comparison operator.
	 * @param string $attributeName The name of the attribute.
	 * @param string $attributeValue The value of the attribute.
	 */
	public function __construct( string $operator, string $attributeName, string $attributeValue )
	{
		$this->operator       = $operator;
		$this->attributeName  = $attributeName;
		$this->attributeValue = $attributeValue;
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
	public function getAttributeName(): string
	{
		return $this->attributeName;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAttributeValue(): string
	{
		return $this->attributeValue;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFilterString(): string
	{
		return sprintf(
			'(%s%s%s)',
			$this->attributeName,
			$this->operator,
			$this->attributeValue
		);
	}
}
