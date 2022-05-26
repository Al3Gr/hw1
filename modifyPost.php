<?php 

    include_once 'dbconfig.php';

    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());

    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
    $post_id = mysqli_real_escape_string($conn, $_POST["id"]);

    $query = "UPDATE posts SET title='$title', content='$comment' WHERE id = $post_id";

    if(mysqli_query($conn, $query)){
        header("Location: homepage.php");
    }
    mysqli_close($conn);

?>