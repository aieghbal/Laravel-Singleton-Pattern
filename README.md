# 🧩 Design Pattern: Singleton in Laravel
This project is a simple example of the Singleton design pattern in the Laravel framework.
The goal is to show how we can ensure that only one instance of a class is created and that the same instance is used everywhere.

---

## 📖 Pattern Explanation
The Singleton pattern guarantees that:
1. Only one instance of the class is created.
2. All parts of the program use the same instance.
3. No new instances or copies of the class can be created.

In Laravel, Singletons can be useful for:
- **Site configuration management**
- **Loggers**
- **Cache Manager**
- Or anywhere a single instance is required.

---

## 🛠️ Implementation

### 1. Singleton Class

`app/Services/SiteConfig.php`

```php
<?php

namespace App\Services;

class SiteConfig
{
    private static $instance = null;

    public $settings = [];

    private function __construct()
    {
        $this->settings = [
            'site_name' => 'My Laravel App',
            'maintenance_mode' => false,
        ];
    }

    private function __clone() {}

    public static function getInstance(): SiteConfig
    {
        if (self::$instance === null) {
            self::$instance = new SiteConfig();
        }
        return self::$instance;
    }

    public function get($key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }
}
```


### 2. Using the Singleton in a Controller

`app/Http/Controllers/HomeController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Services\SiteConfig;

class HomeController extends Controller
{
    public function index()
    {
        $config = SiteConfig::getInstance();

        return response()->json([
            'site_name' => $config->get('site_name'),
            'maintenance' => $config->get('maintenance_mode'),
        ]);
    }
}
```


### 3. Define Route
`routes/web.php`

```php
use App\Http\Controllers\HomeController;

Route::get('/test-singleton', [HomeController::class, 'index']);
```


### Visit in Browser
`http://localhost:8000/test-singleton`



### Output
```php
{
    "site_name": "My Laravel App",
    "maintenance": false
}
```


###  4. Unit Test (Feature Test)

`tests/Feature/SingletonTest.php`

```php
<?php

namespace Tests\Feature;

use App\Services\SiteConfig;
use Tests\TestCase;

class SingletonTest extends TestCase
{
    public function test_singleton_returns_same_instance()
    {
        $first = SiteConfig::getInstance();
        $second = SiteConfig::getInstance();

        $this->assertSame($first, $second);
    }
}
```

###  Run the test:
`php artisan test --filter=SingletonTest`


<div dir="rtl">

###  ✅ Key Points
- Using private __construct() prevents direct instantiation.
- Using private __clone() prevents object cloning.
- Using static getInstance() ensures a single fixed instance.
- In Laravel, you can implement the same concept via the Service Container using app()->singleton().
</div>


[Persian version](./README.md)
