<?php

namespace Major\CS\Rules;

/**
 * Denotes cases that are static analysis tooling responsibility.
 */
const StaticAnalysis = false;

/**
 * These fixers may be useful when working with legacy codebases.
 * Use MAJOR_CS_LEGACY_RULES environment variable to enable them.
 *
 * @template T of true|array<string, mixed>
 *
 * @param T $options
 * @return T|false
 */
function legacy($options = true)
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
function version(float $version, $after = true, $before = false)
{
    $major = (int) $version;
    $minor = ($version - $major) * 10;

    $version = 10000 * $major + 100 * $minor;

    return $version <= PHP_VERSION_ID ? $after : $before;
}

/**
 * Denotes rare cases, skipping them to speed up linting process.
 *
 * @template T of true|array<string, mixed>
 *
 * @param T $options
 * @return T|false
 */
function rare($options = true)
{
    return false;
}
