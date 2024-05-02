<?php

    /*
    ===============================================================
    =========== Item Page
    ===============================================================
    */


    ob_start(); // output buferring start

    session_start();

    $pageTitle = '';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == "Manage") {

        } elseif ($do == 'Add') { // Add Page?>

            <h1 class='text-center'>Add New Item</h1>

            <div class='container'>
                <form class='form-horizontal' action='?do=Insert' method='POST'>
                    <!-- start name field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Name</label>
                        <div class='col-sm-10 col-md-4'>
                            <input type="text" name='name' class='form-control'
                            required='required' placeholder="Name Of The Item" >
                        </div>
                    </div>
                    <!-- end name field -->
                    <!-- start submit field -->
                    <div class='form-group'>
                        <div class='col-sm-offset-2 col-sm-10'>
                            <input type="submit" value='Add Item' class='btn btn-primary btn-sm' />
                        </div>
                    </div>
                    <!-- end submit field -->
                </form>
            </div>


        <?php
        } elseif ($do == "Insert") {

        } elseif ($do == "Edite") {

        } elseif ($do == "Update") {
            
        } elseif ($do == "Delete") {

        } elseif ($do == "Approve" ) {

        }

        include $tpl . 'footer.php' ;
    } else {
        header ('Location: index.php');

        exit();
    }

    ob_end_flush(); // release the output