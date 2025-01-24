<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="login.php" method="post">
        <label for="">e-mail:</label><br>
        <input type="email" name="email"><br>
        <label for="">Password:</label><br>
        <input type="password" name="password"><br>
        <input type="submit" name="submit" value="log in">
    </form>
    <a href="registration.php">Create new account ?</a>
</body>
</html>

<?php
    if (isset($_POST["submit"])){
        if (!empty($_POST["password"]) && !empty($_POST["email"])){
            include("database.php");
            $password = $_POST["password"];
            $email =  $_POST["email"];
            $sql ="select * from users where email = '{$email}' and password = '{$password}'; ";
            $result = mysqli_query($db_conn,$sql);
            if ($result && mysqli_num_rows($result) != 0){
                $rows = mysqli_fetch_assoc($result);
                $_SESSION["username"] = $rows["username"] ;
                $_SESSION["password"]=  $password;
                $_SESSION["email"] =  $email;
                header("location: home.php");
            }
            else{
                echo "invalide login";
            }
            

        }
        else{
            echo 'you must enter all required login data';
        }
    
    }
    
?>
