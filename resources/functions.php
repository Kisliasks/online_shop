<?php 

function redirect($location) {       // это функция перенаправления 

    header("Location: $location ");
}

function query($sql) {  // эта функция заменят целую стркоу кода, где я делаю соединение с таблицей 

    global $connection;
    return mysqli_query($connection, $sql);

}

function escape_string($string) {   // функция против иньекций 
global $connection;

return mysqli_real_escape_string($connection, $string);
}



function get_categories() {


    $query = "SELECT * FROM categories";
    $connection_query = query($query);
    if(!$connection_query) {
        die('FATAL ERROR');
    }
    while($row = mysqli_fetch_assoc($connection_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<a href='category.php?id={$cat_id}' class='list-group-item'>$cat_title</a>";

    } 
}




function get_products() {

    global $connection;
    $query = "SELECT * FROM products";
    $query_products = query($query);
    while($row = mysqli_fetch_assoc($query_products)){

        $product_id = $row['product_id'];
        $product_title = $row['product_title'];
        $product_category_id = $row['product_category_id'];
        $product_price = $row['product_price'];
        $product_descrition = $row['product_description'];
        $product_image = $row['product_image'];

    }
}

function login_user() {

    if(isset($_POST['submit'])) {
       $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);
        
        $query = "SELECT * FROM users WHERE username = '{$username}' AND user_password = '{$password}' ";
        $query_connection_user = query($query);

        if(mysqli_num_rows($query_connection_user) == 0) {

            set_message("Your Password or Login are wrong");
            redirect("login.php");

        } else {

            $_SESSION['username'] = $username;
           
            redirect("admin");
        }
    }
}


function set_message($msg) {
if(!empty($msg)) {

    $_SESSION['message'] = $msg;
} else {

    $msg = "";
}

}

