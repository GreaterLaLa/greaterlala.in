greaterlala.in
==============


## Requirements
- PHP 5.5
- MySQL

## Setup

### Install PHP packages
- install [composer](http://getcomposer.com). I recommend installing it [globally](https://getcomposer.org/doc/00-intro.md#globally)
- Use `composer update` in the base project directory to install all the packages

### App Settings

- copy `app/settings/base.SAMPLE.php` to copy `app/settings/base.php`
- If in development, symlink `app/app-settings.php` to `app/settings/development.php`. If production, symlink to `app/settings/production.php`
- Fill in correct settings. Make sure all the `FIX ME` values in `app/settings/base.php` are filled-in. You may need to override these in other environment settings files (like if dev and production have diff mysql db settings)

### Phinx Settings

- copy `app/phinx.SAMPLE.yml` to `app/phinx.yml`
- fill-in correct DB settings for all environments in `app/phinx.yml`

### DB Setup and Population

- use Phinx to run migrations from `app/` with:

  ```
  ../vendor/bin/phinx migrate
  ```

  It *should* create all the necessary tables in the DB
- from `app/scripts` run `php generate_fake_data.php`. This should create mock data in the database.

### Dev Server
- in the root project directory, there's a bash script to run the PHP dev server: `dev-server.sh`. Run this and then go to <http://0.0.0.0:9909> in a web browser and you should see the **suggestions submission page**
- go to <http://0.0.0.0:9909/present> to see the animating **suggestions presentation page**
- **NEVER USE THE DEV SERVER IN PRODUCTION**
