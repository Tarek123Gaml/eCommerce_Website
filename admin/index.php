<?php
    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';
    
    if(isset($_SESSION['Username'])) {
        header('Location: dashboard.php'); // redirect to dashboar page
    }
    include 'init.php';

    // check if user coming from HTTP post request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);

        // check if user exist in databade
        $stmt = $con->prepare("SELECT
                                    UserID, Username, Password 
                                FROM 
                                    users
                                WHERE
                                    Username = ? 
                                AND 
                                    Password = ? 
                                AND
                                    GroupID = 1
                                LIMIT 1");

        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        // if count > 0 this main data contain the user
        if ($count > 0) {
           $_SESSION['Username'] = $username; // register session name
           $_SESSION['ID'] = $row['UserID']; // register session ID
           header('Location: dashboard.php'); // redirect to dashboar page
           exit();
        }
    }
?>

    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <h4 class="text-center"> Admin Login</h4>
        <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
        <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
        <input class="btn btn-primary btn-block" type="submit" value="login" />
    </form>

<?php include $tpl . 'footer.php'; ?> 