
<?php
include "../includes/db.php";
$Id=$_REQUEST['id'];
$query= mysqli_query($conn,"delete  from users  where userid='$Id'");
 

    header('location: userview.php');

?>