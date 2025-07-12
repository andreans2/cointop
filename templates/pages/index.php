<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Топ 50 капиталоемких криптовалют</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f8fa;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f1f3f5;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        .green {
            color: green;
        }

        .red {
            color: red;

    </style>
</head>
<body>

<h1>Топ 50 капиталоемких криптовалют</h1>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Тикер</th>
        <th>Цена</th>
        <th>Изм. 24ч</th>
        <th>Капитализация</th>
        <th>Объём торгов</th>
    </tr>
    </thead>
    <tbody>


    <?php foreach ($cryptos as $index => $crypto) {
        $rank = $index + 1;
        $symbol = htmlspecialchars($crypto['symbol']);
        $name = htmlspecialchars($crypto['name']);
        $price = number_format($crypto['price'], 2);
        $change24h = $crypto['percent_change_24h'];
        $changeClass = $change24h >= 0 ? 'green' : 'red';
        $marketCap = number_format($crypto['market_cap']);
        $volume24h = number_format($crypto['volume_24h']);
        ?>
        <tr>
            <td><?= $rank ?></td>
            <td><strong><?= $symbol ?></strong> <?= $name ?></td>
            <td>$<?= $price ?></td>
            <td class="<?= $changeClass ?>">
                <?= $change24h > 0 ? '+' : '' ?><?= $change24h ?>%
            </td>
            <td>$<?= $marketCap ?></td>
            <td>$<?= $volume24h ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>
