<?php require_once("../../config.php");

if(isset($_GET['id'])) {

$query = "DELETE FROM products WHERE product_id = " . escape_string($_GET['id']) . " ";
$query_product_connect = query($query);

set_message("Product Deleted");
redirect("../../../public/admin/index.php?products");

} else {

    redirect("../../../public/admin/index.php?products");

}

