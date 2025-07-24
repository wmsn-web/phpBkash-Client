<?php
namespace WmsnWeb\BkashPhpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BkashPhpClient
{
    protected array $credential;
    protected Client $http;

    public function __construct(array $credential, ?Client $http = null)
    {
        if (empty($credential)) {
            throw new BkashException("You must provide Credentials");
        }
        $this->credential = $credential;
        $this->http = $http ?? new Client([
            'base_uri' => $credential['base_url'],
            'timeout'  => $credential['timeout'] ?? 30,
            'verify' => false,
        ]);
    }

    protected function request(string $uri, array $headers, array $json): array
    {
        try {
            $response = $this->http->post($uri, [
                'headers' => $headers,
                'json'    => $json,
            ]);
        } catch (GuzzleException $e) {
            throw new BkashException("HTTP error on {$uri}: " . $e->getMessage(), $e->getCode(), $e);
        }

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BkashException("Invalid JSON response on {$uri}: " . json_last_error_msg());
        }

        return $data;
    }

    public function grantToken(): array
    {
        $creds = $this->credential;
        $json = [
            'app_key'    => $creds['app_key'],
            'app_secret' => $creds['app_secret'],
        ];
        $headers = [
            'Content-Type' => 'application/json',
            'username'     => $creds['username'],
            'password'     => $creds['password'],
        ];
        $data = $this->request('checkout/token/grant', $headers, $json);

        $now = time();
        return [
            'ap_type'       => $creds['type']             ?? '',
            'token_type'    => $data['token_type']        ?? '',
            'id_token'      => $data['id_token']          ?? '',
            'refresh_token' => $data['refresh_token']     ?? '',
            'expires'       => $data['expires_in']        ?? 0,
            'token_time'    => $now,
            'refresh_time'  => $now,
        ];
    }

    public function refreshToken(string $refToken): array
    {
        $creds = $this->credential;
        $json = [
            'app_key'       => $creds['app_key'],
            'app_secret'    => $creds['app_secret'],
            'refresh_token' => $refToken,
        ];
        $headers = [
            'Content-Type' => 'application/json',
            'username'     => $creds['username'],
            'password'     => $creds['password'],
        ];
        $data = $this->request('checkout/token/refresh', $headers, $json);

        $now = time();
        return [
            'ap_type'       => $creds['type']          ?? '',
            'token_type'    => $data['token_type']     ?? '',
            'id_token'      => $data['id_token']       ?? '',
            'refresh_token' => $data['refresh_token']  ?? '',
            'expires'       => $data['expires_in']     ?? 0,
            'token_time'    => $now,
            'refresh_time'  => $now,
        ];
    }

    public function createPayment(string $token, array $postArray): array
    {
        $creds = $this->credential;
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization'=> $token,
            'X-APP-Key'    => $creds['app_key'],
        ];
        return $this->request('checkout/create', $headers, $postArray);
    }

    public function executePayment(string $token, string $paymentID): array
    {
        $creds = $this->credential;
        $json = ['paymentID' => $paymentID];
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization'=> $token,
            'X-APP-Key'    => $creds['app_key'],
        ];
        return $this->request('checkout/execute', $headers, $json);
    }

    public function paymentStatus(string $token, string $paymentID): array
    {
        $creds = $this->credential;
        $json = ['paymentID' => $paymentID];
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization'=> $token,
            'X-APP-Key'    => $creds['app_key'],
        ];
        return $this->request('checkout/payment/status', $headers, $json);
    }
}
