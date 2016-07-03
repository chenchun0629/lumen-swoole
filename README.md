# lumen-swoole

## Documention

1. copy `package_path\Config\swooleserver.php` to `project_path\config\swooleserver.php`
2. edit `public\app.php`

```
$app->loadComponent('swooleserver', [
        LumenSwoole\SwooleServiceProvide::class
    ], 'lumen.swoole')->server()->run();
```

3. run it

```
cd project_path/
php public/app.php
```
