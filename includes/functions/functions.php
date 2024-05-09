<?php


    /*
    ** getAll function V1.0 
    ** function to get  All Records from database
    */

    function getAll ($all, $order){

      global $con;

      $getAlll = $con->prepare("SELECT * FROM $all ORDER BY $order DESC");

      $getAlll->execute();

      return $getAlll->fetchAll();
  }

    /*
    ** getCat function V1.0 
    ** function to get  Categories from database
    */

    function getCat (){

        global $con;

        $gstmt = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

        $gstmt->execute();

        return $gstmt->fetchAll();
    }


    /*
    ** getItem function V2.0 
    ** function to get  Items from database
    ** $where = column we need select 
    ** $value = name of the column
    ** $Approve = status of item 
    */

    function getItem ($where, $value, $Approve = NULL){

      global $con;

      $sql = $Approve == NULL ? 'AND Approve = 1' : '';

      $gstmt = $con->prepare("SELECT * FROM items WHERE $where = $value $sql ORDER BY Item_ID DESC");

      $gstmt->execute();

      return $gstmt->fetchAll();
  }



  /*
  ** checkUserStatus function V1.0
  ** check if the user status is active or no
  ** $user = the username need check
  */
  function checkUserStatus($user){

        global $con;

        // check if user exist in databade
        $stmt = $con->prepare(" SELECT Username, RegStatus FROM users WHERE Username = ? AND RegStatus = 0");

        $stmt->execute(array($user));
        
        return $stmt->rowCount();
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
  ** Title Function v1.0
  ** Title Function That Echo The Page Title In Case The Page
  ** Has The Variable $pageTitle And Echo Default Title For Other Pages
  */
  function getTitle() {
    global $pageTitle;
    if (isset($pageTitle)) { echo $pageTitle; }
    else { echo "Default"; }

  }

