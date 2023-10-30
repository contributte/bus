<?php declare(strict_types = 1);

use Contributte\Bus\Result\DataResult;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

// Getting data (null)
Toolkit::test(function (): void {
	$result = DataResult::ofNull();

	Assert::equal(null, $result->getData());
});

// Getting data (boolean)
Toolkit::test(function (): void {
	$result = DataResult::ofBoolean(false);

	Assert::equal(false, $result->getData());
});

// Getting data (array)
Toolkit::test(function (): void {
	$result = DataResult::ofArray([]);

	Assert::equal([], $result->getData());
});

// Getting data (scalar)
Toolkit::test(function (): void {
	$result = DataResult::ofScalar(123456);

	Assert::equal(123456, $result->getData());
});

// Getting data (integer)
Toolkit::test(function (): void {
	$result = DataResult::ofInteger(123456);

	Assert::equal(123456, $result->getData());
});

// Getting data (string)
Toolkit::test(function (): void {
	$result = DataResult::ofString('123456');

	Assert::equal('123456', $result->getData());
});

// Getting data (structure)
Toolkit::test(function (): void {
	$struct = (object) ['foo' => 'bar'];

	$result = DataResult::ofStructure($struct);

	Assert::equal($struct, $result->getData());
});
