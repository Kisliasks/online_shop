<?php require_once("../resources/config.php");  ?>

<?php include("../resources/templates/front/header.php");  ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header>
        <h1>Shop</h1>
       </header>

        <hr>

        <!-- Title -->
       
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">
<?php 

// $query = "SELECT * FROM products, products_2 WHERE product_category_id = 1";
// $query_products = query($query);
// while($row = mysqli_fetch_assoc($query_products)) {


        $query = "SELECT * FROM products";
  $query_products = query($query);
  while($row = mysqli_fetch_assoc($query_products)){

?>
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img style="height: 85px;" src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
                    <div class="caption">
                        <h3><?php echo $row['product_title']; ?></h3>
                        <p><?php echo $row['product_description']?></p>
                        <p>
                            <a href="../resources/cart.php?add=<?php echo $row['product_id']?>" class="btn btn-primary">Buy Now!</a> <a href="item.php?id=<?php echo $row['product_id']; ?>" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

           
        <?php } ?>

        </div>
        <!-- /.row -->


    </div>
    <!-- /.container -->

   

<?php include("../resources/templates/front/footer.php");  ?>