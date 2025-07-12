<?php


return [
    '/' => function() {
        $db = new Database();
        $repo = new CryptoRepository($db->getConnection());
        $cryptos = $repo->getCoins();

        if (empty($cryptos)) {
            $cryptos = $repo->fetchAndSaveFromApi('107db198-d862-456f-aec0-0bce15d783e9');
        }

        include_once APP_PATH . "/templates/pages/index.php";
    },
    '/fetch' => function () {
        $db = new Database();
        $repo = new CryptoRepository($db->getConnection());

        $repo->fetchAndSaveFromApi('107db198-d862-456f-aec0-0bce15d783e9');

        echo "Данные обновлены.";
    }
];