<?php require_once("../resources/config.php");  ?>



<?php 


if(isset($_GET['add'])) {

    $query = "SELECT * FROM products WHERE product_id= " . escape_string($_GET['add']) . " ";
    $query_prod_connect = query($query);

    while($row = mysqli_fetch_array($query_prod_connect)) {
        if($row['product_quantity'] != $_SESSION['product_'.$_GET['add']]) {

            $_SESSION['product_'.$_GET['add']] += 1;
            
            redirect("../public/checkout.php");
        } else {
            set_message("We only have ". $row['product_quantity']." ".$row['product_title']." Available");
            redirect("../public/checkout.php");

        }
    }   
}

if(isset($_GET['remove'])) {

    $_SESSION['product_' . $_GET['remove']]--;

    if( $_SESSION['product_' . $_GET['remove']] < 1) {

        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("../public/checkout.php");
    } else {

        redirect("../public/checkout.php");
    }

}

if(isset($_GET['delete'])) {

    $_SESSION['product_'.$_GET['delete']] = 0;
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
    redirect("../public/checkout.php");
}

function cart() {

$total = 0;    
$item_quantity = 0;

  foreach ($_SESSION as $name => $value) {

    if($value > 0) {

        if(substr($name, 0, 8) == "product_") {

            $length = (strlen($name) - 8);
            $id = substr($name, 8, $length);

            $query = "SELECT * FROM products WHERE product_id = " . escape_string($id) . " ";
            $query_result = query($query);
            if(!$query_result) {
                die("FAILED");
            }
        while($row = mysqli_fetch_array($query_result)) {
        
            $sub = $row['product_price']*$value;
            
            $item_quantity += $value;
            $product_image = display_image($row['product_image']);

        $product = <<<DELIMETER
        <tr>
        <td>{$row['product_title']}<br>
        
        <img width = '30px' src="../resources/$product_image">
        
        </td>
        <td>\${$row['product_price']}</td>
        <td>{$value}</td>
        <td>\${$sub}</td>
        <td><a href="../resources/cart.php?add={$row['product_id']}">Add</a></td>
        <td><a href="../resources/cart.php?remove={$row['product_id']}">Remove</a></td>
        <td><a href="../resources/cart.php?delete={$row['product_id']}">Delete</a></td>
        </tr>
        
        
        DELIMETER;
        
        echo $product; 

        }

        $_SESSION['item_total'] = $total += $sub;
        $_SESSION['item_quantity'] = $item_quantity;
        }  
    }
       
  }
  
}


?>