<?php 

    include_once 'dbconfig.php';

    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());

    $post_id = mysqli_real_escape_string($conn, $_GET["id"]);
    $user = mysqli_real_escape_string($conn, $_GET["user"]);
    
    $query = "DELETE FROM likes_for_posts WHERE post_id=$post_id AND user='$user'";

    if(mysqli_query($conn, $query)){
        $query_1 = "SELECT num_likes FROM posts WHERE id=$post_id";
        $res = mysqli_query($conn, $query_1);

        if(mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            $js = [
                'post_id' => $post_id,
                'num_likes' => $row["num_likes"]
            ];
            echo json_encode($js);
        }
    }

    mysqli_close($conn);