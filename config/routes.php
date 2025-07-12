<?php


return [
    '/' => function() {
        $db = new Database();
        $repo = new CryptoRepository($db->getConnection());
        $cryptos = $repo->getCoins();
        include_once APP_PATH . "/templates/pages/index.php";
    },
    '/fetch' => function () {
        $fetcher = new Fetcher('107db198-d862-456f-aec0-0bce15d783e9');
        $raw = $fetcher->fetch();

        $cryptos = array_map(function ($coin) {
            return [
                'symbol' => $coin['symbol'],
                'name' => $coin['name'],
                'price' => $coin['quote']['USD']['price'],
                'change_24h' => $coin['quote']['USD']['percent_change_24h'],
                'market_cap' => $coin['quote']['USD']['market_cap'],
                'volume_24h' => $coin['quote']['USD']['volume_24h'],
            ];
        }, $raw);

        $db = new Database();
        $pdo = $db->getConnection();

        $repo = new CryptoRepository($pdo);
        $repo->saveMany($cryptos);

        echo "Данные обновлены.";
    }
];