<?php

    /*
    ==============================================================
    ==== Manage comments page
    ==== you can edit | Approve | delete comments from here
    ==============================================================
    */


    session_start ();

    $pageTitle = 'Comments';

    if (isset($_SESSION['Username'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // start manage page
        if ( $do == 'Manage') {// manage page 

            // Selec all comments
            $stmt = $con->prepare(" SELECT 
                                            comments.* , items.Name, users.Username
                                    FROM
                                            comments
                                    INNER JOIN
                                            items
                                    ON
                                            items.Item_ID = comments.itemID
                                    INNER JOIN
                                            users
                                    ON
                                            users.UserID = comments.userID
                                    ORDER BY
                                            commentID DESC");
            $stmt->execute();

            $rows = $stmt->fetchAll();

            if (! empty($rows)){

                ?>
                <h1 class='text-center'>Manage Comments</h1>
                <div class='container'>
                    <div class='table-responsive'>
                        <table class='main-table text-center table table-bordered'>
                            <tr>
                                <td>ID</td>
                                <td>Comment</td>
                                <td>Item Name</td>
                                <td>User Name</td>
                                <td>Added Date</td>
                                <td>Control</td>
                            </tr>
                            <?php
                                foreach ($rows as $row){

                                    echo "<tr>";
                                        echo '<td>' . $row['commentID'] .'</td>';
                                        echo '<td>' . $row['Comment'] .'</td>';
                                        echo '<td>' . $row['Name'] .'</td>';
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
                </div>
                <?php
            } else{
                echo'<div class="container">';
                    echo '<div class="nice-message"> There\'s No Record To Show</div>';
                echo '</div>';
            }
        }  elseif ($do == 'Edit') { // Edit page 

                // check if the comment id is numeric and git the intger value of it
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

                // select all data depend on this id
                $stmt = $con->prepare('SELECT * FROM comments WHERE commentID = ? ');

                // execute query
                $stmt->execute(array($comid));

                //fetch the data
                $row = $stmt->fetch();

                // the row count
                $count = $stmt->rowCount();

                // if there's such id show the form
                if ($count > 0) { ?>

                    <h1 class='text-center'>Edit Comment</h1>

                    <div class='container'>
                        <form class='form-horizontal' action='?do=Update' method='POST'>
                            <input type="hidden" name="comid" value="<?php echo $comid ?>">
                            <!-- start Comment field -->
                            <div class='form-group form-group-lg'>
                                <label class='col-sm-2 control-label'>Comment</label>
                                <div class='col-sm-10 col-md-4'>
                                    <textarea name="comment" class="form-control"><?php echo $row['Comment']?></textarea>
                                </div>
                            </div>
                            <!-- end Comment field -->
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

            echo "<h1 class='text-center'>Update Comment</h1>";
            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // get variables from the form
                $comid = $_POST['comid'];
                $comment = $_POST['comment'];



                // update the database with the info
                
                $stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE commentID = ?");
                $stmt->execute(array($comment, $comid));

                // echo seccess massege
                $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Comment Updated </div>';
                redirctHome($massege, 'back');

            } else {
                $errorMsg = "<div class='alert alert-danger'>sorry you can't browse this page directly</div>";
                redirctHome($errorMsg, 'back');
            }
            echo "</div>";
        } elseif ($do == 'Delete') {

            // Delete Member page

            echo "<h1 class='text-center'>Delete Comment</h1>";
            echo "<div class='container'>";

                // check if the comment id is numeric and git the intger value of it
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

                // the row count
                $count = checkItem ('commentID', 'comments', $comid);

                // if there's such id show the form
                if ($count > 0) {

                    $stmt = $con->prepare("DELETE FROM comments WHERE commentID = ? ");

                    $stmt->execute(array($comid));

                    $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Comment Deleted </div>';
                    redirctHome($massege, 'back');

                } else {


                    $massege = "<div class='alert alert-danger'>This ID Is Not Exist</div>";

                    redirctHome($massege);
                }
            echo "</div>";

        } elseif ($do == 'Approve') {

            // Activate comment page

            echo "<h1 class='text-center'>Approve Comment</h1>";
            echo "<div class='container'>";

                // check if the comment id is numeric and git the intger value of it
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

                // the row count
                $count = checkItem ('commentID', 'comments', $comid);

                // if there's such id show the form
                if ($count > 0) {

                    $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE commentID = ? ");

                    $stmt->execute(array($comid));

                    $massege = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Comment Approved </div>';
                    redirctHome($massege, 'back');

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

