<?php 
    include("include/config.php");
    
    include("include/menu_handler.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="icon" type="imege/x-icon" href="imeges/Icon/icon2.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include("include/menu.php"); ?>
    <script src="js/script.js"></script>
    
    <div class="registration-form content">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <label for="email">Email:</label>
            <input type="text" name="email">
            <br>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password">
            <br>
            <br>
            <input class="registration-button" type="submit" value="Увійти">
        </form>
    </div>

    <div id="error-alert" class="error-alert hidden">
        <p></p>
    </div>

    <footer class="footer">
        <p class="footer_text">Усі права захищено</p>
    </footer>

</body>
</html>


<?php 
include("include/conect.php");


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    
    


    if(empty($email)){
        echo "<script type=\"text/javascript\"> showError('Введіть Email');</script>";
    }
    elseif(empty($password)){
        echo "<script type=\"text/javascript\"> showError('Введіть пароль');</script>";
    }
    else{

        $sql = "SELECT * FROM users WHERE email = '$email'";
            
           
        if(mysqli_num_rows(mysqli_query($conn, $sql)) === 1){

            $queryPassword = "SELECT password FROM users WHERE email = '$email'";
            $passwordFormDb = mysqli_fetch_assoc(mysqli_query($conn, $queryPassword));
        
            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

            if($row['email'] === $email && password_verify($password,  $passwordFormDb['password'])){

                $query = "SELECT user_id FROM users WHERE email = '$email'";
                $user_id = mysqli_fetch_assoc(mysqli_query($conn, $query));
                
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user_id['user_id'];

                
                header("Location: user_page.php");
            }else{
                echo "<script type=\"text/javascript\"> showError('Дінні не вірні');</script>";
                exit();
            }

        }
        else{
            echo "<script type=\"text/javascript\"> showError('Дінні не вірні, спробуйте ще!');</script>";
            exit();
        }
        
    }
}

if($_POST['log_out']){
    mysqli_close($conn);
    header("Location: index.php");
}


mysqli_close($conn);

?>