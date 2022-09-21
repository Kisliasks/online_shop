<?php require_once("../resources/config.php");  ?>

<?php include("../resources/templates/front/header.php");  ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

        <!-- Categories --> 
        
<?php include("../resources/templates/front/side_nav.php");  ?>
        
            </div>

            <div class="col-md-9">
               
                <div class="row carousel-holder">

                    <div class="col-md-12">
                    
                    <!-- Carousel -->  
                    <?php include("../resources/templates/front/slider.php");  ?>


                    </div>

                </div>

                <div class="row">
<?php
// Отдел пагинации
                $query = "SELECT * FROM products";
                $query_products = query($query);

                $rows = mysqli_num_rows($query_products);

                if(isset($_GET['page'])) {
                    $page = preg_replace('#[^0-9]#', '', '$_GET["page"]');


                } else {
                    $page = 1;
                }

                $perPage = 6;

                $lastPage = ceil($rows / $perPage);

                if($page < 1) {

                    $page = 1;
                } elseif($page > $lastPage) {

                    $page = $lastPage;
                }

                $middleNumbers = '';

                $sub1 = $page - 1;
                $sub2 = $page - 2;
                $add1 = $page + 1;
                $add2 = $page + 2;

                if($page == 1) {


                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a>' .$page. '</a></li>';

                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">'.$add1.'</a></li>';

                    // echo "<ul class='pagination'>$middleNumbers</ul>";
                } elseif ($page == $lastPage) {

                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">'.$sub1.'</a></li>';
                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a>' .$page. '</a></li>';


                } elseif($page > 2 && $page < ($lastPage - 1)) {

                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub2.'">'.$sub2.'</a></li>';
                    
                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">'.$sub1.'</a></li>';

                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a>' .$page. '</a></li>';

                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">'.$add1.'</a></li>';

                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'">'.$add2.'</a></li>';

                    // echo "<ul class='pagination'>{$middleNumber}</ul>";

                } elseif($page > 1 && $page < $lastPage) {
                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">'.$sub1.'</a></li>';

                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a>' .$page. '</a></li>';

                    $middleNumbers .= '<li class="page-item active" aria-current="page"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">'.$add1.'</a></li>';

                    echo "<ul class='pagination'>{$middleNumber}</ul>";

                }
                


                while($row = mysqli_fetch_assoc($query_products)){

                    $product_id = $row['product_id'];
                    $product_title = $row['product_title'];
                    $product_category_id = $row['product_category_id'];
                    $product_price = $row['product_price'];
                    $product_descrition = $row['product_description'];
                    $product_image = $row['product_image'];

                   
                    $show_image = display_image($product_image);
?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img style="height: 85px;" src="../resources/<?php echo $show_image; ?>" alt="">
                            <div class="caption">
                                <h4 class="pull-right"><?php echo "$".$product_price; ?></h4>
                                <h4><a href="item.php?id=<?php echo $product_id; ?>"><?php echo $product_title; ?></a>
                                </h4>
                                <p><?php echo $product_descrition; ?><a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                            </div>
                            <div class="ratings">
                               
                                <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add=<?php echo $product_id; ?>">Add to cart</a>
                            </div>
                        </div>
                    </div>




<?php } ?>
                  
           
<!-- 
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <h4><a href="#">Like this template?</a>
                        </h4>
                        <p>If you like this template, then check out <a target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">this tutorial</a> on how to build a working review system for your online store!</p>
                        <a class="btn btn-primary" target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">View Tutorial</a>
                    </div>  -->

                </div>  <!-- ROW ends here -->

            </div>

        </div>

    </div>
    <!-- /.container -->

<?php include("../resources/templates/front/footer.php");  ?>
   