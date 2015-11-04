<?php
/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay\Dto
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */
namespace KKomarov\MLePay\Dto;

/**
 * PHP version 5
 *
 * @package   KKomarov\MLePay\Dto
 * @author    Kirill Komarov <kirill.komarov@gmail.com>
 * @link      https://github.com/k-komarov/mlepay-php-client
 */
class Transaction
{
    /**
     * @var integer
     */
    protected $amount;

    /**
     * @var string
     */
    protected $payload, $code, $currency;

    /**
     * Transaction constructor.
     *
     * @param int    $amount
     * @param string $payload
     * @param string $code
     * @param string $currency
     */
    public function __construct($amount, $payload, $code, $currency)
    {
        $this->amount   = $amount;
        $this->payload  = $payload;
        $this->code     = $code;
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

}