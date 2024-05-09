<?php

    session_start();
    $pageTitle = "HomePage";

    include 'init.php';
?>
<div class="container">
    <div class="rwo">
    <?php 
        foreach( getAll('items', 'Item_ID') as $item){?>
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail item-box">
                    <span class="price-tag"><?php echo $item['Price'] ?></span>
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
<?php
    include $tpl . 'footer.php';
?> 