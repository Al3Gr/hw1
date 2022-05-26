<?php 

include_once 'dbconfig.php';

$conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());

$post_id = mysqli_real_escape_string($conn, $_GET["q"]);

$query = "SELECT user, comment FROM comments_for_posts WHERE post_id = $post_id";

$comments = array();
$res = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($res)){
    $comments[] = $row;
}

$js = [
    'post_id' => $post_id,
    'comments' => $comments
];

echo json_encode($js);

mysqli_free_result($res);
mysqli_close($conn);

?>