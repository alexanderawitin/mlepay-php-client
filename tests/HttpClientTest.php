<?php
/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay\HttpClient
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */

namespace KKomarov\MLePay\HttpClient;

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use KKomarov\MLePay\ClientInterface;
use KKomarov\MLePay\Exceptions\TransactionException;
use KKomarov\MLePay\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    protected function setUp()
    {
        // create a log channel
        $logger = new Logger('log');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../artifacts/main.log'));

        $this->httpClient = new Client(
            'secret key',
            $logger
        );
    }

    public function test_createTransactionFail()
    {
        // create guzzle mock
        $mockHandler   = new MockHandler([
            new RequestException('Error', new Request('method', 'url'), new Response(TransactionException::ERROR))
        ]);
        $errorMessages = TransactionException::getErrorMessages();
        self::setExpectedException('\KKomarov\MLePay\Exceptions\TransactionException', $errorMessages[TransactionException::ERROR]);
        $this->createTransaction($mockHandler);
    }

    public function test_createTransaction()
    {
        // create guzzle mock
        $mockHandler = new MockHandler([
            new Response(200, [], '{"content": {}, "transaction": {"currency": "PHP", "amount": 10000, "code": "EPAY-TEST-TGFLNHCSSNTH", "payload": "custom payload", "expiry": 1446681556}, "code": 200, "response": "SUCCESS", "description": "Transaction Generated."}'),

        ]);
        $transaction = $this->createTransaction($mockHandler);

        self::assertInstanceOf('\KKomarov\MLePay\Dto\Transaction', $transaction);
        self::assertEquals(10000, $transaction->getAmount());
        self::assertEquals(ClientInterface::CURRENCY_PHP, $transaction->getCurrency());
        self::assertNotEmpty($transaction->getCode());
        self::assertEquals('custom payload', $transaction->getPayload());
    }

    /**
     * @param MockHandler $mockHandler
     *
     * @return \KKomarov\MLePay\Dto\Transaction
     * @throws TransactionException
     */
    private function createTransaction($mockHandler)
    {
        return $this->httpClient->createTransaction(
            new GuzzleHttpClient(['handler' => HandlerStack::create($mockHandler)]),
            'reciever@example.com',
            'sender@example.com',
            'Sender name',
            'Sender phone',
            'Sender address',
            10000,
            ClientInterface::CURRENCY_PHP,
            'nonce',
            123456,
            1234567,
            'custom payload',
            'description'
        );
    }


}
