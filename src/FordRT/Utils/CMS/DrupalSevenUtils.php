<?php
declare(strict_types = 1);

namespace FordRT\Utils4Php\CMS;

/**
 * Class Utils
 *
 * @package FordRT\Utils4Php
 */
class DrupalSevenUtils
{

    /**
     * @param  SelectQueryInterface  $query
     *
     * @return string
     */
    public static function PrintSelectQuery(SelectQueryInterface $query): string
    {
        $string = (string) $query;
        $arguments = $query->arguments();

        if (!empty($arguments) && is_array($arguments)) {
            foreach ($arguments as $placeholder => &$value) {
                if (is_string($value)) {
                    $value = "'$value'";
                }
            }

            $string = strtr($string, $arguments);
        }

        return $string;
    }
}
