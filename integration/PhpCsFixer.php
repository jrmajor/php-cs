<?php

namespace Major\Cs\Integration;

use Psl\Iter;
use Psl\Shell;
use Psl\Shell\Exception\FailedExecutionException;
use Psl\Str;
use Psl\Vec;

final class PhpCsFixer
{
    private function __construct(
        private string $dir,
    ) {}

    public static function in(string $dir): self
    {
        return new self($dir);
    }

    public function dryRun(): ?string
    {
        try {
            Shell\execute(
                'vendor/bin/php-cs-fixer fix',
                ['--dry-run', '--diff', '-v'],
                $this->dir,
            );

            return null;
        } catch (FailedExecutionException $e) {
            $lines = Str\split($e->getOutput(), "\n");
            $lines = Vec\take($lines, Iter\count($lines) - 4);

            return Str\join($lines, "\n");
        }
    }
}
