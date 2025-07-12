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
                    ':percent_change_24h' => $crypto['change_24h'],
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