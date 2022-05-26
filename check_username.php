<?php 

    include_once 'dbconfig.php';

    if (!isset($_GET["q"])) {
        echo "Vai via";
        exit;
    }
    

    $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());

    $username = mysqli_real_escape_string($conn, $_GET["q"]);

    $query = "SELECT username FROM users WHERE username = '".$username."'";

    $res = mysqli_query($conn, $query);
    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));
    mysqli_close($conn);

?>