<?php

namespace Major\CS;

use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;
use PhpCsFixerCustomFixers\Fixers as KubaFixers;

/**
 * @param array<string, bool|array<string, mixed>> $rules
 */
function config(Finder $finder, array $rules = []): ConfigInterface
{
    return (new Config('jrmajor/cs'))
        ->registerCustomFixers(new Fixers())
        ->registerCustomFixers(new KubaFixers())
        ->setRules(array_merge(
            require __DIR__ . '/Rules/rules.php',
            require __DIR__ . '/Rules/risky.php',
            require __DIR__ . '/Rules/major.php',
            require __DIR__ . '/Rules/kuba.php',
            $rules,
        ))
        ->setFinder($finder)
        ->setRiskyAllowed(true);
}
