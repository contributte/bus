<?php declare(strict_types = 1);

namespace Contributte\Bus\Result;

/**
 * @phpstan-consistent-constructor
 */
class DataResult extends Result
{

	protected mixed $data;

	public function __construct(mixed $data)
	{
		$this->data = $data;
	}

	public static function from(mixed $data): self
	{
		return new static($data);
	}

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		return new static($data);
	}

	public static function fromNull(): self
	{
		return new static(null);
	}

	public static function fromScalar(string|int|float|bool $data): self
	{
		return new static($data);
	}

	public static function fromString(string $data): self
	{
		return new static($data);
	}

	public static function fromBoolean(bool $data): self
	{
		return new static($data);
	}

	public static function fromInteger(int $data): self
	{
		return new static($data);
	}

	public static function fromStructure(\stdClass $data): self
	{
		return new static($data);
	}

	public function getData(): mixed
	{
		return $this->data;
	}

}
