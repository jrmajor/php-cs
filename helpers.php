<?php

namespace Major\CS;

use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;
use PhpCsFixerCustomFixers\Fixers as CustomFixers;

function config(Finder $finder, array $rules = []): ConfigInterface
{
    return (new Config('jrmajor/cs'))
        ->registerCustomFixers(new CustomFixers())
        ->setRules(array_merge(
            require __DIR__ . '/rules.php',
            require __DIR__ . '/risky.php',
            $rules,
        ))
        ->setFinder($finder)
        ->setRiskyAllowed(true);
}
