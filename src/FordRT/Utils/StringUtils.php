<?php
declare(strict_types=1);

namespace FordRT\Utils4Php;

/**
 * Class StringUtils
 *
 * @package FordRT\Utils4Php
 */
class StringUtils
{
    /**
     * Replace last occurrence of NEEDLE in TARGET with REPLACE
     *
     * @param  string  $target
     * @param  string  $needle
     * @param  string  $replace
     *
     * @return string
     */
    public static function replaceLast(string $target, string $needle, string $replace): string
    {
        $lastOccurrencePosition = strrpos($target, $needle);
        $pre                    = substr($target, 0, $lastOccurrencePosition);
        $post                   = substr($target, $lastOccurrencePosition + 1);

        return $pre.$replace.$post;
    }

    /**
     * Is string ends with needle?
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function str_starts_with (string $haystack, string $needle): bool
    {
        /** @noinspection PhpStrFunctionsInspection */
        /** @noinspection StrStartsWithCanBeUsedInspection */
        return strpos($haystack, $needle) === 0;
    }
}
