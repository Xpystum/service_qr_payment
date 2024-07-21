
#GIT
```
    git branch -r | grep -v '\->' | while read remote; do git branch --track "${remote#origin/}" "$remote"; done
    git fetch --all
    git pull --all
    git@github.com:Xpystum/PaymentServiceTest.git

```

#Установка Приложения
```
    .env.example .env
    php artisan key:generate
    php artisan jwt:secret
    php artisan migrate

    // установить всё можно одной командой: php artisan install:application
    php artisan notification-method:install
    php artisan currencies:install - установка валют
    php artisan payments:install - установка платежных методов (Банки, платежные агрегаты и т.д)
    php artisan add:ykassa - установка конфигурационных данных юкассы (добавление в бд)
    
```

#COMMADN
```

php artisan users:create - создание user

```
