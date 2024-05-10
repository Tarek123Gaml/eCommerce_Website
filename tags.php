<?php

session_start();
$pageTitle = "Show Tags";

include 'init.php';

?>
<div class="container">
    <?php $tag = $_GET['name']; ?> 
    <h1 class="text-center">Tag : <?php echo $tag ?></h1>
    <div class="rwo">
    <?php 
        $tags = getAll('*', 'items', "WHERE tags like '%$tag%' AND Approve = 1", 'Item_ID');
        foreach( $tags as $item){?>
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