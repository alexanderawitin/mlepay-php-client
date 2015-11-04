<?php
/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay\HttpClient
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */

namespace KKomarov\MLePay\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use KKomarov\MLePay\ClientInterface;
use KKomarov\MLePay\HttpClient;
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
        // create guzzle mock
        $mock = new MockHandler([
            new Response(200, [], '{"content": {}, "transaction": {"currency": "PHP", "amount": 10000, "code": "EPAY-TEST-TGFLNHCSSNTH", "payload": "custom payload", "expiry": 1446681556}, "code": 200, "response": "SUCCESS", "description": "Transaction Generated."}'),
        ]);

        $handler          = HandlerStack::create($mock);
        $guzzleClientMock = new Client(['handler' => $handler]);
        // create a log channel
        $logger = new Logger('MLePay');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../artifacts/log'));

        $this->httpClient = new HttpClient(
            'secret key',
            $guzzleClientMock,
            $logger
        );
    }


    public function test_createTransaction()
    {
        $transaction = $this->httpClient->createTransaction(
            'test@example.com',
            'juan@example.com',
            'Sender name',
            'Sender phone',
            'Sender address',
            10000,
            ClientInterface::CURRENCY_PHP,
            substr(md5(time()), 0, 16),
            time(),
            time() + 3600,
            'custom payload',
            'description'
        );

        self::assertEquals(10000, $transaction->getAmount());
        self::assertEquals(ClientInterface::CURRENCY_PHP, $transaction->getCurrency());
        self::assertNotEmpty($transaction->getCode());
        self::assertEquals('custom payload', $transaction->getPayload());
    }


}
