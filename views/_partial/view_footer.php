<?php
use cronnos\printers\Printer;

$p = new Printer();
?>

<script>
    <?php
    $p->view('/js/app.js', [], false);
    $p->view('/js/js_fb_sdk.php', [], false);
    ?>
</script>

<script type="text/jsx">
    <?php
    $p->view('/js/jsx_app.js', [], false);
    $p->view('/js/jsx_pixcraw.js', [], false);
    ?>
</script>
