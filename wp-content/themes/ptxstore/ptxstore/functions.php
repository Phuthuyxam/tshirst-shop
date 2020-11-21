<?php
require_once ( get_template_directory().'/inc/init.php');

function aa() {
    global $wooextension;
    echo "<pre>";
    print_r($wooextension->getAllProductTerm('ptx_product_type'));
    echo "</pre>";
}
