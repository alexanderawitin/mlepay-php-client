<?php
/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */
namespace KKomarov\MLePay;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Request;
use KKomarov\MLePay\Dto\Notification;
use KKomarov\MLePay\Dto\Transaction;

/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */
interface ClientInterface
{
    /**
     * Create transaction url
     */
    const CREATE_TRANSACTION_URL = 'https://www.mlepay.com/api/v2/transaction/create';

    /**
     * Currency PHP
     */
    const CURRENCY_PHP = 'PHP';

    /**
     * Creates a transaction
     *
     * @param GuzzleHttpClient $guzzleClient  Guzzle http client
     * @param string           $recieverEmail The receiver email is your merchant email, this is unique to every account and is provided in the Merchant Profile page.
     * @param string           $senderEmail   The email address of the customer or buyer.
     * @param string           $senderName    The name of the customer or buyer.
     * @param string           $senderPhone   The mobile or landline phone number of the customer or buyer.
     * @param string           $senderAddress The address of the customer or buyer.
     * @param integer          $amount        The amount in centavos to be paid by the customer or buyer.
     * @param string           $currency      The currency of the transaction. Currently, only "PHP" is supported.
     * @param string           $nonce         A random unique 16-character string to identify this request. This is used as a security measure.
     * @param integer          $timestamp     The UNIX Timestamp of the current date and time. This is used as a security measure.
     * @param int              $expiry        The UNIX Timestamp of the date and time the transaction is set to expire. This is useful for transactions with a set "deadline" or "cutoff" for payments to be completed.
     * @param string           $payload       Custom transaction details. When the status of a transaction is changed, the payload will also be passed along with the other transaction details as a notification to the webhook. This will NOT be shown to the customer or buyer.
     * @param string           $description   The description of the transaction. This will be shown to the buyer or customer.
     *
     * @return Transaction
     */
    public function createTransaction(
        GuzzleHttpClient $guzzleClient,
        $recieverEmail,
        $senderEmail,
        $senderName,
        $senderPhone,
        $senderAddress,
        $amount,
        $currency = self::CURRENCY_PHP,
        $nonce,
        $timestamp,
        $expiry = 0,
        $payload = '',
        $description = ''
    );

    /**
     * Return notification
     *
     * @param Request $request    Incoming request
     * @param string  $webhookUrl Webhook url
     *
     * @return Notification
     */
    public function hookNotificaion(Request $request, $webhookUrl);
}