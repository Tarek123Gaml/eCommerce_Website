<?php

    session_start();
    $pageTitle = "Show Item";

    include 'init.php';

    // check if the item id is numeric and git the intger value of it
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    // select all data depend on this id
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
                            WHERE
                                Item_ID =?
                            AND
                                Approve = 1
                            ");

    // execute query
    $stmt->execute(array($itemid));

    // the row count
    $count = $stmt->rowCount();

    // if there's such id show the form
    if($count > 0){

    //fetch the data
    $item = $stmt->fetch();
?>
<h1 class='text-center'><?php echo $item['Name']?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <img class="img-responsive img-thumbnail center-block" src="img.png" alt="">
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $item['Name'] ?></h2>
            <p><?php echo $item['Description'] ?></p>
            <ul class="list-unstyled">
                <li>
                    <i class="fa fa-calendar fa-fw"></i>
                    <span>Added Date: </span><?php echo $item['Add_Date'] ?>
                </li>
                <li>
                    <i class="fa fa-money fa-fw"></i>
                    <span>Price:</span> $<?php echo $item['Price'] ?>
                </li>
                <li>
                    <i class="fa fa-globe fa-fw"></i>
                    <span>Made In:</span> <?php echo $item['Country_Made'] ?>
                </li>
                <li>
                    <i class="fa fa-tags fa-fw"></i>
                    <span>Category:</span> <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['Cat_Name'] ?></a>
                </li>
                <li>
                    <i class="fa fa-user fa-fw"></i>
                    <span>Added By:</span> <a href="#"> <?php echo $item['Username'] ?></a>
                </li>
                <li class="item-tag">
                    <i class="fa fa-tags fa-fw"></i>
                    <span>Tags :</span>
                    <?php 
                        $allTags = explode(',', $item['Tags']);
                        foreach ($allTags as $tag){
                            $tag = str_replace(' ', '', $tag);
                            if(!empty($tag)){
                                echo '<a href="tags.php?name=' . strtolower($tag) . '">' . $tag . '</a>';
                            }
                        }
                    ?>
                </li>
            </ul>
        </div>
    </div>
    <hr class="custom-hr">
    <?php if(isset($_SESSION['user'])) {?>
    <!-- Start Add Comment -->
    <div class="row">
        <div class="col-md-offset-3">
            <div class="add-comment">
                <h3>Add Your Comment</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID']?>" method="POST">
                    <textarea name="comment" required></textarea>
                    <input class="btn btn-primary" type="submit" value="Add Comment">
                </form>
                <?php 
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){

                        $comment = htmlspecialchars(strip_tags($_POST['comment']));
                        $itid = $item['Item_ID'];
                        $userid = $_SESSION['uid'];

                        if (!empty($comment)){
                            $stmt = $con->prepare("INSERT INTO 
                                    comments(comment, itemID, userID, Status, commentDate)
                                    VALUE(?, ?, ?, 0, NOW())");

                            $stmt->execute(array($comment, $itid, $userid));

                            if($stmt){
                                echo '<div class="alert alert-success">Comment Added</div>';
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- End Add Comment -->
    <?php }else{
        echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment';
    } ?>
    <hr class="custom-hr">
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
                                    itemID = ?
                            AND
                                    Status = 1
                            ORDER BY
                                    commentID DESC");
    $stmt->execute(array($item['Item_ID']));

    $rows = $stmt->fetchAll();

    foreach($rows as $row){?>
        <div class="comment-box">
            <div class="row">
                <div class="col-sm-2 text-center">
                    <img class="img-responsive img-thumbnail img-circle center-block" src="img.png" alt="">
                    <?php echo $row['Username'] ?>
                </div>
                <div class="col-sm-10">
                    <p class="lead"><?php echo $row['Comment'] ?></p>
                </div>
            </div>
        </div>
        <hr class="custom-hr">
    <?php } ?>
</div>

<?php }else{

        echo '<div class="container">
                <div class="alert alert-danger">Theres No Such ID Or Item Wating Approval</div>
            </div>';
    }


    include $tpl . 'footer.php';
?> 