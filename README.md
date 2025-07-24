\# PHP bKash Payment Gateway



\[!\[Packagist Version](https://img.shields.io/packagist/v/wmsn-web/bkash-php-client.svg)](https://packagist.org/packages/wmsn-web/bkash-php-client) \[!\[License](https://img.shields.io/packagist/l/wmsn-web/bkash-php-client.svg)](LICENSE) 



A simple, lightweight PHP library for integrating the bKash REST payment gateway in your PHP projects.

---



\## Features

\* Create Token

\* Refresh Token

\* Create \& execute payments

\* Handle payment callbacks

\* Issue refunds

\* Query transaction status

\* Sandbox \& production modes



\## Requirements



\* PHP 7.4+

\* cURL extension enabled

\* Composer



\## Installation



Install via Composer:



```bash

composer require wmsn-web/BkashPhpClient

```



Then in your PHP code, initialize the client:



```php

use WsmnWeb\\BkashPhpClient;



$bkash = new BkashPhpClient(\[

&nbsp;   "base\_url" => "https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized",

&nbsp;   "username" => "YOU\_BKASH\_USERNAME",

&nbsp;   "password" => "BKASH\_PASSWORD",

&nbsp;   "app\_key" => "BKASH\_APP\_KEY",

&nbsp;   "app\_secret" => "BKASH\_APP\_SECRET\_KEY",

&nbsp;   "type"      =>"sandbox" // or 'prod'

]);

```

OR



```php

$credentials = array(

&nbsp;   "base\_url" => "https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized",

&nbsp;   "username" => "YOU\_BKASH\_USERNAME",

&nbsp;   "password" => "BKASH\_PASSWORD",

&nbsp;   "app\_key" => "BKASH\_APP\_KEY",

&nbsp;   "app\_secret" => "BKASH\_APP\_SECRET\_KEY",

&nbsp;   "type"      =>"sandbox" // or 'prod'

);



$bkash = new BkashPhpClient($credentials);

```



\## Usage Examples



\### 1. Grant Token



Grant Token API provides an access token as a response. This token can be used to access other bKash APIs as authorization parameter. Once the token gets expired, new token can be generated through Refresh Token API.



```php

$response = $bkash->GrantToken();

```

Sample Response



```php

\[

&nbsp; "token\_type"=> "Bearer",

&nbsp; "id\_token"=> "test\_id\_token\_value",

&nbsp; "expires\_in"=> 3600,

&nbsp; "refresh\_token"=> "test\_refresh\_token\_value"

]

```

Save the `id\_token` into the database for reuse without generate a new token. Once it get expire (3600 seconds) Refresh a new token using `refresh\_token`.



\### 2. Refresh Token



This API provides a new access token against the existing token. This new token can be used in subsequent bKash API calls.



```php

$response = $bkash->refreshToken($refresh\_token);

```

```

\[

&nbsp; "token\_type"=> "Bearer",

&nbsp; "id\_token"=> "test\_id\_token\_value",

&nbsp; "expires\_in"=> 3600,

&nbsp; "refresh\_token"=> "test\_refresh\_token\_value"

]



```





\### 3. Create a Payment



Through this API, a tokenized payment creation request is received by bKash. Upon validation of customer's wallet information, the create payment request will be confirmed by the Execute Payment request.



Get `$token` from your database.



```php

$postArray = \[

&nbsp;   'mode'                  => '0011',

&nbsp;   'amount'                => 100,

&nbsp;   'payerReference'        =>"11",

&nbsp;   'callbackURL'           => Your callback URL

&nbsp;   'currency'              => 'BDT',

&nbsp;   'intent'                => 'sale',

&nbsp;   'merchantInvoiceNumber' => INVOICE NUMBER

];

$response = $bkash->createPayment($token, $postArray);

```

Sample response



```PHP

\[

&nbsp;   "statusCode"                => "0000", 

&nbsp;   "statusMessage"             => "Successful", 

&nbsp;   "paymentID"                 => "TR0001VK1565072365492", //Timespan 24 hours

&nbsp;   "bkashURL"                  =>"URL TO CHECKOUT THE PAYMENT",

&nbsp;   "callbackURL"               => "https://yourdomain.com/callback?version=v1.2.0-beta\&product=tokenized-checkout",

&nbsp;   "successCallbackURL"        => "https://yourdomain.com/callback?version=v1.2.0-beta\&product=tokenized-checkout\&paymentID=TR0011dQPHnuY1720518383420\&status=success\&signature=cm8HBfl65A",

&nbsp;   "failureCallbackURL"        => "https://yourdomain.com/callback?version=v1.2.0-beta\&product=tokenized-checkout\&paymentID=TR0011dQPHnuY1720518383420\&status=failure\&signature=cm8HBfl65A",

&nbsp;   "cancelledCallbackURL"      => "https://yourdomain.com/callback?version=v1.2.0-beta\&product=tokenized-checkout\&paymentID=TR0011dQPHnuY1720518383420\&status=cancel\&signature=cm8HBfl65A",

&nbsp;   "amount"                    => "500", 

&nbsp;   "intent"                    => "sale", 

&nbsp;   "currency"                  => "BDT", 

&nbsp;   "agreementID"               => "TokenizedMerchant01L3IKB6H1565072174986", 

&nbsp;   "paymentCreateTime"         => "2019-08-06T12:19:25:593 GMT+0600", 

&nbsp;   "transactionStatus"         => "Initiated", 

&nbsp;   "merchantInvoiceNumber"     => "Inv0124" 

]

```



\### 4. Execute the Payment



Using this API, a tokenized payment request created using the Create Payment API can be finalized. Thus, a payment can be successful or can be failure. The final result of the payment request can be found through this API.



Basically in callback URL Execute payment API should be call to confirm the payment.



Get `$token` from your database.



```php

$response = $bkash->executePayment($token, $response\['paymentID']);

```

Sample Response



```php

\[ 

&nbsp;   "statusCode"                => "0000", 

&nbsp;   "statusMessage"             => "Successful", 

&nbsp;   "paymentID"                 => "TR0001VK1565072365492", 

&nbsp;   "agreementID"               => "TokenizedMerchant01L3IKB6H1565072174986", 

&nbsp;   "payerReference"            => "01770618575", 

&nbsp;   "customerMsisdn"            => "01770618575", 

&nbsp;   "trxID"                     => "6H6201QDIY", 

&nbsp;   "amount"                    => "12", 

&nbsp;   "transactionStatus"         => "Completed", 

&nbsp;   "paymentExecuteTime"        => "2019-08-06T12:22:41:428 GMT+0600", 

&nbsp;   "currency"                  => "BDT", 

&nbsp;   "intent"                    => "sale", 

&nbsp;   "merchantInvoiceNumber"     => "TestForOnmobile" 

]

```



\### 5. Query Transaction Status



```php

$paymentID = 'PAYMENT\_ID\_FROM\_CREATE';

$token = 'from your database'.

$response = $bkash->paymentStatus($token, $paymentID);

```







\## Configuration Options



| Option       | Type   | Default     | Description                     |

| ------------ | ------ | ----------- | ------------------------------- |

| `app\_key`    | string | `null`      | Your bKash API App Key          |

| `app\_secret` | string | `null`      | Your bKash API App Secret       |

| `username`   | string | `null`      | API username                    |

| `password`   | string | `null`      | API password                    |

| `base\_url`   | string | Sandbox URL | Base URL for bKash endpoints    |

| `mode`       | string | `sandbox`   | `sandbox` or `production`       |

| `timeout`    | int    | `30`        | HTTP request timeout in seconds |



\## Running Tests



This library uses PHPUnit. To run tests:



```bash

composer install

./vendor/bin/phpunit --configuration phpunit.xml

```



> \*\*Tip:\*\* Copy `phpunit.xml.dist` to `phpunit.xml` and update with your sandbox credentials.



\## Examples Directory



See the `examples/` directory for full scripts:



\* `grant\_token.php`

\* `refresh\_token.php`

\* `create\_payment.php`

\* `execute\_payment.php`

\* `refund\_payment.php`

\* `query\_status.php`







Please follow PSR-12 coding standards and ensure all tests pass.



\## Troubleshooting



\* \*\*Authentication errors\*\*: Double-check your `app\_key`, `app\_secret`, `username`, and `password`.

\* \*\*Timeouts\*\*: Increase the `timeout` option if requests hang.

\* \*\*Sandbox vs Production\*\*: Ensure `base\_url` matches the environment.



\## 📚 Official Documentation Reference



This library is built on top of the official \[Bkash API documentation](https://developer.bka.sh/docs/product-overview).  

Please refer to it for detailed API behavior, limitations, and authentication guidelines.



Credit goes to the Bkash Developer Team for providing well-structured documentation.



\## License



This library is released under the \[MIT License](LICENSE).



