<?php

namespace Major\Cs\Integration;

use Psl\Filesystem;
use Psl\Shell;
use Psl\Str;

final class GitHubRepo
{
    private function __construct(
        private string $repo,
        private string $dir,
    ) {}

    public static function clone(string $repo, string $to): self
    {
        $name = Str\after($repo, '/');

        if (! Filesystem\is_directory("{$to}/{$name}/.git")) {
            Shell\execute('git clone', ["https://github.com/{$repo}.git"], $to);
        }

        return new self($repo, "{$to}/{$name}");
    }

    public function resetToRemote(
        string $remote = 'origin',
        string $branch = 'master',
    ): void {
        Shell\execute('git fetch', ['origin'], $this->dir);
        Shell\execute('git reset', ['--hard', 'origin/master'], $this->dir);
    }
}
