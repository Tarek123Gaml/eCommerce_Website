<?php

    /*
    ===============================================================
    =========== Item Page
    ===============================================================
    */

    session_start();

    $pageTitle = '';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == "Manage") {// manage page 

            // Selec all Items 

            $stmt = $con->prepare("SELECT
                                            items.*, categories.Name as Cat_Name, users.Username
                                    FROM 
                                            items
                                    INNER JOIN
                                            categories
                                    ON
                                            categories.ID = items.Cat_ID
                                    INNER JOIN
                                            users
                                    ON
                                            users.UserID = items.Member_ID
                                    ORDER BY 
                                            Item_ID DESC
                                    ");
            $stmt->execute();

            $items = $stmt->fetchAll();

            if(! empty($items)){
                ?>
                <h1 class='text-center'>Manage Items</h1>
                <div class='container'>
                    <div class='table-responsive'>
                        <table class='main-table text-center table table-bordered'>
                            <tr>
                                <td>#ID</td>
                                <td>Name</td>
                                <td>Description</td>
                                <td>Price</td>
                                <td>Add Date</td>
                                <td>Category</td>
                                <td>Member</td>
                                <td>Control</td>
                            </tr>
                            <?php
                                foreach ($items as $item){

                                    echo "<tr>";
                                        echo '<td>' . $item['Item_ID'] .'</td>';
                                        echo '<td>' . $item['Name'] .'</td>';
                                        echo '<td>' . $item['Description'] .'</td>';
                                        echo '<td>' . $item['Price'] .'</td>';
                                        echo '<td>' . $item['Add_Date'] .'</td>';
                                        echo '<td>' . $item['Cat_Name'] .'</td>';
                                        echo '<td>' . $item['Username'] .'</td>';
                                        echo "<td>
                                            <a href='items.php?do=Edite&itemid=" . $item['Item_ID'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit </a> 
                                            <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>  ";
                                            if ($item['Approve'] == 0) {
                                                echo "<a 
                                                        href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
                                                        class='btn btn-info activate'>
                                                        <i class='fa fa-check'></i> Approve </a>";
                                            } 
                                        echo "</td>";
                                    echo "</tr>";

                                }
                            ?>
                        </table>
                    </div>
                    <a href="items.php?do=Add" class='btn btn-sm btn-primary'> New Item</a>
                </div>
                <?php
            } else{
                echo'<div class="container">';
                    echo '<div class="nice-message"> There\'s No Items To Show</div>';
                    echo '<a href="items.php?do=Add" class="btn  btn-primary"><i class="fa fa-plus"></i> New Item</a>';
                echo '</div>';
            }

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
                    <!-- start Description field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Description</label>
                        <div class='col-sm-10 col-md-4'>
                            <input type="text" name='description' class='form-control'
                            required='required' placeholder="Description Of The Item" >
                        </div>
                    </div>
                    <!-- end Description field -->
                    <!-- start Price field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Price</label>
                        <div class='col-sm-10 col-md-4'>
                            <input type="text" name='price' class='form-control'
                            required='required' placeholder="Price Of The Item" >
                        </div>
                    </div>
                    <!-- end Price field -->
                    <!-- start Country field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Country</label>
                        <div class='col-sm-10 col-md-4'>
                            <input type="text" name="country" class="form-control"
                            required='required' placeholder="Country Of The Item" >
                        </div>
                    </div>
                    <!-- end Country field -->
                    <!-- start Status field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Status</label>
                        <div class='col-sm-10 col-md-4'>
                            <select name="status" >
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- end Status field -->
                    <!-- start member field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Member</label>
                        <div class='col-sm-10 col-md-4'>
                            <select name="member" >
                                <option value="0">...</option>
                                <?php
                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $members = $stmt->fetchAll();
                                    foreach($members as $member){
                                        echo '<option value="' . $member['UserID'] . '">' . $member['Username'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- end member field -->
                    <!-- start category field -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Category</label>
                        <div class='col-sm-10 col-md-4'>
                            <select name="category">
                                <option value="0">...</option>
                                <?php
                                    $stmt = $con->prepare("SELECT * FROM categories");
                                    $stmt->execute();
                                    $category = $stmt->fetchAll();
                                    foreach($category as $cat){
                                        echo '<option value="' . $cat['ID'] . '">' . $cat['Name'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- end category field -->
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
            // insert item page

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo "<div class='container'>";
                echo "<h1 class='text-center'>Insert Item</h1>";                     

                // get variables from the form
                $name           = $_POST['name'];
                $description    = $_POST['description'];
                $price          = $_POST['price'];
                $country        = $_POST['country'];
                $status         = $_POST['status'];
                $member         = $_POST['member'];
                $category       = $_POST['category'];

                // validate errors
                $FormErrors = array();

                if (empty($name)) {
                    $FormErrors[] = "Name can't be empty";
                }

                if (empty($description)) {
                    $FormErrors[] = "description can't be empty";
                }

                if (empty($price)) {
                    $FormErrors[] = "Price name can't be empty";
                }

                if (empty($country)) {
                    $FormErrors[] = "Country con't be empty";
                }
                if ($status == 0){
                    $FormErrors[] = "You Must Select Status";
                }
                if ($category == 0){
                    $FormErrors[] = "You Must Select Sategory";
                }
                if ($member == 0){
                    $FormErrors[] = "You Must Select Member";
                }

                foreach ($FormErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // proceed the insert operation if there's no any errors

                if (empty($FormErrors)){

                        
                        $stmt = $con->prepare("INSERT INTO items (Name, Description, Price, Status, Country_Made, Cat_ID, Member_ID, Add_Date)
                                                            VALUES (?, ?, ?, ?, ?, ?, ?, now())");

                        $stmt->execute(array($name, $description, $price, $status, $country, $category, $member));
    
                        // echo seccess massege
                        $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Item inserted </div>';

                        redirctHome($massege, 'back');
                }


            } else {
                echo '<div class="container">';
                $errorMsg = "<div class='alert alert-danger'> sorry you can't browse this page directly </div>";
                redirctHome($errorMsg);
                echo '</div>';
            }
            echo "</div>";

        } elseif ($do == "Edite") {// Edit page 

            // check if the item id is numeric and git the intger value of it
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            // select all data depend on this id
            $stmt = $con->prepare('SELECT * FROM items WHERE Item_ID = ? ');

            // execute query
            $stmt->execute(array($itemid));

            //fetch the data
            $row = $stmt->fetch();

            // the row count
            $count = $stmt->rowCount();

            // if there's such id show the form
            if ($count > 0) {?>

                <h1 class='text-center'>Edite Item</h1>
    
                <div class='container'>
                    <form class='form-horizontal' action='?do=Update' method='POST'>
                    <input type="hidden" name="itemid" value="<?php echo $itemid ?>">

                        <!-- start name field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Name</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='name' class='form-control' value="<?php echo $row['Name']?>"
                                required='required' placeholder="Name Of The Item" >
                            </div>
                        </div>
                        <!-- end name field -->
                        <!-- start Description field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Description</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='description' class='form-control' value="<?php echo $row['Description']?>"
                                required='required' placeholder="Description Of The Item" >
                            </div>
                        </div>
                        <!-- end Description field -->
                        <!-- start Price field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Price</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='price' class='form-control' value="<?php echo $row['Price']?>"
                                required='required' placeholder="Price Of The Item" >
                            </div>
                        </div>
                        <!-- end Price field -->
                        <!-- start Country field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Country</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name="country" class="form-control" value="<?php echo $row['Country_Made']?>"
                                required='required' placeholder="Country Of The Item" >
                            </div>
                        </div>
                        <!-- end Country field -->
                        <!-- start Status field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Status</label>
                            <div class='col-sm-10 col-md-4'>
                                <select name="status" >
                                    <option value="0">...</option>
                                    <option value="1" <?php if ($row['Status'] == 1){echo 'selected';}?>>New</option>
                                    <option value="2" <?php if ($row['Status'] == 2){echo 'selected';}?>>Like New</option>
                                    <option value="3" <?php if ($row['Status'] == 3){echo 'selected';}?>>Used</option>
                                    <option value="4" <?php if ($row['Status'] == 4){echo 'selected';}?>>Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- end Status field -->
                        <!-- start member field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Member</label>
                            <div class='col-sm-10 col-md-4'>
                                <select name="member" >
                                    <option value="0">...</option>
                                    <?php
                                        $stmt = $con->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $members = $stmt->fetchAll();
                                        foreach($members as $member){
                                            echo '<option value="' . $member['UserID'] . '"';
                                            if ($row['Member_ID'] == $member['UserID']){ echo 'selected' ; }
                                            echo '>' . $member['Username'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- end member field -->
                        <!-- start category field -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Category</label>
                            <div class='col-sm-10 col-md-4'>
                                <select name="category">
                                    <option value="0">...</option>
                                    <?php
                                        $stmt = $con->prepare("SELECT * FROM categories");
                                        $stmt->execute();
                                        $category = $stmt->fetchAll();
                                        foreach($category as $cat){
                                            echo '<option value="' . $cat['ID'] . '"';
                                            if ($row['Cat_ID'] == $cat['ID']){ echo 'selected' ; }
                                            echo '>' . $cat['Name'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- end category field -->
                        <!-- start submit field -->
                        <div class='form-group'>
                            <div class='col-sm-offset-2 col-sm-10'>
                                <input type="submit" value='Save' class='btn btn-primary btn-sm' />
                            </div>
                        </div>
                        <!-- end submit field -->
                    </form>

                    <?php
                    // Selec all comments
                    $stmt = $con->prepare(" SELECT 
                                                    comments.* , users.Username
                                            FROM
                                                    comments
                                            INNER JOIN
                                                    users
                                            ON
                                                    users.UserID = comments.userID
                                            WHERE
                                                    itemID = $itemid");
                    $stmt->execute();

                    $rows = $stmt->fetchAll();
                    
                    if (! empty($rows)){

                        ?>
                        <h1 class='text-center'>Manage [ <?php echo $row['Name']?> ] Comments</h1>
                        <div class='table-responsive'>
                            <table class='main-table text-center table table-bordered'>
                                <tr>
                                    <td>Comment</td>
                                    <td>User Name</td>
                                    <td>Added Date</td>
                                    <td>Control</td>
                                </tr>
                                <?php
                                    foreach ($rows as $row){

                                        echo "<tr>";
                                            echo '<td>' . $row['Comment'] .'</td>';
                                            echo '<td>' . $row['Username'] .'</td>';
                                            echo '<td>' . $row['commentDate'] .'</td>';
                                            echo "<td>
                                                <a href='comments.php?do=Edit&comid=" . $row['commentID'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit </a> 
                                                <a href='comments.php?do=Delete&comid=" . $row['commentID'] . "'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>  ";
                                                if ($row['Status'] == 0) {
                                                    echo "<a 
                                                            href='comments.php?do=Approve&comid=" . $row['commentID'] . "' 
                                                            class='btn btn-info activate'>
                                                            <i class='fa fa-check'></i> Approve </a>";
                                                } 
                                            echo "</td>";
                                        echo "</tr>";

                                    }
                                ?>
                            </table>
                        </div>
                    <?php } ?>
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
            
            echo "<h1 class='text-center'>Update Item</h1>";
            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // get variables from the form
                $itemid         = $_POST['itemid'];
                $name           = $_POST['name'];
                $description    = $_POST['description'];
                $price          = $_POST['price'];
                $country        = $_POST['country'];
                $status         = $_POST['status'];
                $member         = $_POST['member'];
                $category       = $_POST['category'];

                // validate errors
                $FormErrors = array();

                if (empty($name)) {
                    $FormErrors[] = "Name can't be empty";
                }

                if (empty($description)) {
                    $FormErrors[] = "description can't be empty";
                }

                if (empty($price)) {
                    $FormErrors[] = "Price name can't be empty";
                }

                if (empty($country)) {
                    $FormErrors[] = "Country con't be empty";
                }
                if ($status == 0){
                    $FormErrors[] = "You Must Select Status";
                }
                if ($category == 0){
                    $FormErrors[] = "You Must Select Sategory";
                }
                if ($member == 0){
                    $FormErrors[] = "You Must Select Member";
                }

                foreach ($FormErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // proceed the update operation if there's no any errors

                if (empty($FormErrors)){

                    // update the database with the info
                    
                    $stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, Member_ID = ? WHERE Item_ID = ?");
                    $stmt->execute(array($name, $description, $price, $country, $status, $category, $member, $itemid));

                    // echo seccess massege
                    $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Item Updated </div>';
                    redirctHome($massege);
                }


            } else {
                $errorMsg = "<div class='alert alert-danger'>sorry you can't browse this page directly</div>";
                redirctHome($errorMsg, 'back');
            }
            echo "</div>";
            
        } elseif ($do == "Delete") {
            // Delete Item page

            echo "<h1 class='text-center'>Delete Item</h1>";
            echo "<div class='container'>";

                // check if the Item id is numeric and git the intger value of it
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                // the row count
                $count = checkItem ('Item_ID', 'items', $itemid);

                // if there's such id show the form
                if ($count > 0) {

                    $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = ? ");

                    $stmt->execute(array($itemid));

                    $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Item Deleted </div>';
                    redirctHome($massege, 'back');

                } else {


                    $massege = "<div class='alert alert-danger'>This ID Is Not Exist</div>";

                    redirctHome($massege);
                }
            echo "</div>";
        } elseif ($do == "Approve" ) {
            // Approve Item page

            echo "<h1 class='text-center'>Approve Item</h1>";
            echo "<div class='container'>";

                // check if the item id is numeric and git the intger value of it
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                // the row count
                $count = checkItem ('Item_ID', 'items', $itemid);

                // if there's such id show the form
                if ($count > 0) {

                    $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ? ");

                    $stmt->execute(array($itemid));

                    $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Item Approverd </div>';
                    redirctHome($massege, 'back');

                } else {


                    $massege = "<div class='alert alert-danger'>This ID Is Not Exist</div>";

                    redirctHome($massege);
                }
            echo "</div>";

        }

        include $tpl . 'footer.php' ;
    } else {
        header ('Location: index.php');

        exit();
    }