<?php
/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */
namespace KKomarov\MLePay;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use KKomarov\MLePay\Dto\Notification;
use KKomarov\MLePay\Dto\Transaction;
use KKomarov\MLePay\Exceptions\NotificationException;
use KKomarov\MLePay\Exceptions\TransactionException;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */
class HttpClient implements ClientInterface
{
    use LoggerAwareTrait;

    /**
     * @var Client
     */
    protected $guzzleHttpClient;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * HttpClient constructor.
     *
     * @param string          $secretKey        Secret key
     * @param Client          $guzzleHttpClient Guzzle http client
     * @param LoggerInterface $logger           Logger
     */
    public function __construct($secretKey, Client $guzzleHttpClient, LoggerInterface $logger)
    {
        $this->secretKey        = $secretKey;
        $this->guzzleHttpClient = $guzzleHttpClient;
        $this->setLogger($logger);
    }

    /**
     * Creates a transaction
     *
     * @param string  $recieverEmail The receiver email is your merchant email, this is unique to every account and is provided in the Merchant Profile page.
     * @param string  $senderEmail   The email address of the customer or buyer.
     * @param string  $senderName    The name of the customer or buyer.
     * @param string  $senderPhone   The mobile or landline phone number of the customer or buyer.
     * @param string  $senderAddress The address of the customer or buyer.
     * @param integer $amount        The amount in centavos to be paid by the customer or buyer.
     * @param string  $currency      The currency of the transaction. Currently, only "PHP" is supported.
     * @param string  $nonce         A random unique 16-character string to identify this request. This is used as a security measure.
     * @param integer $timestamp     The UNIX Timestamp of the current date and time. This is used as a security measure.
     * @param int     $expiry        The UNIX Timestamp of the date and time the transaction is set to expire. This is useful for transactions with a set "deadline" or "cutoff" for payments to be completed.
     * @param string  $payload       Custom transaction details. When the status of a transaction is changed, the payload will also be passed along with the other transaction details as a notification to the webhook. This will NOT be shown to the customer or buyer.
     * @param string  $description   The description of the transaction. This will be shown to the buyer or customer.
     *
     * @return Transaction
     * @throws \Exception
     */
    public function createTransaction(
        $recieverEmail,
        $senderEmail,
        $senderName,
        $senderPhone,
        $senderAddress,
        $amount,
        $currency = 'PHP',
        $nonce,
        $timestamp,
        $expiry = 0,
        $payload = '',
        $description = ''
    )
    {
        $requestBody = json_encode([
            'receiver_email' => $recieverEmail,
            'sender_email'   => $senderEmail,
            'sender_name'    => $senderName,
            'sender_phone'   => $senderPhone,
            'sender_address' => $senderAddress,
            'amount'         => $amount,
            'currency'       => self::CURRENCY_PHP,
            'nonce'          => $nonce,
            'timestamp'      => $timestamp,
            'expiry'         => $expiry,
            'payload'        => $payload,
            'description'    => $description
        ]);

        try {
            $response        = $this->guzzleHttpClient->post(
                self::CREATE_TRANSACTION_URL,
                [
                    'body'    => $requestBody,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Signature'  => $this->getSignature(self::CREATE_TRANSACTION_URL, $requestBody)
                    ]
                ]
            );
            $responseHeaders = $response->getHeaders();
            $responseBody    = $response->getBody()->getContents();
            $responseJson    = json_decode($responseBody, true);
            $this->logger->debug('Create transaction response:', [
                'headers' => $responseHeaders,
                'body'    => $responseJson
            ]);

            return new Transaction(
                $responseJson['transaction']['amount'],
                $responseJson['transaction']['payload'],
                $responseJson['transaction']['code'],
                $responseJson['transaction']['currency']);
        } catch (\HttpRequestException $e) {
            $this->logger->error('Create transaction response:', [
                'message' => $e->getMessage()
            ]);
            $errorMessages = TransactionException::getErrorMessages();
            $errorMessage  = $errorMessages[TransactionException::ERROR];
            $errorCode     = TransactionException::ERROR;
            if (array_key_exists($e->getCode(), $errorMessages)) {
                $errorMessage = $errorMessages[$errorCode];
                $errorCode    = $e->getCode();
            }

            throw new TransactionException($errorMessage, $errorCode, $e);
        }
    }

    /**
     * Return notification
     *
     * @param Request $request    Incoming request
     * @param string  $webhookUrl Webhook url
     *
     * @return Notification
     * @throws NotificationException
     */
    public function hookNotificaion(Request $request, $webhookUrl)
    {
        $signature   = $request->getHeaderLine('X-Signature');
        $requestBody = $request->getBody();

        $errorMessages = NotificationException::getErrorMessages();
        if ($signature !== $this->getSignature($webhookUrl, $requestBody)) {
            throw new NotificationException($errorMessages[NotificationException::BAD_SIGNATURE], NotificationException::BAD_SIGNATURE);
        }

        if ($body = json_decode($requestBody, true)) {
            if (time() - (int) $body['timestamp'] > 86400) {
                throw new NotificationException($errorMessages[NotificationException::EXPIRED_TIMESTAMP], NotificationException::EXPIRED_TIMESTAMP);
            }

            return new Notification(
                $body['receiver_email'],
                $body['transaction_code'],
                $body['transaction_status'],
                $body['sender_name'],
                $body['sender_email'],
                $body['sender_phone'],
                $body['sender_address'],
                $body['amount'],
                $body['currency'],
                $body['expiry'],
                $body['timestamp'],
                $body['nonce'],
                $body['payload'],
                $body['description']
            );
        }
    }

    /**
     * Returns calculated signature
     *
     * @param string $url         Url
     * @param string $requestBody Request body
     *
     * @return string
     */
    private function getSignature($url, $requestBody)
    {
        $baseString = sprintf('POST&%s&%s', $this->getPreparedUrl($url), rawurlencode($requestBody));

        return base64_encode(hash_hmac('sha256', $baseString, $this->secretKey, true));
    }

    /**
     * Pythons urllib.quote???
     *
     * @param string $url Url
     *
     * @return string
     */
    private function getPreparedUrl($url)
    {
        return str_replace(':', '%3A', $url);
    }
}