
# *Symfony Quotes Project*

## Windows explorer

- #### Create `symfony_quotes` project folder in your personnal Kali directory

- #### Copy `Dockerfile` and `docker-compose.yml` files to `symfo_quotes` folder

## Kali terminal (In `symfony_quotes` folder)

#### Create Symfony image
```sh
docker build -t "symfo_php:8.2-fpm-alpine" ./
```

#### Create Symfony compose
```sh
docker-compose up -d
```

#### Open Symfony container terminal
```sh
docker exec -it symfo_php-fpm /bin/bash
```

## Symfony container terminal (In `/var/www/html` folder)

#### Check requirements
```sh
symfony check:requirements
```

#### Create new symfony project
```sh
symfony new .
```

#### Install development dependencies
```sh
composer req --dev maker ormfixtures fakerphp/faker
```

#### Install dependencies
```sh
composer req doctrine twig
```

#### Create & config local environment file
```sh
cp .env .env.local
```

#### Exit Symfony container terminal
```sh
exit
```

## Kali terminal (In `symfo_quotes` folder)

#### Change `app` folder owner
```sh
sudo chown -R <user>:<group> app
```

#### Open `symfo_quotes/app/.env.local` file with VSCode and mofify `DATABASE_URL` environment variable with the following line
```
DATABASE_URL="mysql://symfo_db:sfpw@mysql_host:3306/symfo_db?serverVersion=8.0&charset=utf8mb4"
```

#### Open Symfony container terminal
```sh
docker exec -it symfo_php-fpm /bin/bash
```

## Symfony container terminal (In `/var/www/html` folder)

#### Start Symfony project
```sh
symfony serve -d --allow-all-ip
```
## Clik [here](http://localhost:8000/) to check if the Symfony demo app works
The symfony demo app page should look like this :
![capture](SymfonyDemoAppScreenshot.png)

## Continue the [tutorial](https://www.twilio.com/blog/get-started-docker-symfony) starting at the `Create the quote entity` chapter
