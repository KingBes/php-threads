# php-threads
php Thread composer package

|  PHP   | 8.1+  |
|  ----  | ----  |
|  FFI   | *     |

# composer

```shell
composer require kingbes/threads
```

## example

```php
require "./vendor/autoload.php";

use KingBes\thread\Thread;

$Thread = new Thread();

$Thread->emplace(function () {
    echo "111 start\n";
    sleep(10);
    echo "111 end\n";
});

$Thread->emplace(function () {
    echo "222 start\n";
    sleep(5);
    echo "222 end\n";
});

$Thread->start();
```

```
111 start
222 start
222 end
111 end
```