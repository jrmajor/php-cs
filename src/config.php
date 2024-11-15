<?php

namespace Major\CS;

use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;
use PhpCsFixerCustomFixers\Fixers as KubaFixers;

/**
 * @param array<string, bool|array<string, mixed>> $rules
 */
function config(Finder $finder, array $rules = []): ConfigInterface
{
    return (new Config('jrmajor/cs'))
        ->setParallelConfig(ParallelConfigFactory::detect())
        ->registerCustomFixers(new Fixers())
        ->registerCustomFixers(new KubaFixers())
        /** @phpstan-ignore argument.type */
        ->setRules(array_merge(
            /** @phpstan-ignore argument.type */
            require __DIR__ . '/Rules/rules.php',
            /** @phpstan-ignore argument.type */
            require __DIR__ . '/Rules/risky.php',
            /** @phpstan-ignore argument.type */
            require __DIR__ . '/Rules/major.php',
            /** @phpstan-ignore argument.type */
            require __DIR__ . '/Rules/kuba.php',
            $rules,
        ))
        ->setFinder($finder)
        ->setRiskyAllowed(true);
}
