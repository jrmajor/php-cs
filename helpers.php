<?php

namespace Major\CS;

use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;
use PhpCsFixerCustomFixers\Fixers as CustomFixers;

function config(Finder $finder, array $rules = []): ConfigInterface
{
    return (new Config('jrmajor/php-cs'))
        ->registerCustomFixers(new CustomFixers())
        ->setRules(array_merge(require __DIR__ . '/rules.php', $rules))
        ->setFinder($finder);
}
