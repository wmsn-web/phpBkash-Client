<?php
require '../vendor/autoload.php';
use WmsnWeb\BkashPhpClient\BkashPhpClient;

$credentials = array(
	"base_url" => "https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/",
	"username" => "sandboxTokenizedUser02",
	"password" => "sandboxTokenizedUser02@12345",
	"app_key" => "4f6o0cjiki2rfm34kfdadl1eqq",
	"app_secret" => "2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b",
	"type"		=>"sandbox"
);
$bkash = new BkashPhpClient($credentials);
$token = "eyJraWQiOiJvTVJzNU9ZY0wrUnRXQ2o3ZEJtdlc5VDBEcytrckw5M1NzY0VqUzlERXVzPSIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiJlODNlMDkwMC1jY2ZmLTQzYTctODhiNy0wNjE5NDJkMTVmOTYiLCJhdWQiOiI2cDdhcWVzZmljZTAxazltNWdxZTJhMGlhaCIsImV2ZW50X2lkIjoiODYxYzkzNGMtNGYwNy00ZGJjLTljMDUtNjQyNGUyMjE3MGMxIiwidG9rZW5fdXNlIjoiaWQiLCJhdXRoX3RpbWUiOjE3NTEwNDcxODksImlzcyI6Imh0dHBzOlwvXC9jb2duaXRvLWlkcC5hcC1zb3V0aGVhc3QtMS5hbWF6b25hd3MuY29tXC9hcC1zb3V0aGVhc3QtMV9yYTNuUFkzSlMiLCJjb2duaXRvOnVzZXJuYW1lIjoic2FuZGJveFRva2VuaXplZFVzZXIwMiIsImV4cCI6MTc1MTA1MTAyOSwiaWF0IjoxNzUxMDQ3NDI5fQ.qI_HT2uzqAeUdxdeK48Bl8ZSGduiJ62dElc-OR4o9-vpexoReZggVLcheHKApL3ML42fhVLRXE8oBP2iyMpdKvzPlEW56aP--7bfxHJCmq-n0jcKNCfxQoGFnN1P9pUIZPBhz45uOzRkpjOrLVhGDSwRFepeTirNPikfTLPXpnO5ZgZLyevRdqnRfSVD-INCjRMwTCzppPfz6nM5QzrvaN-7PB2f_XtgIkofyMTKLVucwrl4E27Pj-IT33FSyZ3kvpgHlPcami0C837td2gVkMCSkJD_9tgjTe7A1yzajqJXsZ0sqrmpFMHmgAUHHaKcXRg1WCJ5Dg4jz_zLkXu2vA";


$paymentID = "TR0011gfMBThn1751047754935"; //from createPayment
$response = $bkash->paymentStatus($token, $paymentID);
echo "<pre>";
print_r($response);
		//Example Output
		/*
		Array
			(
			    [paymentID] => TR0011gfMBThn1751047754935
			    [trxID] => CFS70N1FNF
			    [mode] => 0011
			    [paymentCreateTime] => 2025-06-28T00:09:14:935 GMT+0600
			    [paymentExecuteTime] => 2025-06-28T00:16:56:985 GMT+0600
			    [amount] => 100.00
			    [currency] => BDT
			    [intent] => sale
			    [merchantInvoice] => Inv790446684
			    [transactionStatus] => Completed
			    [serviceFee] => 0.00
			    [maxRefundableAmount] => 100.00
			    [verificationStatus] => Complete
			    [payerReference] => 11
			    [payerType] => Customer
			    [statusCode] => 0000
			    [statusMessage] => Successful
			)
		*/
	


