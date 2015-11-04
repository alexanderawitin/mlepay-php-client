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
class TransactionException extends \Exception
{
    /**
     * Ensure that the request signature is generated with HMAC-SHA256 and that the secret key being used is the right one.
     */
    const INCORRECT_SIGNATURE = 460;

    /**
     * The server cannot find the merchant account.
     */
    const MERCHANT_DOES_NOT_EXIST = 404;

    /**
     * Ensure that all the required headers for the request are set.
     */
    const MISSING_REQUEST_HEADERS = 406;

    /**
     * JSON dump the payload/body of the request. Also make sure that you Content-Type is set to 'aplication/json'.
     */
    const INVALID_PAYLOAD = 406;

    /**
     * The merchant account may be in an unapproved or frozen state.
     */
    const UNABLE_TO_PROCESS = 401;

    /**
     * The server cannot generate a transaction code for the request at the moment.
     */
    const CANNOT_GENERATE_TRANSACTION_CODE = 462;

    /**
     * The HTTP POST data has lacking required parameters. This would be a good time to double check spelling.
     */
    const REQUIRED_PARAMETER_MISSING = 463;

    /**
     * The amount value should be positive in centavos without a decimal point.
     * All transactions with negative "amount" value are rejected and returned with an error.
     */
    const INVALID_AMOUNT_VALUE = 463;

    /**
     * The transaction request timestamp has exceeded the 24-hour limit.
     */
    const EXPIRED_TRANSACTION = 463;

    /**
     * A server-side error occured. Contact us at help@mlepay.com if the error persists after several retries.
     */
    const ERROR = 500;


    public static function getErrorMessages()
    {
        return [
            self::INCORRECT_SIGNATURE              => 'Ensure that the request signature is generated with HMAC-SHA256 and that the secret key being used is the right one.',
            self::MERCHANT_DOES_NOT_EXIST          => 'The server cannot find the merchant account.',
            self::MISSING_REQUEST_HEADERS          => 'Ensure that all the required headers for the request are set.',
            self::INVALID_PAYLOAD                  => 'JSON dump the payload/body of the request. Also make sure that you Content-Type is set to \'aplication/json\'.',
            self::UNABLE_TO_PROCESS                => 'The merchant account may be in an unapproved or frozen state.',
            self::CANNOT_GENERATE_TRANSACTION_CODE => 'The server cannot generate a transaction code for the request at the moment.',
            self::REQUIRED_PARAMETER_MISSING       => 'The HTTP POST data has lacking required parameters. This would be a good time to double check spelling.',
            self::INVALID_AMOUNT_VALUE             => 'The amount value should be positive in centavos without a decimal point. All transactions with negative "amount" value are rejected and returned with an error.',
            self::EXPIRED_TRANSACTION              => 'The transaction request timestamp has exceeded the 24-hour limit.',
            self::ERROR                            => 'A server-side error occured. Contact us at help@mlepay.com if the error persists after several retries.',
        ];
    }
}