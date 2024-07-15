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

$a = "这是use数据";

echo "主线程：开始\n";

$Thread->arr([
    function () { // 部署111
        echo "111开始 " . date("H:i:s") . "\n";
        sleep(3);
        echo "111结束 " . date("H:i:s") . "\n";

        // 失败-不能嵌套线程
        // $t = new Thread();
        /* $Thread->threads_arr([
            function () {
                echo "111->001 " . date("H:i:s") . "\n";
            },
            function () {
                echo "111->001 " . date("H:i:s") . "\n";
            }
        ]); */

    }, function () { // 部署222
        echo "222开始 " . date("H:i:s") . "\n";
        sleep(5);
        echo "222结束 " . date("H:i:s") . "\n";
    }, function () use ($a) { // 部署333
        echo "333开始 " . date("H:i:s") . "\n";
        sleep(1);
        echo "333结束 " . date("H:i:s") . "\n";
        echo "333->" . $a . "\n";
    }
]);

echo "主线程：结束\n";
```

```
主线程：开始
111开始 03:46:07
222开始 03:46:07
333开始 03:46:07
333结束 03:46:08
333->这是use数据
111结束 03:46:10
222结束 03:46:12
主线程：结束
```

## Hint

You cannot nest threads