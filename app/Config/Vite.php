<?php
// app/Config/Vite.php
declare(strict_types=1);

namespace Config;

use CodeIgniterVite\Config\Vite as ViteConfig;

class Vite extends ViteConfig
{
    public array $routesAssets = [
        [
            'routes' => ['*'], // Apply to all routes, or specify specific routes
            'assets' => ['styles/index.css', 'js/main.js'], // Your entry points in app/Resources
        ],
    ];
}
