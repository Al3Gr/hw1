<?php 

    include_once 'dbconfig.php';

    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit;
    }
    else {
        $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());
        $query = "SELECT name, lastname, email FROM users WHERE username='".$_SESSION["username"]."'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $name = $row["name"];
            $lastname = $row["lastname"];
            $email = $row["email"];
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Explorer</title>
        <link rel="stylesheet" href="./styles/explorer_style.css">
        <link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="./scripts/explorer_script.js" defer></script>
    </head>
    <body>
        <header>
            <div id="brand">
                <img src="./images/kiwi.jpg">
                <p>KIWI</p>
            </div>
            <nav>
                <a href="homepage.php">Homepage</a>
                <a id="selected" href="explorer.php">Explorer</a>
            </nav>
            <div id="profile" data-username=<?php echo $_SESSION["username"]; ?>>
                <div>
                    <?php
                        echo $name[0].$lastname[0];
                    ?>
                </div>
                <p> 
                    <?php 
                        echo $name." ".$lastname;
                    ?>
                </p>
            </div>
            <div id="profile_info" class="hidden">
            <div>
                <h1>
                    <?php
                        echo $name[0].$lastname[0];
                    ?>
                </h1>
                <h2>
                    <?php 
                        echo $_SESSION["username"];
                    ?>
                </h2>
                <h3><?php echo $email?></h3>
                <a href="logout.php">Disconnettiti</a>
            </div>
        </header>
        <div id="activity_container">
            <div id="info_section">
                <h1 id="momentOfDay"></h1>
                <div id="weather_info">
                    <img></img>
                    <div>
                        <h2></h2>
                        <p></p>
                    </div>
                </div>
            </div>
            <hr>
            <div id="activity_section">
                <h4>Alessandro Giuseppe Gravagno <br>1000002130</h4>
            </div>
        </div>
        <article>
            
        </article>
    </body>
</html>