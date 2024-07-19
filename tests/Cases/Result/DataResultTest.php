<?php declare(strict_types = 1);

use Contributte\Bus\Result\DataResult;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

// Getting data (mixed)
Toolkit::test(function (): void {
	$result = DataResult::from(123456);

	Assert::equal(123456, $result->getData());
});

// Getting data (null)
Toolkit::test(function (): void {
	$result = DataResult::fromNull();

	Assert::equal(null, $result->getData());
});

// Getting data (boolean)
Toolkit::test(function (): void {
	$result = DataResult::fromBoolean(false);

	Assert::equal(false, $result->getData());
});

// Getting data (array)
Toolkit::test(function (): void {
	$result = DataResult::fromArray([]);

	Assert::equal([], $result->getData());
});

// Getting data (scalar)
Toolkit::test(function (): void {
	$result = DataResult::fromScalar(123456);

	Assert::equal(123456, $result->getData());
});

// Getting data (integer)
Toolkit::test(function (): void {
	$result = DataResult::fromInteger(123456);

	Assert::equal(123456, $result->getData());
});

// Getting data (string)
Toolkit::test(function (): void {
	$result = DataResult::fromString('123456');

	Assert::equal('123456', $result->getData());
});

// Getting data (structure)
Toolkit::test(function (): void {
	$struct = (object) ['foo' => 'bar'];

	$result = DataResult::fromStructure($struct);

	Assert::equal($struct, $result->getData());
});
