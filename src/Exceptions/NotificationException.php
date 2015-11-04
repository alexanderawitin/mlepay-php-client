<?php
/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay\Exceptions
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */
namespace KKomarov\MLePay\Exceptions;

/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay\Exceptions
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */
class NotificationException extends \Exception
{
    /**
     * Timestamp must be within a valid period (24 hours).
     */
    const EXPIRED_TIMESTAMP = 1;
    /**
     * Nonce mustn't be previously used within the past 24 hours
     */
    const USED_NONCE = 2;
    /**
     * Signatures do not match
     */
    const BAD_SIGNATURE = 3;

    public static function getErrorMessages()
    {
        return [
            self::EXPIRED_TIMESTAMP => 'Timestamp must be within a valid period (24 hours).',
            self::USED_NONCE        => 'Nonce mustn\'t be previously used within the past 24 hours',
            self::BAD_SIGNATURE     => 'Signatures do not match',
        ];
    }
}