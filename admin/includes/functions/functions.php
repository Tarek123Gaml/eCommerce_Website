<?php

    function getTitle() {

        global $pageTitle; 

        if (isset($pageTitle)) {

            echo $pageTitle;

        } else {

            echo 'Default'; 

        }

    }


    /*
    ** Home Redirect Function (this accept tow parameters)
    ** $errorMassege = echo the error massege
    ** $seconds = seconds befor redirect
    */

    function redirctHome ($errorMassege, $seconds = 3) {

        echo "<div class='alert alert-danger'>$errorMassege</div>";
        echo "<div class='alert alert-info'>You will redirect to the Home Page after $seconds seconds.</div>";
        header("refresh:$seconds;url=index.php");
        exit();
    }