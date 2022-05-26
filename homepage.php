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
        <title>Homepage</title>
        <link rel="stylesheet" href="./styles/homepage_style.css">
        <link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="./scripts/homepage_script.js" defer></script>
    </head>
    <body>
        <header>
            <div id="brand">
                <img src="./images/kiwi.jpg">
                <p>KIWI</p>
            </div>
            <nav>
                <a id="selected" href="homepage.php">Homepage</a>
                <a href="explorer.php">Explorer</a>
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
        </header>
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
                <h3><?php echo $email ?></h3>
                <a href="logout.php">Disconnettiti</a>
            </div>
        </div>
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
        <div id="create_post_button">
            <span class="material-icons">edit</span>
            <p>POST</p>
        </div>
        <div class="overlay hidden" id="add_post">
            <form class="post_form" method="post" name="post_form" action="createPost.php">
                <input class="title_post" type="text" name="title" placeholder="Titolo">
                <input type="hidden" name="username" value=<?php echo $_SESSION["username"]?>>
                <textarea name="comment" class="comment_post" maxlength="500" placeholder="Comment"></textarea>
                <div>
                    <span class="delete_post">Annulla</span>
                    <button class="publish_post">Pubblica</button>
                </div>
            </form>
        </div>
        <div class="overlay hidden" id="modify_post">
            <form class="post_form" method="post" name="modify_form" action="modifyPost.php">
                <input class="title_post" type="text" name="title" placeholder="Titolo">
                <input type="hidden" name="id" id="post_id">
                <textarea name="comment" class="comment_post" maxlength="500" placeholder="Comment"></textarea>
                <div>
                    <span class="delete_post">Annulla</span>
                    <button class="publish_post">Modifica</button>
                </div>
            </form>
        </div>
    </body>
</html>