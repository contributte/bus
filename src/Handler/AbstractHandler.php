<?php declare(strict_types = 1);

namespace Contributte\Bus\Handler;

use Contributte\Bus\Command\Command;

/**
 * @template T of Command
 * @implements IHandler<T>
 */
abstract class AbstractHandler implements IHandler
{

}
