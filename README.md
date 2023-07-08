## Demo
[https://test.bebshay.com/form/public/form](https://test.bebshay.com/form/public/form)

## Install

```
git clone https://github.com/devlimon/form.git
```

go to our directory
```
cd form
```

clone the .env file from given exmaples configurations by me
```
cp .env.example .env
```

install vendors
```
composer install
```

generate key
```
php artisan key:generate
```

configure smtp, rapidapikeys in .env and make sure you have internet connection in your device as we have some third party apis. for now i have used demo credentials for easy check although its not a good practice. will remove those in later pushes.

run tests if everything is ok
```
php artisan test
```

start development server
```
php artisan serve
```

now browse [http://127.0.0.1:8000](http://127.0.0.1:8000)
