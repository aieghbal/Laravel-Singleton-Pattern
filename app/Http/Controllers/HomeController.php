<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
