<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Barclays Bank</title>
            <!-- 'href'  => 'dist/assets/main-BOl7Hag9.css', -->
    <?php
        // $link = [
        //     'href'  => 'dist/assets/main.css',
        //     'rel'   => 'stylesheet',
        //     'type'  => 'text/css',
        //     'media' => 'print',
        // ];
        // echo link_tag($link);
            // echo vite_asset('dist/assets/main-BOl7Hag9.css', 'css');
        ?>
            <?= vite_css() ?>
</head>
<body>

    <div id="root"></div> <!-- The React app mounts here -->
    <!-- 'src'    => 'dist/assets/main-BthDccb0.js', -->
    <?= vite_js() ?> 
<?php
        // $script = [
        //     'src'    => 'dist/assets/main.js',
        //     'defer'  => null, 
        //     'type'   => 'text/javascript'
        // ];
        // echo vite_asset('dist/assets/main-BthDccb0.js', 'js');
        // echo script_tag($script);
        ?>
</body>
</html>
