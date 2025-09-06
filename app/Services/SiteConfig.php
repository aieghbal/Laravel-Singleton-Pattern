<?php


namespace App\Services;

class SiteConfig
{
    private static $instance = null;

    public $settings = [];

    // جلوگیری از ساخت نمونه جدید از بیرون
    private function __construct()
    {
        // مثلا بخونیم از دیتابیس یا فایل
        $this->settings = [
            'site_name'        => 'My Laravel App',
            'maintenance_mode' => false,
        ];
    }

    // جلوگیری از کلون کردن
    private function __clone()
    {
    }

    // متد اصلی برای گرفتن نمونه
    public static function getInstance(): SiteConfig
    {
        if (self::$instance === null)
        {
            self::$instance = new SiteConfig();
        }

        return self::$instance;
    }

    // متد نمونه برای گرفتن تنظیمات
    public function get($key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }
}
