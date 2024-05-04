
#GIT
```git branch -r | grep -v '\->' | while read remote; do git branch --track "${remote#origin/}" "$remote"; done
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
```

#COMMADN
```

php artisan users:create - создание user

```
