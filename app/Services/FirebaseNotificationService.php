<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseNotificationService
{
    protected string $projectId = 'ier-notif';
    protected string $serviceAccountPath = 'app/firebase/firebase.json';

    protected function getAccessToken(): string
    {
        $json = json_decode(
            file_get_contents(storage_path($this->serviceAccountPath)),
            true
        );

        $now = time();

        $payload = [
            'iss'   => $json['client_email'],
            'sub'   => $json['client_email'],
            'aud'   => 'https://oauth2.googleapis.com/token',
            'iat'   => $now,
            'exp'   => $now + 3600,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging'
        ];

        $base64Header = rtrim(strtr(base64_encode(json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT'
        ])), '+/', '-_'), '=');

        $base64Payload = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');

        openssl_sign(
            $base64Header . '.' . $base64Payload,
            $signature,
            $json['private_key'],
            'sha256'
        );

        $jwt = $base64Header . '.' . $base64Payload . '.' .
            rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        $response = Http::asForm()->post(
            'https://oauth2.googleapis.com/token',
            [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion'  => $jwt
            ]
        );

        return $response['access_token'];
    }

    public function send(string $token, string $title, string $body): void
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)->post(
            "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send",
            [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                    'webpush' => [
                        'headers' => [
                            'Urgency' => 'high'
                        ]
                    ]
                ]
            ]
        );
        \Log::info('FCM STATUS', ['status' => $response->status()]);
        \Log::info('FCM BODY', $response->json());
    }
}
