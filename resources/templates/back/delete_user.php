<?php require_once("../../config.php");

if(isset($_GET['id'])) {

$query = "DELETE FROM users WHERE user_id = " . escape_string($_GET['id']) . " ";
$query_users_connect = query($query);

set_message("User Deleted");
redirect("../../../public/admin/index.php?users");

} else {

    redirect("../../../public/admin/index.php?users");

}

