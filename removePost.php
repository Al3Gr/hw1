<?php 

    include_once 'dbconfig.php';

    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());
    $post_id = mysqli_real_escape_string($conn, $_GET["q"]);

    $query = "DELETE FROM posts WHERE id =$post_id";

    mysqli_query($conn, $query);

    mysqli_close($conn);
?>