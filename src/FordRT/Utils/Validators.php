<?php
declare(strict_types=1);

namespace FordRT\Utils;

/**
 * Class Validators
 *
 * @package FordRT\Utils
 */
class Validators
{
    public static function isPhone(string $phone): bool
    {
        if (!$phone) {
            return false;
        }
        return preg_match('/^\+?\d{1,10}[\s(]*\d{1,7}\d{1,9}[)\s]*\d{1,6}[\s\-]*\d{1,6}[\s\-]*\d{1,3}$/', $phone);
    }

    public static function isMail(string $email): bool
    {
        if (!$email) {
            return false;
        }
        return preg_match('/^.{1,254}@.{3,63}\..{1,24}$/', $email);
    }
}
