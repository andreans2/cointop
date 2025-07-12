
<?php


require_once APP_PATH . '/src/Request.php';

class Fetcher
{
    private string $apiKey;
    private string $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?start=1&convert=USD&sort=price&sort_dir=desc&limit=50';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function fetch(): array
    {
        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: ' . $this->apiKey,
        ];

        $response = Request::get($this->url, $headers);

        $data = json_decode($response, true);

        if (!isset($data['data'])) {
            throw new \Exception('Invalid API response');
        }

        return $data['data'];
    }
}
