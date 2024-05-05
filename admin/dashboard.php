<?php

    session_start ();

    if (isset($_SESSION['Username'])) {

        $pageTitle = 'Dashboard';

        include 'init.php';

        $numUsers = 4; // number of lastest users in database

        $latestUsers = getLastest("*", 'users', 'UserID', $numUsers); // lastesr users array  

        $numItems = 4; // number of lastest items in database

        $latestItems = getLastest("*", 'items', 'Item_ID', $numItems); // lastesr items array 
        

        $numComments = 4; // number of lastest comments in database

        /* Start Dashboard Page */
        ?>
        <div class='home-stats'>
            <div class='container home-stats text-center'>
                <h1>Dashboard</h1>
                <div class='row'>
                    <div class='col-md-3'>
                        <div class='stat st-members'>
                            <i class='fa fa-users'></i>
                            <div class="info">
                                Total Members
                                <span> 
                                    <a href="members.php"><?php echo countItem('UserID', 'users'); ?> </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='stat st-pending'>
                            <i class='fa fa-user-plus'></i>
                            <div class="info">
                                Pending Members
                                <span ><a href='members.php?do=Manage&page=Pending'><?php echo checkItem('RegStatus', 'users', 0); ?></a></span>
                            </div>  
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='stat st-items'>
                            <i class='fa fa-tag'></i>
                            <div class="info">
                                Total Items
                                <span> <a href="items.php"><?php echo countItem('Item_ID', 'items'); ?> </a></span>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='stat st-comments'>
                            <i class='fa fa-comment'></i>
                            <div class="info">
                                Total Comments
                                <span> <a href="comments.php"><?php echo countItem('commentID', 'comments'); ?> </a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='latest'>
            <div class='container latest'>
                <div class='row'>
                    <div class='col-sm-6'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                <i class='fa fa-users'></i> Latest <?php echo $numUsers; ?> Registered Users
                                <span class="toggle-info pull-right">
                                    <i class="fa fa-minus fa-lg"></i>
                                </span>
                            </div>
                            <div class='panel-body'>
                                <ul class="list-unstyled lastest-users">
                                <?php
                                if (! empty($latestUsers)){
                                    foreach ($latestUsers as $user) { 
                                        echo '<li>';
                                            echo $user['Username'];
                                            echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">'; 
                                                echo '<span class="btn btn-success pull-right">';
                                                    echo '<i class="fa fa-edit"></i> Edite';
                                                    if ($user['RegStatus'] == 0) {
                                                        echo "<a 
                                                                href='members.php?do=Activate&userid=" . $user['UserID'] . "' 
                                                                class='btn btn-info activate pull-right'>
                                                                <i class='fa fa-check'></i> Activate  </a>";
                                                    } 
                                                echo '</span>'; 
                                            echo '</a>';
                                        echo '</li>';
                                    }
                                } else {
                                        echo '<div class="nice-message"> There\'s No Users To Show</div>';
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-6'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                <i class='fa fa-tag'></i> Latest <?php echo $numItems; ?> Added Items
                                <span class="toggle-info pull-right">
                                    <i class="fa fa-minus fa-lg"></i>
                                </span>
                            </div>
                            <div class='panel-body'>
                                <ul class="list-unstyled lastest-users">
                                    <?php
                                    if(! empty($latestItems)){
                                        foreach ($latestItems as $item) { 
                                            echo '<li>';
                                                echo $item['Name'];
                                                echo '<a href="items.php?do=Edite&itemid=' . $item['Item_ID'] . '">'; 
                                                    echo '<span class="btn btn-success pull-right">';
                                                        echo '<i class="fa fa-edit"></i> Edite';
                                                        if ($item['Approve'] == 0) {
                                                            echo "<a 
                                                                    href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
                                                                    class='btn btn-info activate pull-right'>
                                                                    <i class='fa fa-check'></i> Approve  </a>";
                                                        } 
                                                    echo '</span>'; 
                                                echo '</a>';
                                            echo '</li>';
                                        }
                                    } else {
                                            echo '<div class="nice-message"> There\'s No Items To Show</div>';
                                    }
                                    ?>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- start Latest comment -->
                <div class='row'>
                    <div class='col-sm-6'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                <i class='fa fa-comments-o'></i> Latest <?php echo $numComments; ?> Comments
                                <span class="toggle-info pull-right">
                                    <i class="fa fa-minus fa-lg"></i>
                                </span>
                            </div>
                            <div class='panel-body'>
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
                                                        ORDER BY
                                                                commentID DESC
                                                        LIMIT 
                                                                $numComments");
                                $stmt->execute();
                                $rows = $stmt->fetchAll();
                                if (! empty ($rows)){
                                    foreach ($rows as $row){
                                        echo '<div class="comment-box">';
                                            echo '<span class="member-n">
                                                        <a href="members.php?do=Edit&userid=' . $row['userID'] . '">
                                                            ' . $row['Username'] . '</a></span>';
                                            echo '<p class="member-c">' . $row['Comment'] . '</p>'; 
                                        echo '</div>';
                                    }
                                } else {
                                        echo '<div class="nice-message"> There\'s No Comments To Show</div>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        /* End Dashboard Page */        

    include $tpl . 'footer.php';

    } else {

        header('Location: index.php');

        exit();

    }