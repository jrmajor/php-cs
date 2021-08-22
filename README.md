My personal [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) configuration, used in all of my PHP projects.

Install it via Composer: `composer require jrmajor/cs` and use `Major\CS\config()` function in `.php-cs-fixer.php`:

```php
<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->notPath('bootstrap/cache')
    ->notPath('node_modules')
    ->notPath('storage')
    ->notName('*.blade.php')
    ->notName('_ide_helper*.php')
    ->ignoreVCS(true);

return Major\CS\config($finder, ['overwritten_rule' => false]);
```

Don't forget to add `.php-cs-fixer.cache` to `.gitignore`!
