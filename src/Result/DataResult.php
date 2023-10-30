<?php declare(strict_types = 1);

namespace Contributte\Bus\Result;

/**
 * @phpstan-consistent-constructor
 */
class DataResult extends Result
{

	protected mixed $data;

	protected function __construct(mixed $data)
	{
		$this->data = $data;
	}

	public static function of(mixed $data): self
	{
		return new static($data);
	}

	/**
	 * @param mixed[] $data
	 */
	public static function ofArray(array $data): self
	{
		return new static($data);
	}

	public static function ofNull(): self
	{
		return new static(null);
	}

	public static function ofScalar(string|int|float|bool $data): self
	{
		return new static($data);
	}

	public static function ofString(string $data): self
	{
		return new static($data);
	}

	public static function ofBoolean(bool $data): self
	{
		return new static($data);
	}

	public static function ofInteger(int $data): self
	{
		return new static($data);
	}

	public static function ofStructure(\stdClass $data): self
	{
		return new static($data);
	}

	public function getData(): mixed
	{
		return $this->data;
	}

}
