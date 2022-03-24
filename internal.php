<?php

namespace Major\CS\Internal;

/**
 * Denotes cases that are static analysis tooling responsibility.
 */
const STATIC_ANALYSIS = false;

/**
 * These fixers may be useful when working with legacy codebases.
 * Use MAJOR_CS_LEGACY_RULES environment variable to enable them.
 *
 * @template T of true|array<string, mixed>
 *
 * @param T $options
 * @return T|false
 */
function legacy(bool|array $options = true): bool|array
{
    $legacy = getenv('MAJOR_CS_LEGACY_RULES');

    return $legacy === '1' ? $options : false;
}

/**
 * Enable or disable fixers depending on the current PHP version.
 *
 * @template Ta of true|array<string, mixed>
 * @template Tb of false|array<string, mixed>
 *
 * @param Ta $after
 * @param Tb $before
 * @return Ta|Tb
 */
function version(
    float $version,
    bool|array $after = true,
    bool|array $before = false,
): bool|array {
    $major = (int) $version;
    $minor = ($version - $major) * 10;

    $version = 10000 * $major + 100 * $minor;

    return PHP_VERSION_ID >= $version ? $after : $before;
}

/**
 * Denotes rare cases, skipping them to speed up linting process.
 *
 * @template T of true|array<string, mixed>
 *
 * @param T $options
 * @return T|false
 */
function rare(bool|array $options = true): bool|array
{
    return false;
}