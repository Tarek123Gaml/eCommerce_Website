<?php

    session_start();
    $pageTitle = "Creat New Item";

    include 'init.php';

    if (isset($_SESSION['user'])) {

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $FormErrors     = array();

        $name           = htmlspecialchars(strip_tags($_POST['name']));
        $description    = htmlspecialchars(strip_tags($_POST['description']));
        $price          = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $country        = htmlspecialchars(strip_tags($_POST['country']));
        $status         = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $category       = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $tags           = htmlspecialchars(strip_tags($_POST['tags']));

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
        if (empty($status)){
            $FormErrors[] = "You Must Select Status";
        }
        if (empty($category)){
            $FormErrors[] = "You Must Select Sategory";
        }

    
        // proceed the insert operation if there's no any errors

        if (empty($FormErrors)){

                
                $stmt = $con->prepare("INSERT INTO items (Name, Description, Price, Status, Country_Made, Cat_ID, Tags, Member_ID, Add_Date)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, now())");

                $stmt->execute(array($name, $description, $price, $status, $country, $category, $tags, $_SESSION['uid']));

                if($stmt){
                // echo seccess massege
                $succesMsg = 'Item Added';

                }
        }

    }

?>
<h1 class='text-center'><?php echo $pageTitle ?></h1>

<div class="creat-ad block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?php echo $pageTitle ?>
            </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form class='form-horizontal main-form' action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
                                <!-- start name field -->
                                <div class='form-group form-group-lg'>
                                    <label class='col-sm-3 control-label'>Name</label>
                                    <div class='col-sm-10 col-md-9'>
                                        <input pattern=".{4,}" Title="This Field Require At Least 4 Characters" 
                                        type="text" name='name' class='form-control live'
                                        placeholder="Name Of The Item" data-class=".live-title" required>
                                    </div>
                                </div>
                                <!-- end name field -->
                                <!-- start Description field -->
                                <div class='form-group form-group-lg'>
                                    <label class='col-sm-3 control-label'>Description</label>
                                    <div class='col-sm-10 col-md-9'>
                                        <input pattern=".{10,}" Title="This Field Require At Least 10 Characters"
                                        type="text" name='description' class='form-control live'
                                         placeholder="Description Of The Item" data-class=".live-desc" required>
                                    </div>
                                </div>
                                <!-- end Description field -->
                                <!-- start Price field -->
                                <div class='form-group form-group-lg'>
                                    <label class='col-sm-3 control-label'>Price</label>
                                    <div class='col-sm-10 col-md-9'>
                                        <input type="text" name='price' class='form-control live'
                                        placeholder="Price Of The Item" data-class=".live-price" required >
                                    </div>
                                </div>
                                <!-- end Price field -->
                                <!-- start Country field -->
                                <div class='form-group form-group-lg'>
                                    <label class='col-sm-3 control-label'>Country</label>
                                    <div class='col-sm-10 col-md-9'>
                                        <input type="text" name="country" class="form-control"
                                        placeholder="Country Of The Item" required>
                                    </div>
                                </div>
                                <!-- end Country field -->
                                <!-- start Status field -->
                                <div class='form-group form-group-lg'>
                                    <label class='col-sm-3 control-label'>Status</label>
                                    <div class='col-sm-10 col-md-9'>
                                        <select name="status" required>
                                            <option value="">...</option>
                                            <option value="1">New</option>
                                            <option value="2">Like New</option>
                                            <option value="3">Used</option>
                                            <option value="4">Old</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end Status field -->
                                <!-- start category field -->
                                <div class='form-group form-group-lg'>
                                    <label class='col-sm-3 control-label'>Category</label>
                                    <div class='col-sm-10 col-md-9'>
                                        <select name="category" required>
                                            <option value="">...</option>
                                            <?php
                                                $category = getAll('*', 'categories', 'WHERE parent = 0', 'ID', 'DESC');
                                                foreach($category as $cat){
                                                    echo '<option value="' . $cat['ID'] . '">' . $cat['Name'] . '</option>';
                                                    $childs = getAll('*', 'categories', 'WHERE parent =' . $cat['ID'], 'ID', 'DESC');
                                                        foreach($childs as $c){
                                                            echo '<option value="' . $c['ID'] . '">--- ' . $cat['Name'] . '/' . $c['Name'] . '</option>';
                                                        }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- end category field -->
                                <!-- start Tags field -->
                                <div class='form-group form-group-lg'>
                                    <label class='col-sm-3 control-label'>Tags</label>
                                    <div class='col-sm-10 col-md-9'>
                                        <input type="text" name="tags" class="form-control"
                                        placeholder="Separate Tags With Comma (,)">
                                    </div>
                                </div>
                                <!-- end Tags field -->
                                <!-- start submit field -->
                                <div class='form-group'>
                                    <div class='col-sm-offset-3 col-sm-9'>
                                        <input type="submit" value='Add Item' class='btn btn-primary btn-sm' />
                                    </div>
                                </div>
                                <!-- end submit field -->
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail item-box live-preview">
                                <span class="price-tag">$<span class="live-price"></span></span>
                                <img class="img-responsive" src="img.png" alt="">
                                <div class="caption">
                                    <h3 class="live-title"> Title </h3>
                                    <p class="live-desc"> Description </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if(! empty($FormErrors)){
                        foreach($FormErrors as $error){
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                    }
                    if (isset($succesMsg)) {

                        echo '<div class="alert alert-success">' . $succesMsg . '</div>';
        
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