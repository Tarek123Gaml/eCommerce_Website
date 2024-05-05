<?php

    function lang($phrase) {

        static $lang = array(

            // dashboard phrases

            'Home'          => 'Home',
            'Categories'    => 'Categories',
            'Items'         => 'Items',
            'Members'       => 'Members',
            'Comments'      => 'Comments',
            'Statistics'    => 'Statistics',
            'Logs'          => 'Logs'
        );

        return $lang[$phrase];
    
    };