<?php

namespace Major\CS;

use Generator;
use IteratorAggregate;
use Major\CS\Fixers as F;
use PhpCsFixer\Fixer\FixerInterface;

/**
 * @implements IteratorAggregate<FixerInterface>
 */
final class Fixers implements IteratorAggregate
{
    /**
     * @return Generator<FixerInterface>
     */
    public function getIterator(): Generator
    {
        yield from [
            new F\NoWhitespaceInEmptyArray(),
            new F\SingleLineEmptyBody(),
        ];
    }
}
