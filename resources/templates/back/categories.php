


<div id="page-wrapper">

    <div class="container-fluid">

        
        <h1 class="page-header">
        Product Categories
        </h1>

        <div class="col-md-4">
            
            <form action="" method="post">
            
            <?php add_category(); ?>
                <div class="form-group">
                <h2 class="bg-success"><?php display_message(); ?></h2>
                    <label for="category-title">Title </label>
                    <input type="text" class="form-control" name="newcategory">
                </div>

                <div class="form-group">
                    
                    <input name="add_category" type="submit" class="btn btn-primary" value="Add Category">
                </div>      


            </form>

</div>


<div class="col-md-8">

    <table class="table">
            <thead>

                <tr>
                    <th>id</th>
                    <th>Title</th>
                </tr>
            </thead>
                 <?php   get_categories_in_category_page(); ?>

     </table>

</div>



                













            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  