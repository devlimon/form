## Install

```
git clone https://github.com/devlimon/form.git
```

go to our directory
```
cd form
```
make the .env files with with given configurations by me
```
cp .env.example .env
```

generate key
```
php artisan key:generate
```

install vendors
```
composer install
```

configure mails,rapidapikeys in .env and make sure you have internet connection as we have some third party apis

run tests if everything is ok
```
php artisan test
```

start development server
```
php artisan serve
```

now browse [http://127.0.0.1:8000](http://127.0.0.1:8000).
