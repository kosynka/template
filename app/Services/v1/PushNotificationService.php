<?php

namespace App\Services\v1;

use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class PushNotificationService extends BaseService
{
    private $apiKey;

    public function __construct() {
        $this->apiKey = config('push-notification.api_key');
    }

    public function sendNotification($tokens, $title, $body, $payload = []): bool
    {
        Log::info(__METHOD__ . ' title:' . $title . ', body:' . $body .', payload: '. json_encode($payload));

        $data = $this->getData($tokens, $title, $body, $payload);
        $headers = [
            "Authorization: key=" . $this->apiKey,
            'Content-Type: application/json',
        ];

        $response = $this->send($data, $headers);
        if (json_decode($response) != null) {
            return true;
        }

        return false;
    }

    protected function getData($tokens, $title, $body, $payload)
    {
        $data = [
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
        ];
        if (count($payload)) {
            $data['data'] = $payload;
        }
        if (is_array($tokens)) {
            $data['registration_ids'] = $tokens;
            Log::info(__METHOD__ . ' ' . count($tokens) . ' recepients');
        } else {
            $data['to'] = $tokens;
            Log::info(__METHOD__ . ' recepient: ' . $tokens);
        }

        return $data;
    }

    protected function send($data, $headers)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        Log::info(__METHOD__ . ' response:' . $response);

        if (curl_errno($ch)) {
            Log::error(__METHOD__ . ' curl_error:' . curl_error($ch));
        }
        curl_close($ch);

        return $response;
    }
}