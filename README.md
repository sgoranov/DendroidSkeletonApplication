# Dendroid Skeleton Application

Skeleton application representing Dendroid framework

## Database Setup 

You can use the following to setup the database and the user:

```mysql
CREATE DATABASE dendroid;
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES ON dendroid.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
```

Please set different username and secret and do not use the defaults.

Import the database schema:

```bash
mysql -u admin -p < schema.sql
```

## Install and minify assets

Run npm install to install gulp, bower and their dependencies:

```bash
npm install
```

Install bootstrap and jquery using bower:

```bash
node_modules/bower/bin/bower install bootstrap
node_modules/bower/bin/bower install jquery
```

Run gulp to install and minify the assets:

```bash
node_modules/gulp/bin/gulp.js
```

## Install PHP dependencies

Execute the following to install PHP dependencies via Composer:

```bash
compser install
```

## Start the app using the built-in web server

To start the built-in web server execute the following command from project's directory:

```bash
php -S localhost:5001 -t web/
```
