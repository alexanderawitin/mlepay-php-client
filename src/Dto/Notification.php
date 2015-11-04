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
class Notification
{
    const TYPE_PAID      = 'PAID';
    const TYPE_EXPIRED   = 'EXPIRED';
    const TYPE_CREATED   = 'CREATED';
    const TYPE_CANCELLED = 'CANCELLED';

    /**
     * The merchant email of the owner of this transaction.
     *
     * @var string
     */
    protected $receiverEmail;
    /**
     * The Transaction Code of the Transaction this notification is about.
     * @var string
     */
    protected $transactionCode;

    /**
     * The current status of the transaction.
     * @var string
     */
    protected $transactionStatus;

    /**
     * The name of the buyer or customer.
     * @var string
     */
    protected $senderName;

    /**
     * The email address of the buyer or customer.
     * @var string
     */
    protected $senderEmail;

    /**
     * The phone number of the customer or buyer.
     * @var string
     */
    protected $senderPhone;

    /**
     * The address of the customer or buyer.
     * @var string
     */
    protected $senderAddress;

    /**
     * The amount in centavos paid (or to be paid) by the customer or buyer.
     * @var integer
     */
    protected $amount;

    /**
     * The currency of the transaction. Currently, only "PHP" is supported.
     * @var string
     */
    protected $currency;

    /**
     * The UNIX Timestamp of the date and time the transaction was set to expire, if set.
     * @var integer
     */
    protected $expiry;

    /**
     * The UNIX Timestamp of the current date and time. This is used as a security measure.
     * @var integer
     */
    protected $timestamp;

    /**
     * A random unique 16-character string to identify this request. This is used as a security measure.
     * @var string
     */
    protected $nonce;

    /**
     * Custom transaction details not shown to the customer. This was passed when the transaction was created.
     * @var string
     */
    protected $payload;

    /**
     * The description of the transaction. This was shown to the buyer or customer.
     * @var string
     */
    protected $description;

    /**
     * Notification constructor.
     *
     * @param string $receiverEmail
     * @param string $transactionCode
     * @param string $transactionStatus
     * @param string $senderName
     * @param string $senderEmail
     * @param string $senderPhone
     * @param string $senderAddress
     * @param int    $amount
     * @param string $currency
     * @param int    $expiry
     * @param int    $timestamp
     * @param string $nonce
     * @param string $payload
     * @param string $description
     */
    public function __construct($receiverEmail, $transactionCode, $transactionStatus, $senderName, $senderEmail, $senderPhone, $senderAddress, $amount, $currency, $expiry, $timestamp, $nonce, $payload, $description)
    {
        $this->receiverEmail     = $receiverEmail;
        $this->transactionCode   = $transactionCode;
        $this->transactionStatus = $transactionStatus;
        $this->senderName        = $senderName;
        $this->senderEmail       = $senderEmail;
        $this->senderPhone       = $senderPhone;
        $this->senderAddress     = $senderAddress;
        $this->amount            = $amount;
        $this->currency          = $currency;
        $this->expiry            = $expiry;
        $this->timestamp         = $timestamp;
        $this->nonce             = $nonce;
        $this->payload           = $payload;
        $this->description       = $description;
    }

    /**
     * @return string
     */
    public function getReceiverEmail()
    {
        return $this->receiverEmail;
    }

    /**
     * @param string $receiverEmail
     */
    public function setReceiverEmail($receiverEmail)
    {
        $this->receiverEmail = $receiverEmail;
    }

    /**
     * @return string
     */
    public function getTransactionCode()
    {
        return $this->transactionCode;
    }

    /**
     * @param string $transactionCode
     */
    public function setTransactionCode($transactionCode)
    {
        $this->transactionCode = $transactionCode;
    }

    /**
     * @return string
     */
    public function getTransactionStatus()
    {
        return $this->transactionStatus;
    }

    /**
     * @param string $transactionStatus
     */
    public function setTransactionStatus($transactionStatus)
    {
        $this->transactionStatus = $transactionStatus;
    }

    /**
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    }

    /**
     * @return string
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * @param string $senderEmail
     */
    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;
    }

    /**
     * @return string
     */
    public function getSenderPhone()
    {
        return $this->senderPhone;
    }

    /**
     * @param string $senderPhone
     */
    public function setSenderPhone($senderPhone)
    {
        $this->senderPhone = $senderPhone;
    }

    /**
     * @return string
     */
    public function getSenderAddress()
    {
        return $this->senderAddress;
    }

    /**
     * @param string $senderAddress
     */
    public function setSenderAddress($senderAddress)
    {
        $this->senderAddress = $senderAddress;
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

    /**
     * @return int
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * @param int $expiry
     */
    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * @param string $nonce
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

}