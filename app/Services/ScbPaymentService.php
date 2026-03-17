<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Exception;

class ScbPaymentService
{
    private $apiKey;
    private $apiSecret;
    private $baseUrl;
    private $billerId; 

    public function __construct()
    {
        $this->apiKey = env('SCB_API_KEY');
        $this->apiSecret = env('SCB_API_SECRET');
        $this->billerId = env('SCB_BILLER_ID');
        // Sandbox: https://api-sandbox.partners.scb/partners/sandbox
        // Production: https://api.partners.scb/partners
        $this->baseUrl = env('SCB_API_URL', 'https://api-sandbox.partners.scb/partners/sandbox');
    }

    // 1. ขอ Access Token 
    public function getAccessToken()
    {
        if (Cache::has('scb_access_token')) {
            return Cache::get('scb_access_token');
        }

        $headers = [
            'Content-Type' => 'application/json',
            'resourceOwnerId' => $this->apiKey, 
            'requestUId' => (string) Str::uuid(), 
            'accept-language' => 'EN',
        ];

        $response = Http::withHeaders($headers)->post($this->baseUrl . '/v1/oauth/token', [
            'applicationKey' => $this->apiKey,
            'applicationSecret' => $this->apiSecret
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $token = $data['data']['accessToken'];
            Cache::put('scb_access_token', $token, now()->addSeconds($data['data']['expiresIn'] - 60));
            return $token;
        }

        throw new Exception('SCB Auth Failed: ' . $response->body());
    }

    // 2. สร้าง QR Code
    public function generateQr($amount, $ref1, $ref2 = null)
    {
        $token = $this->getAccessToken();

        $cleanRef1 = preg_replace('/[^a-zA-Z0-9]/', '', $ref1);
        $cleanRef1 = strtoupper(substr($cleanRef1, 0, 20));

        $cleanRef2 = 'AUTOGO';

        $headers = [
            'Content-Type' => 'application/json',
            'resourceOwnerId' => $this->apiKey,
            'requestUId' => (string) Str::uuid(),
            'accept-language' => 'EN',
            'Authorization' => 'Bearer ' . $token 
        ];

        $response = Http::withHeaders($headers)->post($this->baseUrl . '/v1/payment/qrcode/create', [
            'qrType' => 'PP',
            'ppType' => 'BILLERID',
            'ppId' => $this->billerId,
            'amount' => (string) number_format($amount, 2, '.', ''),
            'ref1' => $cleanRef1, 
            'ref2' => $cleanRef2, 
            'ref3' => 'SCB',
        ]);

        if ($response->successful()) {
            return $response->json()['data']['qrImage'];
        }

        throw new Exception('Generate QR Failed: ' . $response->body());
    }
}