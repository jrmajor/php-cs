<?php

namespace Major\CS\Fixers;

use PhpCsFixer\Fixer\FixerInterface;
use SplFileInfo;

abstract class AbstractFixer implements FixerInterface
{
    public function isRisky(): bool
    {
        return false;
    }

    public static function name(): string
    {
        $nameParts = explode('\\', static::class);
        $name = end($nameParts);
        $name = preg_replace('/(?<!^)((?=[\\p{Lu}][^\\p{Lu}])|(?<![\\p{Lu}])(?=[\\p{Lu}]))/', '_', $name);

        return 'Major/' . mb_strtolower($name);
    }

    public function getName(): string
    {
        return self::name();
    }

    public function getPriority(): int
    {
        return 0;
    }

    public function supports(SplFileInfo $file): bool
    {
        return true;
    }
}
