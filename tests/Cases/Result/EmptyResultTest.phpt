<?php declare(strict_types = 1);

namespace Tests\Cases\Result;

use Contributte\Bus\Result\EmptyResult;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(static function (): void {
	$result = new EmptyResult();
	Assert::equal([], $result->pullEvents());
});
