<?php


namespace tests\Feature;

use App\Services\SiteConfig;
use Tests\TestCase;

class SingletonTest extends TestCase
{
    public function test_singleton_returns_same_instance()
    {
        $first = SiteConfig::getInstance();
        $second = SiteConfig::getInstance();

        $this->assertSame($first, $second); // دقیقا همون آبجکت
    }
}
