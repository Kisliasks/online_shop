
        <div id="page-wrapper">

            <div class="container-fluid">

              <div class="col-lg-12">
                      
                        <h1 class="page-header">
                            Users                       
                        </h1>
                          <p class="bg-success">                          
                            <?php  display_message();?>
                        </p>

                        <a href="index.php?add_user" class="btn btn-primary">Add User</a>

                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  show_users_in_admin();?>
                                                               
                                </tbody>
                            </table> <!--End of Table-->
                        

                        </div>                       
                    </div>
    
