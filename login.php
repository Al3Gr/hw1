<?php

    include_once 'dbconfig.php';

    session_start();
    if(isset($_SESSION["username"])){
        header("Location: homepage.php");
        exit;
    }

    if(isset($_POST["username"]) && isset($_POST["password"])){
        $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $query = "SELECT username, password FROM users WHERE username = '".$username."' AND password = '".$password."'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res) > 0){
            $_SESSION["username"] = $_POST["username"];
            header("Location: homepage.php");
            exit;
        } else {
            $errore = true;
        }
    }
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="./styles/login_style.css">
        <link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
        <script src="./scripts/login_script.js" defer></script>
    </head>
    <body>
        <article>
            <main>
                <div id="title">
                    <img src="./images/kiwi.jpg" id="logo">
                    <h1>Login</h1>
                </div>
                <form name="login_form" method="post">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <?php 
                        if(isset($errore)){
                            echo "<p class='errore'>Credenziali non valide</p>";
                        }
                    ?>
                    <input id="login_button" type="submit" value="Accedi" >
                </form>
                <p>Non sei registrato? <a href="signup.php">Registrati</a></p>
            </main>
        </article>
    </body>
</html>