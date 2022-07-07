<?php

namespace Major\Cs\Integration;

use Psl\File;
use Psl\Json;
use Psl\Shell;

final class Composer
{
    private function __construct(
        private string $dir,
        /** @var array<string, mixed> */
        private array $content,
    ) {}

    public static function load(string $dir): self
    {
        $content = File\read("{$dir}/composer.json");

        return new self($dir, Json\decode($content));
    }

    public function addRepoPath(string $path): self
    {
        $this->content['repositories'] ??= [];

        $this->content['repositories'][] = [
            'type' => 'path',
            'url' => $path,
        ];

        return $this;
    }

    public function write(): self
    {
        File\write(
            "{$this->dir}/composer.json",
            Json\encode($this->content),
            File\WriteMode::TRUNCATE,
        );

        return $this;
    }

    public function requireDev(string $package, string $version): self
    {
        Shell\execute('composer require', [
            '--dev',
            '--no-progress',
            '--update-with-all-dependencies',
            '--no-interaction',
            "{$package}:{$version}",
        ], $this->dir);

        return $this;
    }
}
