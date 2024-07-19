# Contributte Bus

Simple and adaptive command bus to Nette Framework.

## Installation

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
use Contributte\Bus\Result\EmptyResult;
use Contributte\Bus\Result\Result;

/**
 * @implements IHandler<CreateUserCommand>
 */
final class CreateUserHandler implements IHandler
{

    public function __construct(
        EntityManager $em
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
            ))
        };

        return $form;
    }

}
```
