# CoinTop — топ капиталоемких криптовалют

Это мини-приложение на PHP, показывающее топ-50 криптовалют с сайта CoinMarketCap.

## Структура проекта

- `src/` — бизнес-логика и работа с БД
- `config/` — конфигурация и роуты
- `templates/` — шаблоны страниц
- `index.php` — точка входа

## Старт

Проект использует [Lando](https://docs.lando.dev/) — среду разработки на базе Docker.


### Требования
- [Docker](https://www.docker.com/)
- [Lando](https://docs.lando.dev/basics/installation.html)

### Установка

### Lando

1. Перейдите на https://docs.lando.dev/install/windows.html
2. Скачайте и установите версию для вашей ОС
3. После установки перезапустите терминал
4. Проверьте установку командой `lando version`


```bash
git clone https://github.com/andreans2/cointop.git

cd cointop

lando start
````

После запуска приложение будет доступно по адресу:
https://cointop.lndo.site

PHPMyAdmin доступен по адресу:
https://phpmyadmin.cointop.lndo.site
(логин/пароль по умолчанию — lamp / lamp)

Для обновления данных из CoinMarketCap рекомендую установить выполнение задания по расписанию
```bash
crontab -e
```

````
*/5 * * * * curl 'https://cointop.lndo.site/fetch' 
````