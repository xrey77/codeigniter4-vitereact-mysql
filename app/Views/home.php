<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BARCLAYS BANK</title>
</head>
<body>
    <div id="root"></div>
    <?php if (ENVIRONMENT === 'development'): ?>
        <script type="module" src="http://localhost:5173/@vite/client"></script>
        <script type="module" src="http://localhost:5173/main.jsx"></script>
    <?php else: ?>
        <?php
        echo script_tag('dist/assets/index-CGHwRaT6.js');        
        echo link_tag('dist/assets/index-BOl7Hag9.css');
        ?>
    <?php endif; ?>

</body>
</html>
