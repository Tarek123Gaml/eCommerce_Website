<?php

    /*
        Categeries = [ Manage | Edite | Update | Add | Insert | Delete | States ]
    */

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if ( $do == 'Manage') {
        echo 'Welcome you are in catagery page';
        echo '<a href="?do=Add">Add new catagery +</a>';
    } elseif ($do == 'Add') {
        echo 'Welcome you are in Add page';
    } elseif ($do == 'Insert') {
        echo 'Welcome you are in Insert page';
    } else {
        echo 'Error there\'s no page with thise name';
    }