<?php
use cronnos\printers\Printer;

if (!empty($_SESSION['params']))
    $params = $_SESSION['params'];
?>

<html>

<head>
    <title>DEV</title>
</head>

<body>
    <h1>DEVHello World!</h1>
    <a href="" onclick="shareBtn()">
        SHARE FB
    </a>
</body>

<?php
$p = new Printer();
$p->view('/js/js_fb_sdk.php', [], false);
?>

</html>


