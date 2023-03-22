# Task Scheduler
### Installation
   
   $ `composer install`

create `confing/db.php` file with database credentials like this
```php
<?php
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=task',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ];
```

   $ `php yii migrate`
   
### Usage
#### Add task
$ `php yii task/add "ExecMinus" "2022-01-12 22:03:12" "{\"a\": 1, \"b\":2}"`

or

$ `php yii task/add "ExecMinus" "2022-01-12 22:03:12" "{\"a\": 1, \"b\":2}"`

### Exec task
$ `php yii task/exec`
