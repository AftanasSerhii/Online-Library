<?php 

    include("include/menu_handler.php");
    include("include/conect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="imege/x-icon" href="imeges/Icon/icon2.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include("include/menu.php"); ?>
    <script src="js/script.js"></script>

    <div class="registration-form">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username">
            <br>
            <br>
            <label for="birthday">Birthday:</label>
            <input type="date" name="birthday">
            <br>
            <br>
            <label for="email">Email:</label>
            <input type="text" name="email">
            <br>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password">
            <br>
            <br>
            <input  class="registration-button" type="submit" value="Реєстрація">
        </form>

        <div id="error-alert" class="error-alert hidden">
            <p></p>
        </div>

    </div>

</body>
</html>


<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $birthday = filter_input(INPUT_POST, "birthday", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(empty($username)){
        echo "<script type=\"text/javascript\"> showError('Введіть ім\'я');</script>";
    }
    elseif(empty($birthday)){
        echo "<script type=\"text/javascript\"> showError('Введіть дату народження');</script>";
    }
    elseif(empty($email)){
        echo "<script type=\"text/javascript\"> showError('Введіть Email');</script>";
    }
    elseif(empty($password)){
        echo "<script type=\"text/javascript\"> showError('Введіть пароль');</script>";
    }elseif(!preg_match("^[A-Za-z\d]{5,10}$^", $username)){
        echo "<script type=\"text/javascript\"> showError('Ім'я не відповідає вимогам');</script>";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<script type=\"text/javascript\"> showError('Недійсний формат електронної пошти');</script>";
    }
    elseif(!preg_match("^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,8}$^", $password)){
        echo "<script type=\"text/javascript\"> showError('Пароль не підходить');</script>";
    }
    else{

        $hash = password_hash($password, PASSWORD_DEFAULT); 
        $sql = "INSERT INTO users (username, birthday, email, password) 
        VALUES ('$username','$birthday','$email','$hash')";
        if(mysqli_query($conn, $sql)){
            $query = "SELECT username FROM users WHERE email = '$email' and password = '$hash'";
            $username = mysqli_fetch_assoc(mysqli_query($conn, $query));

            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username['username'];

            header("Location: user_page.php");
        }
        else{
            echo "<script type=\"text/javascript\"> showError('Пароль не підходить');</script>";
        }
        
    }
}

if($_POST['log_out']){
    mysqli_close($conn);
    header("Location: index.php");
}

mysqli_close($conn);

?>