function display_message() {

    if(isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function send_message() {

    if(isset($_POST['submit'])) {

      $to = "someEmailaddress@gmail.com";
      $from_name = $_POST['name'];
      $subject = $_POST['subject'];
      $email = $_POST['email'];
      $message = $_POST['message'];

      $headers = "From:  {$from_name} {$email}";

      
      $result = mail($to, $subject, $message, $headers);
      if(!$result) {

        echo "ERROR";
      } else {
          echo "SEND";
      }

    }

}






/*********************************  ADMIN PRODUCTS ********************     */

function display_image($picture) {

    $upload_directory = "uploads";
    return $upload_directory . DS . $picture;

}



function get_products_in_admin() {

    global $connection;
    $query = "SELECT * FROM products";
    $query_products = query($query);
    while($row = mysqli_fetch_array($query_products)){
        $product_category_id = $row['product_category_id'];
      $category_name = show_product_category_title($product_category_id);

echo  <<<DELIMETER

    <tr>
        <td>{$row['product_id']}</td>
        <td>{$row['product_title']}<br>
        <a href="index.php?edit_product&id={$row['product_id']}"><img src="../../resources/uploads/{$row['product_image']}" style="height: 30px" alt=""></a>
        </td>
        <td>$category_name</td>
        <td>\${$row['product_price']}</td>
        <td>{$row['product_quantity']}</td>
        <td><a href="../../resources/templates/back/delete_products.php?id={$row['product_id']}">Delete</a></td>
        
    </tr>

DELIMETER; 




    }


}



/***********************************Add Products in admin *************** */

function add_product() {

if(isset($_POST['publish'])) {

$product_title       = escape_string($_POST['product_title']);
$product_category_id = escape_string($_POST['product_category_id']);
$product_price       = escape_string($_POST['product_price']);
$product_description  = escape_string($_POST['product_description']);
$short_desc          = escape_string($_POST['short_desc']);
$product_quantity    = escape_string($_POST['product_quantity']);
$product_image       = escape_string($_FILES['file']['name']);
$image_temp_location = escape_string($_FILES['file']['tmp_name']);

move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

$query = "INSERT INTO products(product_title, product_category_id, product_price, product_description, short_desc, product_quantity, product_image) VALUES ('$product_title', '$product_category_id', '$product_price', '$product_description', '$short_desc', '$product_quantity', '$product_image') ";
$query_product_add = query($query);

if(!$query_product_add) {
    global $connection;
    die("Product NOT Added". mysqli_error($connection));
}

set_message("New Product Added");
redirect("index.php?products");



}

function show_categories_add_product_page() {


    $query = "SELECT * FROM categories";
    $connection_query = query($query);
    if(!$connection_query) {
        die('FATAL ERROR');
    }
    while($row = mysqli_fetch_assoc($connection_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];


        $category_option =  <<<DELIMETER
        <option value="{$row['cat_id']}">{$row['cat_title']}</option>



        DELIMETER;

        echo $category_option;
    } 
}

}




/************************************************  SHow product Category ************  */

function show_product_category_title($product_category_id) {

    $category_query = "SELECT * FROM categories WHERE cat_id = '{$product_category_id}' ";
    $result = query($category_query);
    while($row = mysqli_fetch_array($result)) {

        return $row['cat_title'];
    }
    
}


/*********************************************** Update product   ************** */

function update_product() {

    if(isset($_POST['update'])) {
    
    $product_title       = escape_string($_POST['product_title']);
    $product_category_id = escape_string($_POST['product_category_id']);
    $product_price       = escape_string($_POST['product_price']);
    $product_description  = escape_string($_POST['product_description']);
    $short_desc          = escape_string($_POST['short_desc']);
    $product_quantity    = escape_string($_POST['product_quantity']);
    $product_image       = escape_string($_FILES['file']['name']);
    $image_temp_location = escape_string($_FILES['file']['tmp_name']);
    
    if(empty($product_image)) {
        $query = "SELECT product_image FROM products WHERE product_id = " . escape_string($_GET['id']). " ";
        $get_pic = query($query); 
       
        while($row = mysqli_fetch_array($get_pic)) {
            $product_image = $row['product_image'];
        }
    }

    


    move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);
    
    $query = "UPDATE products SET ";
    $query .= "product_title = '{$product_title}', "; 
    $query .= "product_category_id = '{$product_category_id}', "; 
    $query .= "product_price = '{$product_price}', "; 
    $query .= "product_description = '{$product_description}', "; 
    $query .= "short_desc = '{$short_desc}', "; 
    $query .= "product_quantity = '{$product_quantity}', "; 
    $query .= "product_image = '{$product_image}' "; 
    $query .= "WHERE product_id =". escape_string($_GET['id']). " "; 

        $query_update = query($query);
    
    if(!$query_update) {
        global $connection;
        die("Product NOT Added". mysqli_error($connection));
    }
    
    set_message("Product has been Updated");
    redirect("index.php?products");
    
       
    }

}


function get_categories_in_category_page() {


    $query = "SELECT * FROM categories";
    $connection_query = query($query);
    if(!$connection_query) {
        die('FATAL ERROR');
    }
    while($row = mysqli_fetch_assoc($connection_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
       

   
    echo  <<<DELIMETER

<tbody>
    <tr>
        <td>$cat_id</td>
        <td>$cat_title</td>
        <td><a href="../../resources/templates/back/delete_category.php?id={$cat_id}">Delete</a></td>
    </tr>
</tbody>

DELIMETER; 


    } 
}

/******************** ADD Category ******************** */

function add_category() {

if(isset($_POST['add_category'])) {

 $new_category = escape_string($_POST['newcategory']);


 if(!empty($new_category)) {

    $query = "INSERT INTO categories(cat_title) VALUES ('$new_category') ";
$query_result = query($query);

global $connection;
if(!$query_result) {
    die("FATAL". mysqli_error($connection));
    set_message("Category is created");
}

 } else {

    set_message("Please, enter new category");
 }
}
}


/*********************************************  USERS ************************ */

function show_users_in_admin() {

    $query = "SELECT * FROM users";
    $query_users = query($query);
    while($row = mysqli_fetch_assoc($query_users)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['email'];
        $user_photo = $row['user_photo'];
        

        echo  <<<DELIMETER

                <tr>

                    <td>$user_id</td>
                    <td><img class="admin-user-thumbnail user_image" src="../../resources/uploads/{$user_photo}" width="40px" alt=""></td>
                    
                    <td>$username</td>
                                                            
                    <td>$user_firstname</td>
                    <td>$user_lastname</td>
                    <td> <a href="index.php?edit_user&id={$user_id}">Edit</a></td>
                    <td> <a href="../../resources/templates/back/delete_user.php?id={$user_id}">Delete</a></td>
                    
                </tr>
        
        DELIMETER; 
        
    }

}




function add_user() {

if(isset($_POST['add_user'])) {

$username  =  escape_string($_POST['username']);
$email     =  escape_string($_POST['email']);
$password  =  escape_string($_POST['password']);
$user_photo = escape_string($_FILES['file']['name']);
$photo_temp = escape_string($_FILES['file']['tmp_name']);


move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);


$query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_photo, email) VALUES ('{$username}', '{$password}', ' ', ' ', '{$user_photo}', '{$email}'  ) ";
$query_user_add = query($query);

if(!$query_user_add) {

global $connection;

die("FATAL". mysqli_error($connection));

} else {
    set_message("User is added");
}

}

}



