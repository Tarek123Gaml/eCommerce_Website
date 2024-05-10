<?php

session_start();
$pageTitle = "Show Category";

include 'init.php';

?>
<div class="container">
    <h1 class="text-center">Show Category Items</h1>
    <div class="rwo">
    <?php 
        foreach( getAll('*', 'items', 'WHERE Approve = 1 AND Cat_ID = ' . $_GET['pageid'], 'Item_ID')as $item){?>
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail item-box">
                    <span class="price-tag">$<?php echo $item['Price'] ?></span>
                    <img class="img-responsive img-thumbnail center-block" src="img.png" alt="">
                    <div class="caption">
                    <h3><a href='items.php?itemid=<?php echo $item['Item_ID']?>'><?php echo $item['Name'] ?></a></h3>
                        <p><?php echo $item['Description'] ?></p>
                        <p class="date"><?php echo $item['Add_Date'] ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include $tpl . 'footer.php'; ?> 