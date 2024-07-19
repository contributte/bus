<?php declare(strict_types = 1);

use Contributte\Bus\Result\EmptyResult;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(function (): void {
	$result = new EmptyResult();
	Assert::equal([], $result->pullEvents());
});
