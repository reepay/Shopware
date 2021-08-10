<?php
/**
 * CreateCharge
 *
 * PHP version 5
 *
 * @category Class
 * @package  Reepay
 * @author   Swaagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Reepay API
 *
 * REST API to manage Reepay resources
 *
 * OpenAPI spec version: 1
 *
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Reepay\Model;

use \ArrayAccess;

/**
 * CreateCharge Class Doc Comment
 *
 * @category    Class
 * @package     Reepay
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class CreateCharge implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'CreateCharge';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'handle' => 'string',
        'key' => 'string',
        'amount' => 'int',
        'currency' => 'string',
        'customer' => '\Reepay\Model\CreateCustomer',
        'source' => 'string',
        'settle' => 'bool',
        'ordertext' => 'string',
        'order_lines' => '\Reepay\Model\CreateOrderLine[]',
        'customer_handle' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'handle' => null,
        'key' => null,
        'amount' => 'int32',
        'currency' => null,
        'customer' => null,
        'source' => null,
        'settle' => null,
        'ordertext' => null,
        'order_lines' => null,
        'customer_handle' => null
    ];

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'handle' => 'handle',
        'key' => 'key',
        'amount' => 'amount',
        'currency' => 'currency',
        'customer' => 'customer',
        'source' => 'source',
        'settle' => 'settle',
        'ordertext' => 'ordertext',
        'order_lines' => 'order_lines',
        'customer_handle' => 'customer_handle'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'handle' => 'setHandle',
        'key' => 'setKey',
        'amount' => 'setAmount',
        'currency' => 'setCurrency',
        'customer' => 'setCustomer',
        'source' => 'setSource',
        'settle' => 'setSettle',
        'ordertext' => 'setOrdertext',
        'order_lines' => 'setOrderLines',
        'customer_handle' => 'setCustomerHandle'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'handle' => 'getHandle',
        'key' => 'getKey',
        'amount' => 'getAmount',
        'currency' => 'getCurrency',
        'customer' => 'getCustomer',
        'source' => 'getSource',
        'settle' => 'getSettle',
        'ordertext' => 'getOrdertext',
        'order_lines' => 'getOrderLines',
        'customer_handle' => 'getCustomerHandle'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }





    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['handle'] = isset($data['handle']) ? $data['handle'] : null;
        $this->container['key'] = isset($data['key']) ? $data['key'] : null;
        $this->container['amount'] = isset($data['amount']) ? $data['amount'] : null;
        $this->container['currency'] = isset($data['currency']) ? $data['currency'] : null;
        $this->container['customer'] = isset($data['customer']) ? $data['customer'] : null;
        $this->container['source'] = isset($data['source']) ? $data['source'] : null;
        $this->container['settle'] = isset($data['settle']) ? $data['settle'] : null;
        $this->container['ordertext'] = isset($data['ordertext']) ? $data['ordertext'] : null;
        $this->container['order_lines'] = isset($data['order_lines']) ? $data['order_lines'] : null;
        $this->container['customer_handle'] = isset($data['customer_handle']) ? $data['customer_handle'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        if ($this->container['handle'] === null) {
            $invalid_properties[] = "'handle' can't be null";
        }
        if (!is_null($this->container['amount']) && ($this->container['amount'] < 1)) {
            $invalid_properties[] = "invalid value for 'amount', must be bigger than or equal to 1.";
        }

        if ($this->container['source'] === null) {
            $invalid_properties[] = "'source' can't be null";
        }
        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        if ($this->container['handle'] === null) {
            return false;
        }
        if ($this->container['amount'] < 1) {
            return false;
        }
        if ($this->container['source'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets handle
     * @return string
     */
    public function getHandle()
    {
        return $this->container['handle'];
    }

    /**
     * Sets handle
     * @param string $handle Per account unique reference to charge/invoice. E.g. order id from own system. Multiple payments can be attempted for the same handle but only one authorized or settled charge can exist per handle. Max length 255 with allowable characters [a-zA-Z0-9_.-@].
     * @return $this
     */
    public function setHandle($handle)
    {
        $this->container['handle'] = $handle;

        return $this;
    }

    /**
     * Gets key
     * @return string
     */
    public function getKey()
    {
        return $this->container['key'];
    }

    /**
     * Sets key
     * @param string $key Optional idempotency key. Only one authorization or settle can be performed for the same handle. If two create attempts are attempted and the first succeeds the second will fail because charge is already settled or authorized. An idempotency key identifies uniquely the request and multiple requests with the same key and handle will yield the same result. In case of networking errors the same request with same key can safely be retried.
     * @return $this
     */
    public function setKey($key)
    {
        $this->container['key'] = $key;

        return $this;
    }

    /**
     * Gets amount
     * @return int
     */
    public function getAmount()
    {
        return $this->container['amount'];
    }

    /**
     * Sets amount
     * @param int $amount Amount in the smallest unit for the account currency. Either `amount` or `order_lines` must be provided if charge/invoice does not already exists.
     * @return $this
     */
    public function setAmount($amount)
    {

        if (!is_null($amount) && ($amount < 1)) {
            throw new \InvalidArgumentException('invalid value for $amount when calling CreateCharge., must be bigger than or equal to 1.');
        }

        $this->container['amount'] = $amount;

        return $this;
    }

    /**
     * Gets currency
     * @return string
     */
    public function getCurrency()
    {
        return $this->container['currency'];
    }

    /**
     * Sets currency
     * @param string $currency Optional currency in [ISO 4217](http://da.wikipedia.org/wiki/ISO_4217) three letter alpha code. If not provided the account default currency will be used. The currency of an existing charge or invoice cannot be changed.
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->container['currency'] = $currency;

        return $this;
    }

    /**
     * Gets customer
     * @return \Reepay\Model\CreateCustomer
     */
    public function getCustomer()
    {
        return $this->container['customer'];
    }

    /**
     * Sets customer
     * @param \Reepay\Model\CreateCustomer $customer Optional create customer object. An alternative to using a reference to an already created customer. If this object is provided and the customer already exists, the customer will be updated with the information provided in this object. Notice that customer cannot be changed for existing charge/invoice so if handle is given it must match the customer handle for existing customer.
     * @return $this
     */
    public function setCustomer($customer)
    {
        $this->container['customer'] = $customer;

        return $this;
    }

    /**
     * Gets source
     * @return string
     */
    public function getSource()
    {
        return $this->container['source'];
    }

    /**
     * Sets source
     * @param string $source The source for the payment. Either an existing payment method for the customer, e.g. `ca_...` or a card token `ct_...` generated with [Reepay Token](https://docs.reepay.com/token/) or [Reepay JS Library](https://docs.reepay.com/js/).
     * @return $this
     */
    public function setSource($source)
    {
        $this->container['source'] = $source;

        return $this;
    }

    /**
     * Gets settle
     * @return bool
     */
    public function getSettle()
    {
        return $this->container['settle'];
    }

    /**
     * Sets settle
     * @param bool $settle Whether or not to immediately settle the charge. Default is true. If not settled immediately the charge will be authorized and can later be settled. Normally this have to be done within 7 days.
     * @return $this
     */
    public function setSettle($settle)
    {
        $this->container['settle'] = $settle;

        return $this;
    }

    /**
     * Gets ordertext
     * @return string
     */
    public function getOrdertext()
    {
        return $this->container['ordertext'];
    }

    /**
     * Sets ordertext
     * @param string $ordertext Optional order text. Used in conjunction with `amount`. Ignored if `order_lines` is provided.
     * @return $this
     */
    public function setOrdertext($ordertext)
    {
        $this->container['ordertext'] = $ordertext;

        return $this;
    }

    /**
     * Gets order_lines
     * @return \Reepay\Model\CreateOrderLine[]
     */
    public function getOrderLines()
    {
        return $this->container['order_lines'];
    }

    /**
     * Sets order_lines
     * @param \Reepay\Model\CreateOrderLine[] $order_lines Order lines for the charge. The order lines controls the amount. Only required if charge/invoice does not already exist. If given for existing charge the order lines and amount are adjusted.
     * @return $this
     */
    public function setOrderLines($order_lines)
    {
        $this->container['order_lines'] = $order_lines;

        return $this;
    }

    /**
     * Gets customer_handle
     * @return string
     */
    public function getCustomerHandle()
    {
        return $this->container['customer_handle'];
    }

    /**
     * Sets customer_handle
     * @param string $customer_handle Customer reference. If charge does not already exist either this reference must be provided or a create customer object must be provided. .
     * @return $this
     */
    public function setCustomerHandle($customer_handle)
    {
        $this->container['customer_handle'] = $customer_handle;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\Reepay\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\Reepay\ObjectSerializer::sanitizeForSerialization($this));
    }
}


