<?php

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
  ** Title Function v1.0
  ** Title Function That Echo The Page Title In Case The Page
  ** Has The Variable $pageTitle And Echo Default Title For Other Pages
  */
  function getTitle() {
    global $pageTitle;
    if (isset($pageTitle)) { echo $pageTitle; }
    else { echo "Default"; }

  }

