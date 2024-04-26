<?php 

    include 'connect.php';

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

    // include navbar in all pages expect on with var noNavbar

    if ( !isset ($noNavbar)) {include $tpl . 'navbar.php';}