/************************************************Get Slides Functions ************** */

function add_slides() {

if(isset($_POST['add_slide'])) {

$slide_title = escape_string($_POST['slide_title']);
$slide_image = escape_string($_FILES['file']['name']);
$slide_image_loc = escape_string($_FILES['file']['tmp_name']);

if(empty($slide_title) || empty($slide_image)) {

    echo "<p class='bg-danger'>This field cannot be empty</p>";
} else {

    move_uploaded_file($slide_image_loc, UPLOAD_DIRECTORY. DS . $slide_image);

    $query = "INSERT INTO slides(slide_title, slide_image) VALUES('{$slide_title}', '{$slide_image}') ";
    $query_result = query($query);
    set_message("Slide Added");
    // redirect("index.php?slides");
}

}

}



function get_current_slide_in_admin() {

    $query = "SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1";
    $query_result = query($query);

    while($row = mysqli_fetch_array($query_result)) {

        $slide_image = display_image($row['slide_image']);
        $slide_active_admin = <<<DELIMETER

           
            <img class="img-responsive" src="../../resources/{$slide_image}" alt="">
       


        DELIMETER;
        echo $slide_active_admin;
    }

}



function get_active() {

    $query = "SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1";
    $query_result = query($query);

    while($row = mysqli_fetch_array($query_result)) {

        $slide_image = display_image($row['slide_image']);
        $slide_active = <<<DELIMETER

            <div class="item active">
            <img class="slide-image" src="../resources/{$slide_image}" alt="">
        </div>


        DELIMETER;
        echo $slide_active;
    }

}



function get_slides() {

    $query = "SELECT * FROM slides";
    $query_result = query($query);

    while($row = mysqli_fetch_array($query_result)) {

        $slide_image = display_image($row['slide_image']);
        $slides = <<<DELIMETER

            <div class="item">
            <img class="slide-image" src="../resources/{$slide_image}" alt="">
        </div>


        DELIMETER;
        echo $slides;
    }
}

function get_slide_thumbnails() {

    $query = "SELECT * FROM slides ORDER BY slide_id ASC";
    $query_result = query($query);

    while($row = mysqli_fetch_array($query_result)) {
        $slide_id = $row['slide_id'];

        $slide_image = display_image($row['slide_image']);
        $slide_thumb_admin = <<<DELIMETER

            <div class="col-xs-6 col-md-3 image_container">

            <a href="../../resources/templates/back/delete_slide.php?id={$slide_id}">
            <img class="img-responsive slide_image" src="../../resources/{$slide_image}" alt="">
        
            </a>
        
            <div class="caption">
            <p>{$row['slide_title']}</p>
            </div>

        </div>
        
      


        DELIMETER;
        echo $slide_thumb_admin;

    }

}


?>