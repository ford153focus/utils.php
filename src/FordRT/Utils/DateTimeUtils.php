<?php
/**
 * @noinspection MissingOrEmptyGroupStatementInspection
 */

declare(strict_types=1);

namespace FordRT\Utils;

/**
 * Class DateTimeUtils
 *
 * @package FordRT\Utils
 */
class DateTimeUtils
{
    /**
     * @param  float  $hour0
     *
     * @return array
     */
    public static function floatHoursToHMS(float $hour0): array
    {
        $seconds = ($hour0 * 3600);
        $hours = floor($hour0);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;

        return [(int)$hours, (int)$minutes, (int)$seconds];
    }

    /**
     * @throws \Exception
     */
    public static function setRussianLocale(): void
    {
        $locale = setlocale(LC_ALL, 'ru_RU.UTF8', 'rus_RUS.UTF8', 'Russian_Russia.UTF8');
        if(!$locale) throw new \RuntimeException('Setting locale is failed! Is locale installed and enabled?');

        $test = strftime("%A %e %B %Y", mktime(0, 0, 0, 9, 3, 2007));
        if($test!=='Понедельник  3 сентября 2007') throw new \RuntimeException('Self test is failed!');
    }
}
