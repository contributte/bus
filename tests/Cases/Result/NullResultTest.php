<?php declare(strict_types = 1);

use Contributte\Bus\Result\NullResult;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(function (): void {
	$result = NullResult::of();

	Assert::exception(
		fn () => $result->pullEvents(),
		LogicException::class
	);
});
