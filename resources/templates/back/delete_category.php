<?php require_once("../../config.php");

if(isset($_GET['id'])) {

$query = "DELETE FROM categories WHERE cat_id = " . escape_string($_GET['id']) . " ";
$query_product_connect = query($query);

set_message("Category Deleted");
redirect("../../../public/admin/index.php?categories");

} else {

    redirect("../../../public/admin/index.php?categories");

}

