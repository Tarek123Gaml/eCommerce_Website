<?php

    /*
    ===============================================================
    =========== Categories Page
    ===============================================================
    */


    session_start ();

    $pageTitle = 'Categories';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == "Manage") {

            $sort = 'ASC';

            if (isset($_GET['sort']) && $_GET['sort'] == 'DESC'){

                $sort = 'DESC';
            }

            $stmt3 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
            $stmt3->execute();
            $rows = $stmt3->fetchAll();
            
            if (! empty($rows)){
                ?>
                <h1 class="text-center">Manage Categories</h1>
                <div class="container categories">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-edit"></i> Manage Categories
                            <div class='option pull-right'><i class="fa fa-sort"></i> Ordering: [
                                <a class="<?php if($sort == 'ASC'){echo 'active';} ?>" href="?sort=ASC">  Asc </a>|
                                <a class="<?php if($sort == 'DESC'){echo 'active';} ?>" href="?sort=DESC"> Desc</a> ] 
                                <i class="fa fa-eye"></i> View: [
                                <span class='active' data-view='full'>Full </span>| 
                                <span> Classic</span> ]
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php
                            foreach($rows as $row){
                                echo "<div class='cat'>";
                                    echo"<div class='hidden-buttons'>";
                                        echo "<a href='categories.php?do=Edit&catid=". $row['ID'] ."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                        echo '<a href="categories.php?do=Delete&catid=' . $row['ID'] . '" class="confirm btn btn-xs btn-danger"><i class="fa fa-close"></i> Delete</a>';

                                    echo "</div>";
                                    echo '<h3>' . $row['Name'] . '</h3>';
                                    echo "<div class='full-view'>";
                                        echo '<p>'; if ($row['Description'] == '') {echo 'This category has no description';} else {echo $row['Description'];} echo '</p>';
                                        if ($row['Visibility'] == 1){ echo '<span class="visible"><i class="fa fa-eye"></i> Hidden</span>';}
                                        if ($row['Allow_Comment'] == 1){ echo '<span class="comment"><i class="fa fa-close"></i> Comment Disabled</span>';}
                                        if ($row['Allow_Ads'] == 1){ echo '<span class="ads"><i class="fa fa-close"></i> Ads Disabled</span>';}
                                    echo "</div>";
                                echo '</div>';
                                echo '<hr>';
                            }
                            ?>
                        </div>
                    </div>
                    <a href="categories.php?do=Add" class="add-category btn btn-primary"><i class='fa fa-plus'></i> Add New Category</a>
                </div>
                <?php
            } else{
                echo'<div class="container">';
                    echo '<div class="nice-message"> There\'s No Categories To Show</div>';
                    echo '<a href="categories.php?do=Add" class="add-category btn btn-primary"><i class="fa fa-plus"></i> Add New Category</a>';

                echo '</div>';
            }
        } elseif ($do == 'Add') { // Add Page?>

            <h1 class='text-center'>Add New Category</h1>

            <div class='container'>
                <form class='form-horizontal' action='?do=Insert' method='POST'>
                    <!-- start name field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Name</label>
                        <div class='col-sm-10 col-md-4'>
                            <input type="text" name='name' class='form-control' outocomplete='off'
                            required='required' placeholder="Name Of The Category" >
                        </div>
                    </div>
                    <!-- end name field -->
                    <!-- start description field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Description</label>
                        <div class='col-sm-10 col-md-4'>
                            <input type="text" name='description' class='form-control' placeholder="Describe The Category">
                        </div>
                    </div>
                    <!-- end description field -->
                    <!-- start Ordering field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Ordering</label>
                        <div class='col-sm-10 col-md-4'>
                            <input type="text" name='ordering' class='form-control' placeholder='Number To Arrange The Categories'>
                        </div>
                    </div>
                    <!-- end Ordering field -->
                    <!-- start Visible field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Visible</label>
                        <div class='col-sm-10 col-md-4'>
                            <div>
                                <input id='vis-yes' type="radio" name='visibility' value='0' checked>
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id='vis-no' type="radio" name='visibility' value='1'>
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end Visible field -->
                    <!-- start commenting field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Allow Commenting</label>
                        <div class='col-sm-10 col-md-4'>
                            <div>
                                <input id='com-yes' type="radio" name='commenting' value='0' checked>
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input id='com-no' type="radio" name='commenting' value='1'>
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end commenting field -->
                    <!-- start ads field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Allow Ads</label>
                        <div class='col-sm-10 col-md-4'>
                            <div>
                                <input id='ads-yes' type="radio" name='ads' value='0' checked>
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id='ads-no' type="radio" name='ads' value='1'>
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end ads field -->
                    <!-- start submit field -->
                    <div class='form-group'>
                        <div class='col-sm-offset-2 col-sm-10'>
                            <input type="submit" value='Add Category' class='btn btn-primary btn-lg' />
                        </div>
                    </div>
                    <!-- end submit field -->
                </form>
            </div>


        <?php
        } elseif ($do == "Insert") {
            // insert member page
            echo "<div class='container'>";
            echo "<h1 class='text-center'>Insert Category</h1>";                     

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // get variables from the form
                $name           = $_POST['name'];
                $description    = $_POST['description'];
                $ordering       = $_POST['ordering'];
                $visibility     = $_POST['visibility'];
                $commenting     = $_POST['commenting'];
                $ads            = $_POST['ads'];

                // check if category is exist in database

                $check = checkItem ("Name", "categories", $name);

                if ($check == 1) {

                    $Massege = '<div class="alert alert-danger">Sory This Category Is Exist</div>';
                    redirctHome($Massege, 'back');
                } else {
                    
                    $stmt = $con->prepare("INSERT INTO categories
                                            (Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)
                                            VALUES (?, ?, ?, ?, ?, ?)");

                    $stmt->execute(array($name, $description, $ordering, $visibility, $commenting, $ads));

                    // echo seccess massege
                    $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record inserted </div>';

                    redirctHome($massege, 'back');
                }

            } else {
                echo '<div class="container">';
                $errorMsg = "<div class='alert alert-danger'> sorry you can't browse this page directly </div>";
                redirctHome($errorMsg, 'back', 3);
                echo '</div>';
            }
            echo "</div>";


        } elseif ($do == "Edit") {
            // check if the category id is numeric and git the intger value of it
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

            // select all data depend on this id
            $stmt = $con->prepare('SELECT * FROM categories WHERE ID = ? ');

            // execute query
            $stmt->execute(array($catid));

            //fetch the data
            $row = $stmt->fetch();

            // the row count
            $count = $stmt->rowCount();

            // if there's such id show the form
            if ($count > 0) {?>

                <h1 class='text-center'>Edit Category</h1>
    
                <div class='container'>
                    <form class='form-horizontal' action='?do=Update' method='POST'>
                        <input type="hidden" name="catid" value="<?php echo $catid ?>">
                        <!-- start name field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Name</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='name' class='form-control' value='<?php echo $row['Name'];?>'
                                required='required' placeholder="Name Of The Category" >
                            </div>
                        </div>
                        <!-- end name field -->
                        <!-- start description field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Description</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='description' class='form-control' value='<?php echo $row['Description'];?>'
                                placeholder="Describe The Category">
                            </div>
                        </div>
                        <!-- end description field -->
                        <!-- start Ordering field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Ordering</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='ordering' class='form-control' value='<?php echo $row['Ordering'];?>'
                                placeholder='Number To Arrange The Categories'>
                            </div>
                        </div>
                        <!-- end Ordering field -->
                        <!-- start Visible field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Visible</label>
                            <div class='col-sm-10 col-md-4'>
                                <div>
                                    <input id='vis-yes' type="radio" name='visibility' value='0' <?php if ($row['Visibility'] == 0){echo 'checked';} ?>>
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id='vis-no' type="radio" name='visibility' value='1' <?php if ($row['Visibility'] == 1){echo 'checked';} ?>>
                                    <label for="vis-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- end Visible field -->
                        <!-- start commenting field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Allow Commenting</label>
                            <div class='col-sm-10 col-md-4'>
                                <div>
                                    <input id='com-yes' type="radio" name='commenting' value='0'<?php if ($row['Allow_Comment'] == 0){echo 'checked';} ?>>
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id='com-no' type="radio" name='commenting' value='1' <?php if ($row['Allow_Comment'] == 1){echo 'checked';} ?>>
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- end commenting field -->
                        <!-- start ads field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Allow Ads</label>
                            <div class='col-sm-10 col-md-4'>
                                <div>
                                    <input id='ads-yes' type="radio" name='ads' value='0' <?php if ($row['Allow_Ads'] == 0){echo 'checked';} ?>>
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id='ads-no' type="radio" name='ads' value='1'<?php if ($row['Allow_Ads'] == 1){echo 'checked';} ?>>
                                    <label for="ads-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- end ads field -->
                        <!-- start submit field -->
                        <div class='form-group'>
                            <div class='col-sm-offset-2 col-sm-10'>
                                <input type="submit" value='Save' class='btn btn-primary btn-lg' />
                            </div>
                        </div>
                        <!-- end submit field -->
                    </form>
                </div>
    
            <?php
            // if there's no such id show error massege
            } else {
                echo '<div class="container">';
                $massege = '<div class="alert alert-danger">Theres No Such ID</div>';
                redirctHome($massege);
                echo '</div>';
            }

        } elseif ($do == "Update") {
            echo "<h1 class='text-center'>Update Category</h1>";
            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // get variables from the form
                $id = $_POST['catid'];
                $catname = $_POST['name'];
                $desc = $_POST['description'];
                $order = $_POST['ordering'];
                $visible = $_POST['visibility'];
                $comment = $_POST['commenting'];
                $ad = $_POST['ads'];

                
                $stmt = $con->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering = ?, Visibility = ?, Allow_Comment = ?, Allow_Ads = ? WHERE ID = ?");
                $stmt->execute(array($catname, $desc, $order, $visible, $comment, $ad, $id));

                // echo seccess massege
                $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Category Updated </div>';
                redirctHome($massege);


            } else {
                $errorMsg = "<div class='alert alert-danger'>sorry you can't browse this page directly</div>";
                redirctHome($errorMsg, 'back');
            }
            echo "</div>";
            
        } elseif ($do == "Delete") {

             // Delete Category page

             echo "<h1 class='text-center'>Delete Category</h1>";
             echo "<div class='container'>";
 
                 // check if the category id is numeric and git the intger value of it
                 $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
 
                 // the row count
                 $count = checkItem ('ID', 'categories', $catid);
 
                 // if there's such id show the form
                 if ($count > 0) {
 
                     $stmt = $con->prepare("DELETE FROM categories WHERE ID = ? ");
 
                     $stmt->execute(array($catid));
 
                     $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Category Deleted </div>';
                     redirctHome($massege, 'back');
 
                 } else {
 
 
                     $massege = "<div class='alert alert-danger'>This ID Is Not Exist</div>";
 
                     redirctHome($massege, 'back');
                 }
             echo "</div>";
 

        }

        include $tpl . 'footer.php' ;
    } else {
        header ('Location: index.php');

        exit();
    }