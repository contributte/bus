<?php declare(strict_types = 1);

use Contributte\Bus\Result\EmptyResult;
use Contributte\Bus\Utils\Functions;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(function (): void {
	$fn = Functions::blank();
	Assert::equal(null, $fn());
	Assert::equal(null, $fn(1, 2, 3, 4, 5));
});

Toolkit::test(function (): void {
	$fn = Functions::leaf();
	Assert::type(EmptyResult::class, $fn());
});
