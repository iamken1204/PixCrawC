<?php
use cronnos\printers\Printer;

$p = new Printer();
$p->view('/js/app.js', [], false);
$p->view('/js/js_fb_sdk.php', [], false);
?>
