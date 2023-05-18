Run MySQL in Docker
```bash
docker run --name tgo-mysql -p3306:3306 -e MYSQL_ROOT_PASSWORD=my-secret-pw -d mysql --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci
```
Start dev server
```bash
symfony server:start
```

Deal with entity
```bash
php bin/console make:entity

php bin/console make:migration

php bin/console doctrine:migrations:migrate
```

Code style fixer
```bash
./vendor/bin/php-cs-fixer fix src
```

Static Analyzer
```bash
./vendor/bin/phpstan analyse src
```

Run simple "sender" 
```bash
php bin/console app:send-notifications
```

Test scaffolding:
```bash
php bin/console make:test
```

Url to generate dummy notification
http://127.0.0.1:8000/notification


Initialize test database
```bash
php bin/console --env=test doctrine:database:create

php bin/console --env=test doctrine:schema:create
```
