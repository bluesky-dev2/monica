# Running it on Debian Stretch

#### 1. Install the required packages:

```
sudo apt install apache2 mariadb-server php7.0 php7.0-mysql php7.0-xml \
    php7.0-intl php7.0-mbstring git curl
```

#### 2. Clone the repository

You may install Monica by simply closing the repository. Consider cloning the repository into any folder, example here in `/var/www/monica` directory:
```sh
sudo git clone https://github.com/monicahq/monica.git /var/www/monica
```

You should check out a tagged version of Monica since `master` branch may not always be stable.
Find the latest official version on the [release page](https://github.com/monicahq/monica/releases)
```sh
cd /var/www/monica
# Clone the desired version
sudo git checkout tags/v1.6.2
```

#### 3. Change permissions on the new folder

```sh
sudo chown -R www-data:www-data /var/www/monica
```

#### 4. Install nodejs (this is needed for npm)

```sh
curl -sL https://deb.nodesource.com/setup_9.x | sudo -E bash -
sudo apt install -y nodejs
```

#### 5. Install composer

Download and install the binary by following the [Command-line installation of composer](https://getcomposer.org/download/).

Move it to the bin directory.
```sh
sudo mv composer.phar /usr/local/bin/composer
```

#### 6. Setup the database

First make the database a bit more secure.
```sh
sudo mysql_secure_installation
```

Next log in with the root account to configure the database.
```sh
sudo mysql -uroot -p
```

Create a database called 'monica'.
```sql
CREATE DATABASE monica;
```

Create a user called 'monica' and its password 'strongpassword'.
```sql
CREATE USER 'monica'@'localhost' IDENTIFIED BY 'strongpassword';
```

We have to authorize the new user on the `monica` db so that he is allowed to change the database.
```sql
GRANT ALL ON monica.* TO 'monica'@'localhost';
```

And finally we apply the changes and exit the database.
```sql
FLUSH PRIVILEGES;
exit
```

#### 7. Configure Monica

`cd /var/www/monica` then run these steps with `sudo`:

1. `cp .env.example .env` to create your own version of all the environment variables needed for the project to work.
1. Update `.env` to your specific needs. Don't forget to set `DB_USERNAME` and `DB_PASSWORD` with the settings used behind.
1. Run `composer install --no-interaction --prefer-dist --no-suggest --optimize-autoloader --no-dev --ignore-platform-reqs` to install all packages.
1. Run `npm install` to install all the front-end dependencies and tools needed to compile assets.
1. Run `npm run production` to compile js and css assets.
1. Run `php artisan key:generate` to generate an application key. This will set `APP_KEY` with the right value automatically.
1. Run `php artisan setup:production` to run the migrations, seed the database and symlink folders.
1. Optional: run `php artisan passport:install` to create the access tokens required for the API (Optional).

#### 8. Configure cron job

As recommended by the generic installation instructions we create a cronjob which runs `artisan schedule:run` every minute.

For this execute this command:
```sh
sudo crontab -e
```

And then add this line to the bottom of the window that opens.
```
* * * * * sudo -u www-data php /var/www/monica/artisan schedule:run
```

#### 9. Configure Apache webserver

We need to enable the rewrite module of the Apache webserver:
```sh
sudo a2enmod rewrite
```

Edit `/etc/apache2/sites-enabled/000-default.conf` file.

* Update `DocumentRoot` property to:
```
DocumentRoot /var/www/monica/public
```
* and add a new `Directory` directive:
```
<Directory /var/www/monica/public>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

Finally restart Apache.
```sh
sudo systemctl restart apache2
```

Monica will be up and running to `http://localhost`.
