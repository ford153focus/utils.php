<?php
declare(strict_types=1);

namespace FordRT\Utils;

use CurlHandle;
use JetBrains\PhpStorm\ArrayShape;

class CurlWrapper
{
    private CurlHandle $ch;

    public function __construct(string $url= 'https://example.com', string $method='get')
    {
        $this->ch = curl_init();
        $this->setUrl($url);
        $this->setMethod($method);
    }

    /**
     * @param  \CurlHandle  $curlHandle
     *
     * @return static
     * @noinspection MissingOrEmptyGroupStatementInspection
     */
    public static function fromHandle(CurlHandle $curlHandle): static
    {
        $url = curl_getinfo($curlHandle, CURLOPT_URL);

        $method='get';
        if(curl_getinfo($curlHandle, CURLOPT_CUSTOMREQUEST) === 'DELETE') $method ='delete';
        if(curl_getinfo($curlHandle, CURLOPT_CUSTOMREQUEST) === 'PUT')    $method ='put';
        if(curl_getinfo($curlHandle, CURLOPT_CUSTOMREQUEST) === 'PATCH')  $method ='patch';
        if(curl_getinfo($curlHandle, CURLOPT_NOBODY))                     $method ='head';
        if(curl_getinfo($curlHandle, CURLOPT_POST))                       $method ='post';

        return new static($url, $method);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

    /**
     * @return \CurlHandle
     */
    public function copyHandler(): CurlHandle
    {
        return curl_copy_handle($this->ch);
    }

    /**
     * disable ssl check
     *
     * @noinspection CurlSslServerSpoofingInspection*/
    public function disableSslCheck(): void
    {
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
    }

    /**
     * Возвращает код последней ошибки и строку с описанием последней ошибки текущего сеанса
     * @see https://www.php.net/manual/ru/function.curl-errno.php
     * @see https://www.php.net/manual/ru/function.curl-error.php
     *
     * @return array
     */
    #[ArrayShape(['code' => "int", 'description' => "string"])]
    public function getError(): array
    {
        return [
            'code' => curl_errno($this->ch),
            'description' => curl_error($this->ch)
        ];
    }

    /**
     * Возвращает информацию об определённой операции
     * @see https://www.php.net/manual/ru/function.curl-getinfo.php
     */
    public function getInfo(): mixed
    {
        return curl_getinfo($this->ch);
    }

    /**
     * Кодирует заданную строку как URL
     * @see https://www.php.net/manual/ru/function.curl-escape.php
     *
     * @param  string  $string
     *
     * @return string|false
     */
    public function escape(string $string): string|false
    {
        return curl_escape($this->ch, $string);
    }

    /**
     * Выполняет запрос cURL
     * @see https://www.php.net/manual/ru/function.curl-exec.php
     *
     * @return string|bool
     */
    public function execute(): string|bool
    {
        return curl_exec($this->ch);
    }

    /**
     * @param  bool  $follow
     */
    public function followRedirects(bool $follow): void
    {
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, $follow);
    }

    public function setOption(int $option, mixed $value): bool
    {
        return curl_setopt($this->ch, $option, $value);
    }

    public function setOptionsArray(array $options): bool
    {
        return curl_setopt_array($this->ch, $options);
    }

    /**
     * @param  string  $url
     */
    public function setUrl(string $url): void
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
    }

    /**
     * Установить альтернативный порт соединения.
     * @param  int  $port
     */
    public function setPort(int $port): void
    {
        curl_setopt($this->ch, CURLOPT_PORT, $port);
    }

    /**
     * Установить содержимое заголовка "Referer: ", который будет использован в HTTP-запросе.
     * @param  string  $referer
     */
    public function setReferer(string $referer): void
    {
        curl_setopt($this->ch, CURLOPT_REFERER, $referer);
    }

    /**
     * @param  string  $method
     */
    public function setMethod(string $method): void
    {
        switch (strtolower($method)) {
            case 'delete':
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'get':
                curl_setopt($this->ch, CURLOPT_HTTPGET, true);
                break;
            case 'head':
                curl_setopt($this->ch, CURLOPT_NOBODY, true);
                break;
            case 'post':
                curl_setopt($this->ch, CURLOPT_POST, true);
                break;
            case 'patch':
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                break;
            case 'put':
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
        }
    }

    /**
     * Сбросить все настройки обработчика сессии libcurl
     */
    public function reset(): void
    {
        curl_reset($this->ch);
    }

    /**
     * Декодирует закодированную URL-строку
     * @see https://www.php.net/manual/ru/function.curl-unescape.php
     *
     * @param  string  $string
     *
     * @return string|false
     */
    public function unescape(string $string): string|false
    {
        return curl_unescape($this->ch, $string);
    }

    /**
     * Возвращает версию cURL
     * @see https://www.php.net/manual/ru/function.curl-version.php
     *
     * @return array|false
     */
    #[ArrayShape(["version_number"     => "string",
                  "version"            => "string",
                  "ssl_version_number" => "int",
                  "ssl_version"        => "string",
                  "libz_version"       => "string",
                  "host"               => "string",
                  "age"                => "int",
                  "features"           => "int",
                  "protocols"          => "array"
    ])]
    public static function version(): bool|array
    {
        return curl_version();
    }
}
