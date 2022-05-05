<?php
/**
 * @noinspection MissingOrEmptyGroupStatementInspection
 */

declare(strict_types=1);

namespace FordRT\Utils4Php;

/**
 * Class Utils
 *
 * @package FordRT\Utils4Php
 */
class Utils
{
    /**
     * @return bool
     */
    public static function isIE(): bool
    {
        $isInternetExplorer = false;

        foreach (['MSIE ', 'Internet Explorer', 'Trident/7.0; rv:11.0'] as $internetExplorerUserAgentLabel) {
            if (str_contains($_SERVER['HTTP_USER_AGENT'], $internetExplorerUserAgentLabel)) {
                $isInternetExplorer = true;
            }
        }

        return $isInternetExplorer;
    }

    /**
     * @param  string  $directoryPath
     * @param  null  $archivePath
     * @param  bool|null  $outputToBrowser
     *
     * @return string|null
     * @throws \Exception
     */
    public static function compressFolderToZip(string $directoryPath, $archivePath = null, bool $outputToBrowser = null): ?string
    {
        if (!is_dir($directoryPath)) {
            throw new \Exception("Path $directoryPath is not directory");
        }

        $archivePath = $archivePath ?? sprintf('/tmp/%s.zip', self::pwgen());
        $zip         = new \ZipArchive();
        $zip->open($archivePath, \ZipArchive::OVERWRITE);

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directoryPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            $filename = $file->getFilename();
            if ($filename === '.' || $filename === '..') {
                break;
            } // avoid UNIX' '.' and '..'
            $zip->addFile($name, $file->getFilename()); // Add current file to archive
        }

        $zip->close();

        if ( ! $outputToBrowser) {
            return $archivePath;
        }

        header("Content-Disposition: attachment; filename='$archivePath'");
        echo(file_get_contents($archivePath));
        unlink($archivePath);
        die();

    }

    /**
     * @param  string  $salt
     *
     * @return string
     */
    public static function pwgen(string $salt='my salt string'): string
    {
        return str_shuffle(strtolower(sha1(mt_rand().time().$salt)));
    }

    /**
     * надёжное определение протокола
     */
    public static function detectProto(): string
    {
        $protocol = 'http';

        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] === 'on') $protocol = 'https';
            if ($_SERVER['HTTPS'] === 1) $protocol = 'https';
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']))
            if ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
                $protocol = 'https';

        return $protocol;
    }

    /**
     * ADD PATH TO $PATH IN PHP
     *
     * @param  string  $path
     *
     * @example extendPath(getenv('HOME').'/.local/bin')
     * @example extendPath('/home/u/user/.local/bin')
     */
    public static function extendPath(string $path): void
    {
        putenv('PATH='.getenv('PATH').":$path");
    }
}
