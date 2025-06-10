<?php 
    include("include/config.php");
    include("include/menu_handler.php");
    include("include/conect.php");

    $user_id = $_SESSION['user_id'];

    $sql = "
        SELECT 
            *
        FROM 
            users
        WHERE
            user_id = '$user_id'
    ";


    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="icon" type="imege/x-icon" href="imeges/Icon/icon2.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/script.js">
    <script src="js/script.js"></script>
</head>
<body>
    <?php include("include/menu.php"); ?>

    <div class="add-item">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
            <label for="userImage">Завантажити фото профілю:</label>
            <input type="file" name="userImage" accept="image/*">
            <label for="userName">Введіть нове і'мя:  </label>
            <input type="text" name="userName" value = "<?php echo $row["username"] ?>">
            <label for="dateOfBirth">Введіть дату народження:</label>
            <input type="date" name="dateOfBirth" value = "<?php echo $row["birthday"] ?>">
            <label for="email">Введіть новий Email:</label>
            <input type="text" name="email" value = "<?php echo $row["email"] ?>">
            

            <input class="add-item-button" type="submit">
            <?php if($row["user_id"] != 91) { ?>
                <input class="delate-item-button" type="button" value="Видалити профіль" onclick="confirmDelete()">
            <?php } ?>
        </form>
        
    </div>
    
    <div id="error-alert" class="error-alert hidden">
        <p></p>
    </div>

</body>
</html>

<?php 

    if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["removeUser"])){

        $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_SPECIAL_CHARS);
        $dateOfBirth = filter_input(INPUT_POST, "dateOfBirth", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

        $imageTargetDir = __DIR__ . "/imeges/user-img/";
        
        $imageExtension = pathinfo($_FILES["userImage"]["name"], PATHINFO_EXTENSION);
        $imageName = preg_replace("/[^a-zA-Zа-яА-Я0-9]+/u", " ", $user_id) . "." . $imageExtension;
        $imageTargetFilePath = $imageTargetDir . $imageName;

        $allowedImageTypes = ["image/jpeg", "image/png", "image/gif"];
        if(!empty($imageExtension)) {
            if (in_array($_FILES["userImage"]["type"], $allowedImageTypes)) {
            if (!copy($_FILES["userImage"]["tmp_name"], $imageTargetFilePath)) {
                echo "<script type=\"text/javascript\"> showError('Помилка при завантаженні зображення.');</script>";
            }
            } else {
                echo "<script type=\"text/javascript\"> showError('Файл не є зображенням. Будь ласка, завантажте файл формату JPEG, PNG або GIF.');</script>";
            }

        }

        if(empty($userName)){
            echo "<script type=\"text/javascript\"> showError('Введіть і'мя');</script>";
        }
        elseif(empty($dateOfBirth)){
            echo "<script type=\"text/javascript\"> showError('Введіть дату народження');</script>";
        }
        elseif(empty($email)){
            echo "<script type=\"text/javascript\"> showError('Введіть Email');</script>";
        }else{
            $sql2 = "UPDATE users SET username = '$userName', birthday = '$dateOfBirth', email = '$email' WHERE user_id = '$user_id'";

            if(mysqli_query($conn, $sql2)){
                echo '<meta http-equiv="refresh" content="0;url=user_page.php">';
                exit();
            }
            else{
                echo "<script type=\"text/javascript\"> showError('Виникла помилка');</script>";
            }
        }
    }

    if (isset($_POST["removeUser"])) {
                
        if (!empty($user_id)) {
            $query1 = "DELETE FROM comments WHERE user_id = ?";
            $query2 = "DELETE FROM users WHERE user_id = ?";
             
            $stmt1 = $conn->prepare($query1);
            $stmt2 = $conn->prepare($query2);
            if ($stmt1 === false || $stmt2 === false) {
                die("Помилка підготовки запиту: " . $conn->error);
            }
         
            $stmt1->bind_param("i", $userID);
            $stmt2->bind_param("i", $userID); 
            if ($stmt1->execute() && $stmt2->execute()) {
                echo '<meta http-equiv="refresh" content="0;">'; 
            } else {
                echo "Помилка при видаленні користувача: " . $stmt1->error . $stmt2->error;
            }
            $stmt1->close();
            $stmt2->close();

            mysqli_close($conn);
            $_SESSION['logged_in'] = false;
            header("Location: index.php");
            session_destroy();

            echo '<meta http-equiv="refresh" content="0;url=index.php">';
            exit();

        }
    }


?>