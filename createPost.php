<?php 

include_once 'dbconfig.php';

if(isset($_POST["title"]) && isset($_POST["comment"])){
    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $publish_date = date("Y-m-d");
    $query = "INSERT INTO posts(title, content, username, num_likes, num_comments, publish_date) VALUES('$title', '$comment', '$username', 0, 0, '$publish_date')";


    if(mysqli_query($conn, $query)) {
        header("Location: homepage.php");
    }

    mysqli_close($conn);
}


?>