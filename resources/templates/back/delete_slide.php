<?php require_once("../../config.php");

if(isset($_GET['id'])) {

    $query = "SELECT slide_image FROM slides WHERE slide_id = " . escape_string($_GET['id']) . " LIMIT 1 ";
    $query_find_image = query($query);

    $row = mysqli_fetch_assoc($query_find_image);
    $target_path = UPLOAD_DIRECTORY . DS . $row['slide_image'];
    unlink($target_path);


$query = "DELETE FROM slides WHERE slide_id = " . escape_string($_GET['id']) . " ";
$query_slides_connect = query($query);



set_message("Slide Deleted");
redirect("../../../public/admin/index.php?slides");

} else {

    redirect("../../../public/admin/index.php?slides");

}

