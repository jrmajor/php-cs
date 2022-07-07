<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->append(['check'])
    ->ignoreVCSIgnored(true);

return Major\CS\config($finder)
    ->setCacheFile('../.cache/.php-cs-fixer.i.cache');
