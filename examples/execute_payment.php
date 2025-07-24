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

if (isset($_GET['status'])){
	if ($_GET['status'] == 'success'){
		//Execute and Success Logic
		$response = $bkash->executePayment($token, $_GET['paymentID']);
		echo "<pre>";
		print_r($response);
		//Example Output
		/*
		Array
		(
		    [paymentID] => TR0011gfMBThn1751047754935
		    [trxID] => CFS70N1FNF
		    [transactionStatus] => Completed
		    [amount] => 100
		    [currency] => BDT
		    [intent] => sale
		    [paymentExecuteTime] => 2025-06-28T00:16:56:985 GMT+0600
		    [merchantInvoiceNumber] => Inv790446684
		    [payerType] => Customer
		    [payerReference] => 11
		    [customerMsisdn] => 01770618575
		    [payerAccount] => 01770618575
		    [maxRefundableAmount] => 100
		    [statusCode] => 0000
		    [statusMessage] => Successful
		)
		*/
	}
	else
	{
		//Failed logic
	}
}

