<?php


    /*
    ** getTitle function V1.0 
    ** echo the page tilte in case the page has variable $pageTitle 
    ** and echo default title in other page
    */

    function getTitle() {

        global $pageTitle; 

        if (isset($pageTitle)) {

            echo $pageTitle;

        } else {

            echo 'Default'; 

        }

    }


    /* 
    ** Home Redirect FunctionV2.0 
    ** (this accept tow parameters)
    ** $Massege = echo the massege [error, success warning]
    ** $url = the link you want redirect to
    ** $seconds = seconds befor redirect
    */

    function redirctHome ($Massege, $url = NULL, $seconds = 3) {

        if ($url === NULL){
            $url = 'index.php';
            $link = "Home Page";
        } else {
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
                $url = $_SERVER['HTTP_REFERER'];
                $link = "Previous Page";
            } else {
                $url = 'index.php';
                $link = 'Home Page';
            }
        }

        echo $Massege ;
        echo "<div class='alert alert-info'>You will redirect to $link after $seconds seconds.</div>";
        header("refresh:$seconds;url=$url");
        exit();
    }


    /*
    ** checkItem function V1.0 
    ** check item in database [accept parameters]
    ** $select : the item to select [examlpe : id , name, categories]
    ** $from : the table to select from
    ** $value : the value of select 
    */

    function checkItem ($select, $from, $value){

        global $con;

        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

        $statement->execute(array($value));

        $count = $statement->rowCount();

        return $count;
    }


    /*
    ** countItem function V1.0
    ** Function to count number of items rows
    ** $item = the item to count
    ** $table = the table choose from
    */

    function countItem ($item, $table){
        
        global $con;

        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
  
        $stmt2->execute();
        return $stmt2->fetchColumn();
    }

    /*
    ** getLastest function V1.0 
    ** function to get lastest items from database
    ** $select = item well be selected
    ** $table = table select from
    ** $order = item sel
    ** $limit
    */

    function getLastest ($select, $table, $order, $limit = 5){

        global $con;

        $gstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

        $gstmt->execute();

        return $gstmt->fetchAll();
    }

