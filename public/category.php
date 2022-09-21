<?php require_once("../resources/config.php");  ?>

<?php include("../resources/templates/front/header.php");  ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>A Warm Welcome!</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
            <p><a class="btn btn-primary btn-large">Call to action!</a>
            </p>
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Features</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">
<?php 


        $query = "SELECT * FROM products WHERE product_category_id =" . escape_string($_GET['id']) ." ";
  $query_products = query($query);
  while($row = mysqli_fetch_assoc($query_products)){


?>
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img style="height: 85px;" src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
                    <div class="caption">
                        <h3><?php echo $row['product_title']; ?></h3>
                        <p><?php echo $row['product_description']; ?></p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id=<?php echo $row['product_id']; ?>" class="btn btn-default">More Info</a>
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