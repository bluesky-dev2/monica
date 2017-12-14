# Update your Monica instance

Monica uses the concept of releases and tries to follow
[Semantic Versioning](http://semver.org/) as much as possible. If you run the project locally,
or if you have installed Monica on your own server, you need to follow these
steps below to update it, **every single time**, or you will run into problems.

1. Always make a backup of your data before upgrading.
1. Check that your backup is valid.
1. Read the [release notes](https://github.com/monicahq/monica/blob/master/CHANGELOG)
to check for breaking changes.
1. Then, run the following command at the root of the project:

```
git pull origin master
composer install --no-interaction --prefer-dist --optimize-autoloader
php artisan migrate --force
```

Your instance should be updated.

## Importing vCards (CLI only)

**Note**: this is only possible if you install Monica on your server or locally.

You can import your contacts in vCard format in your account with one simple
CLI command:
`php artisan import:vcard {email user} {filename}.vcf`

where `{email user}` is the email of the user in your Monica instance who will
be associated the new contacts to, and `{filename}` being the name of your .vcf file.
The .vcf file has to be in the root of your Monica installation (in the same directory
where the artisan file is).

Example: `php artisan import:vcard john@doe.com contacts.vcf`

The `.vcf` can contain as many contacts as you want.

## Importing SQL from the exporter feature

Monica allows you to export your data in SQL, under the Settings panel. When you
export your data in SQL, you'll get a file called `monica.sql`.

To import it into your own instance, you need to make sure that the database of
your instance is completely empty (no tables, no data).

Then, follow the steps:

* `php artisan migrate`
* `php artisan db:seed --class ActivityTypesTableSeeder`
* `php artisan db:seed --class CountriesSeederTable`
* Then import `monica.sql` into your database. Tools like phpmyadmin or Sequel
Pro might help you with that.
* Finally, sign in with the same credentials as the ones used on
https://monicahq.com and you are good to go.

There is one caveat with the SQL exporter: you can't get the photos you've
uploaded for now.
