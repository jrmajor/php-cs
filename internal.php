<?php

namespace Major\CS\Internal;

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
