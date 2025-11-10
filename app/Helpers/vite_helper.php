<?php
// app/Helpers/vite_helper.php

if (!function_exists('vite_asset')) {
    function vite_asset(string $entry, array $args = []): string
    {
        // Check if the Vite development server is running
        if (ENVIRONMENT === 'development' && file_get_contents('http://localhost:5173/')) { // Adjust port if necessary
            // Serve assets from the Vite dev server
            $html = '<script type="module" src="http://localhost:5173/@vite/client"></script>' . PHP_EOL;
            $html .= '<script type="module" src="http://localhost:5173/' . $entry . '"></script>' . PHP_EOL;
            return $html;
        }

        // Serve production assets from the manifest file
        static $manifest = null;
        if ($manifest === null) {
            // Load the manifest file (adjust path as needed, e.g., public/dist/.vite/manifest.json)
            $manifestPath = FCPATH . 'dist/.vite/manifest.json';
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
            } else {
                return ''; // Or handle the error as appropriate
            }
        }

        if (!isset($manifest[$entry])) {
            return ''; // Entry point not found in manifest
        }

        $file = $manifest[$entry]['file'];
        $html = '';

        // Add CSS files if they exist
        if (isset($manifest[$entry]['css'])) {
            foreach ($manifest[$entry]['css'] as $cssFile) {
                $html .= '<link rel="stylesheet" href="' . base_url("dist/assets/{$cssFile}") . '">' . PHP_EOL;
            }
        }

        // Add the main JS file
        $html .= '<script type="module" src="' . base_url("dist/assets/{$file}") . '"></script>' . PHP_EOL;

        return $html;
    }
}
