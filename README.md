WebMoney API PHP Library
========================
[![Packagist](https://img.shields.io/packagist/l/baibaratsky/php-webmoney.svg)](https://github.com/baibaratsky/php-webmoney/blob/master/LICENSE.md)
[![Dependency Status](https://www.versioneye.com/user/projects/5531680a10e714f9e50010ad/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5531680a10e714f9e50010ad)
[![Packagist](https://img.shields.io/packagist/v/baibaratsky/php-webmoney.svg)](https://packagist.org/packages/baibaratsky/php-webmoney)
[![Packagist](https://img.shields.io/packagist/dt/baibaratsky/php-webmoney.svg)](https://packagist.org/packages/baibaratsky/php-webmoney)

Get transparent object-oriented interaction with WebMoney API.

If you just need to sign your requests to the API, use [WebMoney Signer](https://github.com/baibaratsky/php-wmsigner), a native PHP implementation of the WMSigner authentication module. 

XML-interfaces supported
------------------------
- [X1](https://github.com/baibaratsky/php-webmoney/wiki/X1): sending invoice from merchant to customer
- [X2](https://github.com/baibaratsky/php-webmoney/wiki/X2): transferring funds from one purse to another
- [X3](https://github.com/baibaratsky/php-webmoney/wiki/X3): transactions history, checking transactions status
- [X4](https://github.com/baibaratsky/php-webmoney/wiki/X4): issued invoices history, verifying whether the invoices were paid
- [X5](https://github.com/baibaratsky/php-webmoney/wiki/X5): completing a code-protected transaction
- [X6](https://github.com/baibaratsky/php-webmoney/wiki/X6): sending message to any WM-identifier via internal mail
- [X8](https://github.com/baibaratsky/php-webmoney/wiki/X8): retrieving information about purse ownership, searching for system user by his/her identifier or purse
- [X9](https://github.com/baibaratsky/php-webmoney/wiki/X9): retrieving information about purse balance
- [X11](https://github.com/baibaratsky/php-webmoney/wiki/X11): retrieving information from client’s passport by WM-identifier
- [X13](https://github.com/baibaratsky/php-webmoney/wiki/X13): recalling incomplete protected transaction
- [X14](https://github.com/baibaratsky/php-webmoney/wiki/X14): fee-free refund
- [X15](https://github.com/baibaratsky/php-webmoney/wiki/X15): trust management
- [X17](https://github.com/baibaratsky/php-webmoney/wiki/X17): operations with arbitration contracts
- [X18](https://github.com/baibaratsky/php-webmoney/wiki/X18): getting transaction details via merchant.webmoney
- [X19](https://github.com/baibaratsky/php-webmoney/wiki/X19): verifying personal information for the owner of a WM identifier
- [X21](https://github.com/baibaratsky/php-webmoney/wiki/X21): setting trust for merchant payments by SMS
- [X22](https://github.com/baibaratsky/php-webmoney/wiki/X22): receiving the ticket of prerequest payment form at merchant.webmoney

Megastock interfaces supported
------------------------------
- Interface for [adding Payment Integrator's merchants](https://github.com/baibaratsky/php-webmoney/wiki/Adding-Payment-Integrator%27s-merchant)
- Interface for [check status of merchant](https://github.com/baibaratsky/php-webmoney/wiki/Check-status-of-merchant)

Requirements
------------
The library requires PHP 5.3 compiled with [cURL extension](http://www.php.net/manual/en/book.curl.php) (but you can override cURL dependencies).

Installation
------------
0. Install [Composer](http://getcomposer.org/):

    ```
    curl -sS https://getcomposer.org/installer | php
    ```

0. Add the php-webmoney dependency:

    ```
    php composer.phar require baibaratsky/php-webmoney:0.14.*
    ```

Usage
-----
**There are more usage examples in [the project wiki](https://github.com/baibaratsky/php-webmoney/wiki).**
```php
require_once(__DIR__ . '/vendor/autoload.php'); // Require autoload file generated by composer

use baibaratsky\WebMoney;
use baibaratsky\WebMoney\Api\X\X9\Request;
use baibaratsky\WebMoney\Api\X\X9\Response;
use baibaratsky\WebMoney\Request\Requester\CurlRequester;
use baibaratsky\WebMoney\Signer;

// If you don’t want to use the WM root certificate to protect against DNS spoofing, pass false to the CurlRequester constructor
$webMoney = new WebMoney\WebMoney(new CurlRequester);

$request = new Request;
$request->setSignerWmid('YOUR WMID');
$request->setRequestedWmid('REQUESTED WMID');

$key = 'FULL PATH TO THE KEY FILE';
// or key is a data string from DB, cache, etc.
// $key = getKeyData();

$request->sign(new Signer('YOUR WMID', $key, 'KEY FILE PASSWORD'));

// You can access the request XML: $request->getData()

if ($request->validate()) {
    /** @var Response $response */
    $response = $webMoney->request($request);

    // The response from WebMoney is here: $response->getRawData()

    if ($response->getReturnCode() === 0) {
        echo $response->getPurseByName('Z000000000000')->getAmount();
    } else {
        echo 'Error: ' . $response->getReturnDescription();
    }
}
```

Authentication with a Light certificate
---------------------------------------
In case of authentication with a Light certificate, pass `Request::AUTH_LIGHT` to the request constructor
and use `cert()` instead of `sign()`.
```php
require_once(__DIR__ . '/vendor/autoload.php'); // Require autoload file generated by composer

use baibaratsky\WebMoney;
use baibaratsky\WebMoney\Api\X\X9\Request;
use baibaratsky\WebMoney\Api\X\X9\Response;
use baibaratsky\WebMoney\Request\Requester\CurlRequester;

// If you don’t want to use the WM root certificate to protect against DNS spoofing, pass false to the CurlRequester constructor
$webMoney = new WebMoney\WebMoney(new CurlRequester);

$request = new Request(Request::AUTH_LIGHT);
$request->setRequestedWmid('REQUESTED WMID');

$request->cert('FULL PATH TO THE CERTIFICATE FILE', 'FULL PATH TO THE CERTIFICATE KEY', '(OPTIONAL) PASSWORD');

// You can access the request XML: $request->getData()

if ($request->validate()) {
    /** @var Response $response */
    $response = $webMoney->request($request);

    // The response from WebMoney is here: $response->getRawData()

    if ($response->getReturnCode() === 0) {
        echo $response->getPurseByName('Z000000000000')->getAmount();
    } else {
        echo 'Error: ' . $response->getReturnDescription();
    }
}
```
