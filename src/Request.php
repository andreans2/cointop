<?php


class Request
{
    public static function get(string $url, array $headers = []): string
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $response;
    }
}
