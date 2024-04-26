<?php

    function lang($phrase) {

        static $lang = array(

            // dashboard phrases

            'Home'          => 'Admin',
            'Categories'    => 'Categories',
            'Items'         => 'Items',
            'Members'       => 'Members',
            'Statistics'    => 'Statistics',
            'Logs'          => 'Logs'
        );

        return $lang[$phrase];
    
    };