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

            $stmt = $con->prepare("SELECT * FROM items");
            $stmt->execute();

            $items = $stmt->fetchAll();
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
                                    echo "<td>
                                        <a href='items.php?do=Edit&userid=" . $item['Item_ID'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit </a> 
                                        <a href='items.php?do=Delete&userid=" . $item['Item_ID'] . "'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>  ";
                                    echo "</td>";
                                echo "</tr>";

                            }
                        ?>
                    </table>
                </div>
                <a href="items.php?do=Add" class='btn btn-sm btn-primary'> New Item</a>
            </div>
<?php

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