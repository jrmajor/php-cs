<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('integration')
    ->ignoreVCSIgnored(true);

return Major\CS\config($finder)
    ->setCacheFile('.cache/.php-cs-fixer.cache');
