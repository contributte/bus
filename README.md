![](https://heatbadger.now.sh/github/readme/contributte/bus/)

<p align=center>
	<a href="https://github.com/contributte/bus/actions"><img src="https://badgen.net/github/checks/contributte/bus/master?cache=300"></a>
	<a href="https://coveralls.io/r/contributte/bus"><img src="https://badgen.net/coveralls/c/github/contributte/bus?cache=300"></a>
	<a href="https://packagist.org/packages/contributte/bus"><img src="https://badgen.net/packagist/dm/contributte/bus"></a>
	<a href="https://packagist.org/packages/contributte/bus"><img src="https://badgen.net/packagist/v/contributte/bus"></a>
</p>
<p align=center>
	<a href="https://packagist.org/packages/contributte/bus"><img src="https://badgen.net/packagist/php/contributte/bus"></a>
	<a href="https://github.com/contributte/bus"><img src="https://badgen.net/github/license/contributte/bus"></a>
	<a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
	<a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
	<a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/become/a%20patron/F96854"></a>
</p>

<p align=center>
Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

Simple and adaptive command bus for Nette Framework applications.

## Versions

| State  | Version | Branch   | Nette | PHP     |
|--------|---------|----------|-------|---------|
| dev    | `^0.3`  | `master` | 3.2+  | `>=8.2` |
| stable | `^0.2`  | `master` | 3.2+  | `>=8.2` |

## Installation

To install the latest version of `contributte/bus` use [Composer](https://getcomposer.org).

```bash
composer require contributte/bus
```

## Concept

CommandBus is a good way how to divide logic into commands & handlers.

Parts:

- Command - holds data
- Handler - executes operation
- Locator - locates handler by command
- Middleware - injects logic before/after processing

Similar libraries:

- https://tactician.thephpleague.com
- https://github.com/SimpleBus/message-bus
- https://github.com/symfony/messenger

## Usage

We need to register command bus service with handler middleware and handler locator. After that,
we can create our business-related classes, for example `CreateUserCommand` and `CreateUserHandler` in `App\Domain\User` namespace.

```neon
services:
    - Contributte\Bus\CommandBus([
        Contributte\Bus\Middleware\HandlerMiddleware(
            Contributte\Bus\Locator\ContainerHandlerLocator([
                App\Domain\User\CreateUserCommand: bus.createUserHandler
                App\Domain\User\UpdateUserCommand: bus.updateUserHandler
            ])
        )
    ])

    bus.createUserHandler: App\Domain\User\CreateUserHandler
    bus.updateUserHandler: App\Domain\User\UpdateUserHandler
```

Example of `CreateUserCommand`:

```php
<?php declare(strict_types = 1);

namespace App\Domain\User;

use Contributte\Bus\Command\Command;

final class CreateUserCommand extends Command
{

    public function __construct(
        public string $email
    )
    {
    }

}
```

Example of `CreateUserHandler`:

```php
<?php declare(strict_types = 1);

namespace App\Domain\User;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Handler\IHandler;
use Contributte\Bus\Result\DataResult;

/**
 * @implements IHandler<CreateUserCommand>
 */
final class CreateUserHandler implements IHandler
{

    public function __construct(
        private EntityManager $em
    )
    {
    }

    /**
     * @param CreateUserCommand $command
     */
    public function handle(Command $command): DataResult
    {
        $user = new User($command->email);
        $this->em->persist($user);

        return DataResult::from($user);
    }

}
```

Example of Presenter/Controller/Control:

```php
<?php declare(strict_types = 1);

namespace App\Domain\User;

use Contributte\Bus\CommandBus;
use Nette\Application\UI\Presenter;
use Nette\DI\Attributes\Inject;

final class CreateUserPresenter extends Presenter
{

    #[Inject]
    public CommandBus $bus;

    protected function createComponentUserForm(): Form
    {
        $form = new Form();
        $form->addEmail('email')->setRequired(true);

        $form->onSuccess[] = function (Form $form): void {
            $this->bus->handle(new CreateUserCommand(
                email: $form->values->email
            ));
        };

        return $form;
    }

}
```

## Development

See [how to contribute](https://contributte.org/contributing.html) to this package.

This package is currently maintaining by these authors.

<a href="https://github.com/f3l1x">
  <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

-----

Consider to [support](https://contributte.org/partners.html) **contributte** development team.
Also thank you for using this package.
