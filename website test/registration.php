<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="registration.php" method="post">
        <h3>registration form:</h3>
        <label for="">Username:</label><br>
        <input type="text" name="username"><br>
        <label for="">e-mail:</label><br>
        <input type="email" name="email"><br>
        <label for="">Password:</label><br>
        <input type="password" name="password"><br>
        <input type="submit" name="submition" value="register">
    </form>
    <a href="login.php">Log in ?</a>
</body>
</html>
<?php
    if (isset($_POST["submition"])){
        if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"])){
            include("database.php");
            
            $username = $_POST["username"];
            $password = $_POST["password"];
            $email =  $_POST["email"];

            $sql ="insert into users (username,password,email) values ('{$username}','{$password}','{$email}')";
            try{
                mysqli_query($db_conn,$sql);
            }
            catch(mysqli_sql_exception){
                echo 'invalide input';
            }
            $_SESSION["username"]=$username;
            $_SESSION["password"]=$password;
            $_SESSION["email"]=  $email;
            mysqli_close($db_conn);
            session_start();
            header("Location: home.php");

        }
        else{
            echo 'you must enter all required regestration data';
        }
    
    }
?>