# Warehouse Management App
A hack project in Yii2 for a warehouse management app

The app allows employees to create categories and products under those categories

### Tech

This solution is written using:

* [Yii2] - Yii2 PHP Framework!

### Usage

To run the project, first install [Composer]. Then run

```sh
$ composer install
```
This will install the necessary packages for the project.
Next, update the db configuration in config/db.php. Then run the migrate command
```sh
$ yii migrate
```
This will generate the the tables in the database.
Next, seed the database by running
```sh
$ yii seed
```
5 employees and 5 categories will be generated and saved into the database. The passwords of each of the employees is `123456`.
Launch the app and then login

License
----
MIT


   [Yii2]: <http://www.yiiframework.com/doc-2.0>
   [Composer]: <https://getcomposer.org/>