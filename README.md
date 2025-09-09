# 🧩 Design Pattern: Singleton in Laravel

این پروژه یک مثال ساده از **الگوی طراحی Singleton** در فریمورک لاراول است.  
هدف این است که نشان دهیم چطور می‌توانیم مطمئن شویم فقط **یک نمونه (Instance)** از یک کلاس ساخته می‌شود و همه جا از همان نمونه استفاده می‌کنیم.

---

## 📖 توضیح الگو
الگوی **Singleton** تضمین می‌کند که:
1. فقط یک نمونه از کلاس ساخته شود.
2. همه قسمت‌های برنامه از همان نمونه استفاده کنند.
3. جلوی ساخت نمونه‌های جدید یا کپی شدن کلاس گرفته شود.

در لاراول، برای مثال می‌توان از Singleton برای:
- **مدیریت تنظیمات سایت (Site Config)**
- **Logger ها**
- **Cache Manager**
- یا هر جایی که باید یک نمونه واحد داشته باشیم استفاده کرد.

---

## 🛠️ پیاده‌سازی

### 1. کلاس Singleton

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


### 2. استفاده در کنترلر

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


### 3. تعریف Route
`routes/web.php`

```php
use App\Http\Controllers\HomeController;

Route::get('/test-singleton', [HomeController::class, 'index']);
```


### حالا با اجرای آدرس زیر در مرورگر:
`http://localhost:8000/test-singleton`



### خروجی زیر را دریافت می‌کنید:
```php
{
    "site_name": "My Laravel App",
    "maintenance": false
}
```


###  4. تست واحد (Feature Test)

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

###  اجرای تست:
`php artisan test --filter=SingletonTest`


<div dir="rtl">

###  ✅ نکات کلیدی
- با private __construct() مانع ساخت مستقیم شیء جدید می‌شویم.
- با private __clone() مانع کپی کردن آبجکت می‌شویم.
- با static getInstance() همیشه یک نمونه ثابت داریم.
- در لاراول می‌توان همین مفهوم را با Service Container و متد app()->singleton() هم پیاده‌سازی کرد.
</div>
