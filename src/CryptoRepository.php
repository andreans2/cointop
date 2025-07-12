<?php


class CryptoRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCoins(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM cryptocurrencies ORDER BY market_cap DESC LIMIT 50");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function fetchAndSaveFromApi(string $apiKey): array
    {
        $fetcher = new Fetcher($apiKey);
        $raw = $fetcher->fetch();

        $cryptos = array_map(function ($coin) {
            return [
                'symbol' => $coin['symbol'],
                'name' => $coin['name'],
                'price' => $coin['quote']['USD']['price'],
                'percent_change_24h' => $coin['quote']['USD']['percent_change_24h'],
                'market_cap' => $coin['quote']['USD']['market_cap'],
                'volume_24h' => $coin['quote']['USD']['volume_24h'],
            ];
        }, $raw);

        $this->saveMany($cryptos);

        return $cryptos;
    }

    public function saveMany(array $cryptos): void
    {
        try {
            $this->pdo->beginTransaction();

            $this->pdo->exec("DELETE FROM cryptocurrencies");

            $stmt = $this->pdo->prepare("
                INSERT INTO cryptocurrencies 
                    (symbol, name, price, percent_change_24h, market_cap, volume_24h) 
                VALUES 
                    (:symbol, :name, :price, :percent_change_24h, :market_cap, :volume_24h)
            ");

            foreach ($cryptos as $crypto) {
                $stmt->execute([
                    ':symbol' => $crypto['symbol'],
                    ':name' => $crypto['name'],
                    ':price' => $crypto['price'],
                    ':percent_change_24h' => $crypto['percent_change_24h'],
                    ':market_cap' => $crypto['market_cap'],
                    ':volume_24h' => $crypto['volume_24h'],
                ]);
            }


            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            error_log("Ошибка при сохранении: " . $e->getMessage());
            throw $e;
        }
    }
}