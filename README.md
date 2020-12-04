# SOFE 2800 Final Project

## Database Config

Create a file called `php.ini` with the following:

```ini
[db_config]
ip = "server ip"
user = "username"
password = "password"
database = "database name"

```

`dbConnection.php` reads the ini file and connects to the database with those credentials