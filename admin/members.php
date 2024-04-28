<?php

    /*
    ==============================================================
    ==== Manage members page
    ==== you can edit | add | delete members from here
    ==============================================================
    */


    session_start ();

    $pageTitle = 'Members';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // start manage page
        if ( $do == 'Manage') {// manage page 
            
            // Selec all users except Admins
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1");
            $stmt->execute();

            $rows = $stmt->fetchAll();
        ?>
            <h1 class='text-center'>Manage Members</h1>
            <div class='container'>
                <div class='table-responsive'>
                    <table class='main-table text-center table table-bordered'>
                        <tr>
                            <td>#ID</td>
                            <td>Full Name</td>
                            <td>Username</td>
                            <td>Email</td>
                            <td>Rigesterd Date</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach ($rows as $row){

                                echo "<tr>";
                                    echo '<td>' . $row['UserID'] .'</td>';
                                    echo '<td>' . $row['FullName'] .'</td>';
                                    echo '<td>' . $row['Username'] .'</td>';
                                    echo '<td>' . $row['Email'] .'</td>';
                                    echo '<td>' . $row['Date'] .'</td>';
                                    echo "<td>
                                        <a href='members.php?do=Edit&userid=" . $row['UserID'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                        <a href='members.php?do=Delete&userid=" . $row['UserID'] . "'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>    
                                    </td>";
                                echo "</tr>";

                            }
                        ?>
                    </table>
                </div>
                <a href="members.php?do=Add" class='btn btn-primary'><i class='fa fa-plus'></i> New Member</a>
            </div>
<?php
        } elseif ($do== 'Add') {?>

                    <h1 class='text-center'>Add New Member</h1>

                    <div class='container'>
                        <form class='form-horizontal' action='?do=Insert' method='POST'>
                            <!-- start username field -->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-2 control-label'>Username</label>
                                <div class='col-sm-10 col-md-4'>
                                    <input type="text" name='username' class='form-control' outocomplete='off' required='required' >
                                </div>
                            </div>
                            <!-- end username field -->
                            <!-- start password field -->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-2 control-label'>Password</label>
                                <div class='col-sm-10 col-md-4'>
                                    <input type="password" name='password' class='password form-control' outocomplete='new-password' required='required'>
                                    <i class='show-pass fa fa-eye fa-2x'></i>
                                </div>
                            </div>
                            <!-- end password field -->
                            <!-- start email field -->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-2 control-label'>Email</label>
                                <div class='col-sm-10 col-md-4'>
                                    <input type="email" name='email' class='form-control' required='required'>
                                </div>
                            </div>
                            <!-- end email field -->
                            <!-- start Full Name field -->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-2 control-label'>Full Name</label>
                                <div class='col-sm-10 col-md-4'>
                                    <input type="text" name='full' class='form-control' required='required'>
                                </div>
                            </div>
                            <!-- end Full Name field -->
                            <!-- start submit field -->
                            <div class='form-group'>
                                <div class='col-sm-offset-2 col-sm-10'>
                                    <input type="submit" value='Add Member' class='btn btn-primary btn-lg' />
                                </div>
                            </div>
                            <!-- end submit field -->
                        </form>
                    </div>

        <?php


        } elseif($do == 'Insert') {
            // insert member page
            echo "<div class='container'>";
            echo "<h1 class='text-center'>Insert Member</h1>";                     

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // get variables from the form
                $user = $_POST['username'];
                $email = $_POST['email'];
                $name = $_POST['full'];
                $pass = $_POST['password'];
                $hpass = sha1($pass);

                // validate errors
                $FormErrors = array();

                if (strlen($user) < 4 || strlen($user) > 9) {
                    $FormErrors[] = "username can't be less then 4 or greater then 9";
                }

                if (empty($email)) {
                    $FormErrors[] = "email can't be empty";
                }

                if (empty($name)) {
                    $FormErrors[] = "full name can't be empty";
                }

                if (empty($pass)) {
                    $FormErrors[] = "password con't be empty";
                }

                foreach ($FormErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // proceed the insert operation if there's no any errors

                if (empty($FormErrors)){

                    // insert the database with the info

                    // check if item is exist

                    $check = checkItem ("Username", "users", $user);

                    if ($check == 1) {

                        $Massege = '<div class="alert alert-danger">Sory This User Is Exist</div>';
                        redirctHome($Massege, 'back');
                    } else {
                        
                        $stmt = $con->prepare("INSERT INTO users (Username, Email, FullName, Password, Date) VALUES (?, ?, ?, ?, now())");

                        $stmt->execute(array($user, $email, $name, $hpass));
    
                        // echo seccess massege
                        $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record inserted </div>';

                        redirctHome($massege, 'back');
                    }
                    
                }


            } else {
                echo '<div class="container">';
                $errorMsg = "<div class='alert alert-danger'> sorry you can't browse this page directly </div>";
                redirctHome($errorMsg, 'back', 3);
                echo '</div>';
            }
            echo "</div>";

        } elseif ($do == 'Edit') { // Edit page 

                // check if the user id is numeric and git the intger value of it
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

                // select all data depend on this id
                $stmt = $con->prepare('SELECT * FROM users WHERE UserID = ? LIMIT 1');

                // execute query
                $stmt->execute(array($userid));

                //fetch the data
                $row = $stmt->fetch();

                // the row count
                $count = $stmt->rowCount();

                // if there's such id show the form
                if ($count > 0) { ?>

                    <h1 class='text-center'>Edit Member</h1>

                    <div class='container'>
                        <form class='form-horizontal' action='?do=Update' method='POST'>
                            <input type="hidden" name="userid" value="<?php echo $userid ?>">
                            <!-- start username field -->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-2 control-label'>Username</label>
                                <div class='col-sm-10 col-md-4'>
                                    <input type="text" name='username' class='form-control' value='<?php echo $row['Username']?>' outocomplete='off' required='required' >
                                </div>
                            </div>
                            <!-- end username field -->
                            <!-- start password field -->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-2 control-label'>Password</label>
                                <div class='col-sm-10 col-md-4'>
                                <input type="hidden" name='oldpassword' value='<?php echo $row['Password']?>' >
                                    <input type="password" name='newpassword' class='form-control' outocomplete='new-password' placeholder='leave blank if you dont wont to change'>
                                </div>
                            </div>
                            <!-- end password field -->
                            <!-- start email field -->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-2 control-label'>Email</label>
                                <div class='col-sm-10 col-md-4'>
                                    <input type="email" name='email' value='<?php echo $row['Email']?>' class='form-control' required='required'>
                                </div>
                            </div>
                            <!-- end email field -->
                            <!-- start Full Name field -->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-2 control-label'>Full Name</label>
                                <div class='col-sm-10 col-md-4'>
                                    <input type="text" name='full' value='<?php echo $row['FullName']?>' class='form-control' required='required'>
                                </div>
                            </div>
                            <!-- end Full Name field -->
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
        } elseif($do == 'Update') {// Update page

            echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // get variables from the form
                $id = $_POST['userid'];
                $user = $_POST['username'];
                $email = $_POST['email'];
                $name = $_POST['full'];

                // password trick
                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

                // validate errors
                $FormErrors = array();

                if (strlen($user) < 4 || strlen($user) > 9) {
                    $FormErrors[] = "username can't be less then 4 or greater then 9";
                }

                if (empty($email)) {
                    $FormErrors[] = "email can't be empty";
                }

                if (empty($name)) {
                    $FormErrors[] = "full name can't be empty";
                }

                foreach ($FormErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // proceed the update operation if there's no any errors

                if (empty($FormErrors)){

                    // update the database with the info
                    
                    $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
                    $stmt->execute(array($user, $email, $name, $pass, $id));

                    // echo seccess massege
                    $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated </div>';
                    redirctHome($massege);
                }


            } else {
                $errorMsg = "<div class='alert alert-danger'>sorry you can't browse this page directly</div>";
                redirctHome($errorMsg, 'back');
            }
            echo "</div>";
        } elseif ($do == 'Delete') {

            // Delete Member page

            echo "<h1 class='text-center'>Delete Member</h1>";
            echo "<div class='container'>";

                // check if the user id is numeric and git the intger value of it
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

                // the row count
                $count = checkItem ('userid', 'users', $userid);

                // if there's such id show the form
                if ($count > 0) {

                    $stmt = $con->prepare("DELETE FROM users WHERE UserID = ? ");

                    $stmt->execute(array($userid));

                    $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted </div>';
                    redirctHome($massege);

                } else {


                    $massege = "<div class='alert alert-danger'>This ID Is Not Exist</div>";

                    redirctHome($massege);
                }
            echo "</div>";

        }

        include $tpl . 'footer.php';

    } else {

        header('Location: index.php');

        exit();

    }

