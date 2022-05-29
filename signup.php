<?php 
    include_once 'dbconfig.php';

    session_start();
    if(isset($_SESSION["username"])){
        header("Location: homepage.php");
        exit;
    }

    if(isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"])){

        $error = array();

        $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die("Errore: ".mysqli_connect_error());
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
        $email = mysqli_real_escape_string($conn, strtolower($_POST["email"]));
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);


        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $username)) {
            $error[] = "Username non valido";
        } else {
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }

        if(strlen($password) < 8) {
            $error[] = "Password troppo corta";
        }

        if(strlen($name) == 0) {
            $error[] = "Nome non valido";
        }

        if(strlen($lastname) == 0) {
            $error[] = "Cognome non valido";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }

        if(count($error) == 0) {
            $query = "INSERT INTO users(name, lastname, email, username, password) VALUES('$name', '$lastname', '$email', '$username', '$password')";
            if(mysqli_query($conn, $query)) {
                header("Location: login.php");
            } else {
                $error[] = "Errore di connessione al server";
            }
        }

        
    }
?>
<html>
    <head>
        <title>SignUp</title>
        <link rel="stylesheet" href="./styles/signup_style.css">
        <link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
        <script src="./scripts/signup_script.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <article>
            <main>
                <section id="logo_section">
                    <img src="./images/kiwi.jpg">
                    <h2>New Kiwi?</h2>
                </section>
                <form method="post" name="signup_form" autocomplete="off">
                    <h1>Inserisci i tuoi dati</h1>
                    <div class="row">
                        <input type="text" name="name" placeholder="Nome">
                        <input type="text" name="lastname" placeholder="Cognome">
                    </div>
                    <div class="row">
                        <input type="text" name="email" placeholder="Email">
                    </div>
                    <div class="row">
                        <input type="text" name="username" placeholder="Username">
                        <input type="password" name="password" placeholder="Password">
                    </div>
                    <div class="row">
                        <a id="back_button" href="login.php">Annulla</a>
                        <input id="login_button" type="submit" value="Registrati">
                    </div>
                </form>
            </main>
        </article>
    </body>
</html>