<?php

    session_start ();

    if (isset($_SESSION['Username'])) {

        $pageTitle = 'Dashboard';

        include 'init.php';

        $lastestUsers = 4; // number of lastest users in database

        $lastest = getLastest("*", 'users', 'UserID', $lastestUsers); // lastesr users array  

        /* Start Dashboard Page */
        ?>
        <div class='home-stats'>
            <div class='container home-stats text-center'>
                <h1>Dashboard</h1>
                <div class='row'>
                    <div class='col-md-3'>
                        <div class='stat st-members'>
                            Total Members
                            <span> <a href="members.php"><?php echo countItem('UserID', 'users'); ?> </a></span>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='stat st-pending'>
                            Pending Members
                            <span ><a href='members.php?do=Manage&page=Pending'><?php echo checkItem('RegStatus', 'users', 0); ?></a></span>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='stat st-items'>
                            Total Items
                            <span> <a href="items.php"><?php echo countItem('Item_ID', 'items'); ?> </a></span>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='stat st-comments'>
                            Total Comments
                            <span>1100</span>
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
                                <i class='fa fa-users'></i> Latest <?php echo $lastestUsers; ?> Registered Users
                            </div>
                            <div class='panel-body'>
                                <ul class="list-unstyled lastest-users">
                                <?php
                                    foreach ($lastest as $user) { 
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
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-6'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                <i class='fa fa-tag'></i> Latest Items
                            </div>
                            <div class='panel-body'>
                                Test
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