## Laravel flask

##### Replacement for repository pattern, flask allow interfacing between Model and controller

### Installation

```json
composer require im-sunil/flask
```

#### Create action

```
 php artisan make:action GetUserAction
```

1. Using global helper with instance class.

```php
$users = perform(new GetUserAction(new User));
```

It will return a collection of users.

GetUserAction is action class, perform method help to invoke its related methods.
and return what you return from Action class perform method.

```
(new User)
```

class will bind to the action class and all method of user class will available to
the action class.

```php
<?php
namespace App\Actions;
use Action\Action;
class GetUserAction extends Action
{
    /**
     * @return mixed
     */
    public function perform($request)
    {

        return $this;
    }
}
```

2. Using global helper with string class.

```php
$users = perform(new GetUserAction(User::class));
```

```php
$users = perform((new GetUserAction(User::class))->additional(
    [
        "role"       => Role::class,
        "permission" => new Permission,
    ]
));
```

##### Another example

```php
return perform(GetUserAction::class, User::class, [
    "role"       => Role::class,
    "permission" => new Permission,
]);
```

> GetUserAction::class is action class.

> User::class injection or binding a model class.

> Role and Permission is additional data.
