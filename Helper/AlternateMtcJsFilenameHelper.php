<?php

declare(strict_types=1);

namespace MauticPlugin\MtcJsAlternateBundle\Helper;

final class AlternateMtcJsFilenameHelper
{
    private const DEFAULT_SCRIPT = 'mtc.js';

    /**
     * @return string|null error message translation key, or null if valid
     */
    public static function validate(?string $raw): ?string
    {
        $trimmed = null === $raw ? '' : trim($raw);

        if ('' === $trimmed) {
            return null;
        }

        if (strlen($trimmed) > 191) {
            return 'plugin.mtcjsalt.error.filename_too_long';
        }

        if (1 === preg_match('/[\\/\\\\]/', $trimmed)) {
            return 'plugin.mtcjsalt.error.filename_no_slash';
        }

        if (!str_ends_with(strtolower($trimmed), '.js')) {
            return 'plugin.mtcjsalt.error.must_end_with_js';
        }

        if (1 !== preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_.-]*\.js$/', $trimmed)) {
            return 'plugin.mtcjsalt.error.filename_chars';
        }

        if (strtolower($trimmed) === self::DEFAULT_SCRIPT) {
            return 'plugin.mtcjsalt.error.same_as_default';
        }

        $reserved = [
            'mtracking.gif',
            'keep-alive',
            'favicon.ico',
            'robots.txt',
        ];

        foreach ($reserved as $r) {
            if (strtolower($trimmed) === $r) {
                return 'plugin.mtcjsalt.error.reserved';
            }
        }

        return null;
    }
}
