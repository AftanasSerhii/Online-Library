<?php 
    include("include/config.php");
    include("include/menu_handler.php");
    include("include/conect.php");

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
</head>
<body>
    <?php include("include/menu.php"); ?>
    <script src="js/script.js"></script>

    <div class="add-item">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
            <label for="genreName">Назва:</label>
            <input type="text" name="genreName">
            <label for="description">Опис:</label>
            <input type="text" name="description">

            <input class="add-item-button" type="submit">
        </form>
    </div>
    
    <div id="error-alert" class="error-alert hidden">
        <p></p>
    </div>

</body>
</html>

<?php 

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $genreName = filter_input(INPUT_POST, "genreName", FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
        

        if(empty($genreName)){
            echo "<script type=\"text/javascript\"> showError('Введіть назву');</script>";

        }elseif(empty($description)){
            echo "<script type=\"text/javascript\"> showError('Введіть опис');</script>";
        }
        else{
            $sql = "INSERT INTO genres (genre_name, description) 
            VALUES ('$genreName','$description')";

            if(mysqli_query($conn, $sql)){
                //echo '<meta http-equiv="refresh" content="0;url=genres.php">';
                //exit();
            }
            else{
                echo "<script type=\"text/javascript\"> showError('Виникла помилка');</script>";
            }
        }

    }

    if($_POST['log_out']){
        mysqli_close($conn);
        header("Location: index.php");
    }

    mysqli_close($conn);

?>