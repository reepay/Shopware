# Reepay\DiscountApi

All URIs are relative to *https://api.reepay.com*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createDiscount**](DiscountApi.md#createDiscount) | **POST** /v1/discount | Create discount
[**deleteDiscount**](DiscountApi.md#deleteDiscount) | **DELETE** /v1/discount/{handle} | Delete discount
[**getDiscount**](DiscountApi.md#getDiscount) | **GET** /v1/discount/{handle} | Get discount
[**getDiscounts**](DiscountApi.md#getDiscounts) | **GET** /v1/discount | Get list of discounts
[**undeleteDiscount**](DiscountApi.md#undeleteDiscount) | **POST** /v1/discount/{handle}/undelete | Undelete discount


# **createDiscount**
> \Reepay\Model\Discount createDiscount($body)

Create discount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKey
Reepay\Configuration::getDefaultConfiguration()->setApiKey('X-Auth-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Reepay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Auth-Token', 'Bearer');
// Configure HTTP basic authorization: basicAuth
Reepay\Configuration::getDefaultConfiguration()->setUsername('YOUR_USERNAME');
Reepay\Configuration::getDefaultConfiguration()->setPassword('YOUR_PASSWORD');

$apiInstance = new Reepay\Api\DiscountApi();
$body = new \Reepay\Model\CreateDiscount(); // \Reepay\Model\CreateDiscount |

try {
    $result = $apiInstance->createDiscount($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountApi->createDiscount: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Reepay\Model\CreateDiscount**](../Model/CreateDiscount.md)|  | [optional]

### Return type

[**\Reepay\Model\Discount**](../Model/Discount.md)

### Authorization

[apiKey](../../README.md#apiKey), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteDiscount**
> \Reepay\Model\Discount deleteDiscount($handle)

Delete discount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKey
Reepay\Configuration::getDefaultConfiguration()->setApiKey('X-Auth-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Reepay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Auth-Token', 'Bearer');
// Configure HTTP basic authorization: basicAuth
Reepay\Configuration::getDefaultConfiguration()->setUsername('YOUR_USERNAME');
Reepay\Configuration::getDefaultConfiguration()->setPassword('YOUR_PASSWORD');

$apiInstance = new Reepay\Api\DiscountApi();
$handle = "handle_example"; // string | Discount handle

try {
    $result = $apiInstance->deleteDiscount($handle);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountApi->deleteDiscount: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **handle** | **string**| Discount handle |

### Return type

[**\Reepay\Model\Discount**](../Model/Discount.md)

### Authorization

[apiKey](../../README.md#apiKey), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getDiscount**
> \Reepay\Model\Discount getDiscount($handle)

Get discount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKey
Reepay\Configuration::getDefaultConfiguration()->setApiKey('X-Auth-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Reepay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Auth-Token', 'Bearer');
// Configure HTTP basic authorization: basicAuth
Reepay\Configuration::getDefaultConfiguration()->setUsername('YOUR_USERNAME');
Reepay\Configuration::getDefaultConfiguration()->setPassword('YOUR_PASSWORD');

$apiInstance = new Reepay\Api\DiscountApi();
$handle = "handle_example"; // string | Discount handle

try {
    $result = $apiInstance->getDiscount($handle);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountApi->getDiscount: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **handle** | **string**| Discount handle |

### Return type

[**\Reepay\Model\Discount**](../Model/Discount.md)

### Authorization

[apiKey](../../README.md#apiKey), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getDiscounts**
> \Reepay\Model\DiscountSearch getDiscounts($page, $size, $search, $sort)

Get list of discounts



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKey
Reepay\Configuration::getDefaultConfiguration()->setApiKey('X-Auth-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Reepay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Auth-Token', 'Bearer');
// Configure HTTP basic authorization: basicAuth
Reepay\Configuration::getDefaultConfiguration()->setUsername('YOUR_USERNAME');
Reepay\Configuration::getDefaultConfiguration()->setPassword('YOUR_PASSWORD');

$apiInstance = new Reepay\Api\DiscountApi();
$page = 1; // int | Page number to get
$size = 20; // int | Page size to use
$search = "search_example"; // string | Optional search expression
$sort = "sort_example"; // string | Optional sorting expression

try {
    $result = $apiInstance->getDiscounts($page, $size, $search, $sort);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountApi->getDiscounts: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| Page number to get | [default to 1]
 **size** | **int**| Page size to use | [default to 20]
 **search** | **string**| Optional search expression |
 **sort** | **string**| Optional sorting expression |

### Return type

[**\Reepay\Model\DiscountSearch**](../Model/DiscountSearch.md)

### Authorization

[apiKey](../../README.md#apiKey), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **undeleteDiscount**
> \Reepay\Model\Discount undeleteDiscount($handle)

Undelete discount



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKey
Reepay\Configuration::getDefaultConfiguration()->setApiKey('X-Auth-Token', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Reepay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Auth-Token', 'Bearer');
// Configure HTTP basic authorization: basicAuth
Reepay\Configuration::getDefaultConfiguration()->setUsername('YOUR_USERNAME');
Reepay\Configuration::getDefaultConfiguration()->setPassword('YOUR_PASSWORD');

$apiInstance = new Reepay\Api\DiscountApi();
$handle = "handle_example"; // string | Discount handle

try {
    $result = $apiInstance->undeleteDiscount($handle);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountApi->undeleteDiscount: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **handle** | **string**| Discount handle |

### Return type

[**\Reepay\Model\Discount**](../Model/Discount.md)

### Authorization

[apiKey](../../README.md#apiKey), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

