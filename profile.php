<?php

    session_start();
    $pageTitle = "Profile";

    include 'init.php';

    if (isset($_SESSION['user'])) {

        $getUser = $con->prepare('SELECT * FROM users WHERE Username = ?');

        $getUser->execute(array($sessionUser));

        $info = $getUser->fetch();
?>
<h1 class='text-center'>My Profile</h1>

<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Information</div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Name </span> : <?php echo $info['Username'] ?> 
                        </li>
                        <li>
                            <i class="fa fa-envelope-o a-fw"></i>
                            <span>Email </span> : <?php echo $info['Email'] ?> 
                        </li>
                        <li>
                            <i class="fa fa-user a-fw"></i>
                            <span>Full Name </span> : <?php echo $info['FullName'] ?> 
                        </li>
                        <li>
                            <i class="fa fa-calendar a-fw"></i>
                            <span>Register Date </span> : <?php echo $info['Date'] ?> 
                        </li>
                        <li>
                            <i class="fa fa-tags a-fw"></i>
                            <span>Fav Category </span> :  
                        </li>
                    </ul>
                    <a href="#" class="btn btn-default" >Edit Information</a>
                </div>
        </div>
    </div>
</div>

<div id="my-ads" class="my-ads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Items</div>
            <div class="panel-body">
                <div class="rwo">
                    <?php
                    $items = getAll('*', 'items', ' WHERE Member_ID ='. $info['UserID'], 'Item_ID');

                    if(! empty($items)){
                        echo '<div class="row">';
                        foreach( $items as $item){?>
                            <div class="col-sm-6 col-md-3">
                                <div class="thumbnail item-box">
                                    <?php 
                                    if ($item['Approve'] == 0){
                                        echo '<span class="approve-status">Waiting Approval</span>';
                                    }?>
                                    <span class="price-tag">$<?php echo $item['Price'] ?></span>
                                    <img class="img-responsive" src="img.png" alt="">
                                    <div class="caption">
                                        <h3><a href='items.php?itemid=<?php echo $item['Item_ID']?>'><?php echo $item['Name'] ?></a></h3>
                                        <p><?php echo $item['Description'] ?></p>
                                        <p class="date"><?php echo $item['Add_Date'] ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        echo '</div>'; 
                    } else {
                        echo "Sorry There's No Ads To Show <a href='newad.php'>New Ad</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="my-comments block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Latest Comments</div>
            <div class="panel-body">
                <?php

                $comments = cgetAll ('Comment', 'comments', 'WHERE userID = ?', commentID);

                if(! empty($comments)) {
                    foreach($comments as $comment){
                        echo "<p>" . $comment['Comment'] . "</p>";
                    }
                } else {
                    echo 'There\'s No Comments To Show';
                }

                ?>
            </div>
        </div>
    </div>
</div>
<?php
} else {
    header('Location: login.php');
}

    include $tpl . 'footer.php';
?> 