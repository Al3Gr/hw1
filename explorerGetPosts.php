<?php 

include_once 'dbconfig.php';

$conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());

$query = "SELECT * FROM posts LIMIT 20";

$user = mysqli_real_escape_string($conn, $_GET["q"]);


$jsonPosts = array();

$res = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($res)) {
    $jsonPosts[]=$row;
}

for ($i=0; $i < count($jsonPosts); $i++) { 
    $query_1 = "SELECT * FROM likes_for_posts WHERE user='$user' AND post_id=".$jsonPosts[$i]["id"]."";
    $res1 = mysqli_query($conn, $query_1);
    $row = mysqli_fetch_assoc($res1);
    if($row){
        $jsonPosts[$i]["ok"] = true;
    } else {
        $jsonPosts[$i]["ok"] = false;
    }
}



echo json_encode($jsonPosts);
mysqli_free_result($res);
mysqli_close($conn);


?>