<?php 
    include_once 'dbconfig.php';

    if(isset($_POST["comment"]) && isset($_POST["post_id"]) && isset($_POST["user"])){
        $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());

        $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
        $post_id = mysqli_real_escape_string($conn, $_POST["post_id"]);
        $user = mysqli_real_escape_string($conn, $_POST["user"]);


        $query = "INSERT INTO comments_for_posts VALUES('$user', $post_id, '$comment')";
        
        if(mysqli_query($conn, $query)){
            header("Location: $_SERVER[HTTP_REFERER]");
            exit;
        }
        mysqli_close($conn);
    }
?>