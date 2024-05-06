<?php 

    include 'admin/connect.php';

    // routs
    $tpl = 'includes/templates/'; // templat directory
    $lang = 'includes/languages/'; // languages dir
    $func = 'includes/functions/'; // functions dir
    $css = 'layout/css/'; // css dir
    $js = 'layout/js/'; // js dir
    

    // include the important files

    include $func . 'functions.php';
    include $lang . 'eng.php';
    include $tpl . 'header.php';