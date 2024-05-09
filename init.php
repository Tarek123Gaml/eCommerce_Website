<?php 

    // Error reporting

    ini_set('display_errors', 'on');
    error_reporting(E_ALL);

    include 'admin/connect.php';

    $sessionUser = '';
    if(isset($_SESSION['user'])){
        $sessionUser = $_SESSION['user'];
    }

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