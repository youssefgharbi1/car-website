<?php
    session_start();
    if (!isset($_SESSION["username"])){
        header("location: login.php");
        exit();
    }
    if (isset($_POST["log_out"])){
        session_destroy();
        header("location: login.php");
        exit();
    }
    echo "<h2 id='welcome-message'>Welcome, {$_SESSION["username"]}<h2>" ;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <?php

    include("form.html");

    $querry = "SELECT * FROM vehicule WHERE email = '{$_SESSION['email']}'";
    include("database.php");
    $result = mysqli_query($db_conn,$querry);
    if ($result && mysqli_num_rows($result) != 0){
        echo "<div class='container' id = 'vehicule-container'>";
        while($row = mysqli_fetch_assoc($result)){
            
            echo "<div class='vehicule'>";
            echo "<img src='data:image/jpeg;base64,".base64_encode($row['imageData'])."'/>";
            echo "<p>nom: {$row['name']}</p>";
            echo "<p>immatriculation: {$row['immat']}</p>";
            echo "<p>type: {$row['type']}</p>";
            echo "<p>marque: {$row['marque']}</p>";
            echo "<p>modele: {$row['modele']}</p>";
            echo "<p>carburant: {$row['fuel']}</p>";
            echo "<p>année de fabrication: {$row['manufactureYear']}</p>";
            echo "</div>";
            
        }
        echo "</div>";
    }
    ?>
    
    <form action="home.php" method="post">
        <input type="submit" name="log_out" value="déconnexion">
    </form>

</body>
</html>


<?php
    if (isset($_POST["confirm"])){
        $name = htmlspecialchars($_POST["nom"]);
        $immat = htmlspecialchars($_POST["immat"]);
        $type = isset($_POST["type"]) ? htmlspecialchars($_POST["type"]) : "Non spécifié";
        $marque = htmlspecialchars($_POST["marque"]);
        $modele = htmlspecialchars($_POST["modele"]);
        $fuel = htmlspecialchars($_POST["carburant"]);
        $manufactureYear = htmlspecialchars($_POST["manufactureYear"]);

        include("database.php");
        

        $image = $_FILES['image']['tmp_name'];
        $imageData = addslashes(file_get_contents($image));

        $sql = "INSERT INTO vehicule (name, email, immat, type, marque, modele, fuel, manufactureYear, imageData) VALUES
         ('$name', '{$_SESSION['email']}', '$immat', '$type', '$marque', '$modele', '$fuel', '$manufactureYear','$imageData');";
    
        if ($db_conn->query($sql) === TRUE) {
            echo "véhicule uploaded to database successfully!";
        } else {
            echo "Error: " . $db_conn->error;
        }
        mysqli_close($db_conn);

    }

?>