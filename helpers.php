<?php

namespace Major\CS;

use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;

function config(Finder $finder, array $rules = []): ConfigInterface
{
    return (new Config())->setRules(
        array_merge(require __DIR__.'/rules.php', $rules)
    )->setFinder($finder);
}
