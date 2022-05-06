<?php
declare(strict_types = 1);

namespace FordRT\Utils\CMS;

/**
 * Class Utils
 *
 * @package FordRT\Utils
 */
class DrupalSevenUtils
{

    /**
     * @param  SelectQueryInterface  $query
     *
     * @return string
     * @noinspection PhpUndefinedClassInspection
     */
    public static function PrintSelectQuery(SelectQueryInterface $query): string
    {
        $string = (string) $query;
        $arguments = $query->arguments();

        if (!empty($arguments) && is_array($arguments)) {
            foreach ($arguments as &$value) {
                if (is_string($value)) {
                    $value = "'$value'";
                }
            }
            unset($value);

            $string = strtr($string, $arguments);
        }

        return $string;
    }
}
