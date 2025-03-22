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
            <label for="authorName">І'мя:</label>
            <input type="text" name="authorName">
            <label for="birth_date">Дата народження:</label>
            <input type="date" name="year">
            <label for="nationality">Країна походження:</label>
            <input type="text" name="nationality">
            <label for="biography">Біографія:</label>
            <input type="text" name="biography">
            <label for="authorImage">Завантажити зображення автора:</label>
            <input type="file" name="authorImage" accept="image/*" required>

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

        $authorName = filter_input(INPUT_POST, "authorName", FILTER_SANITIZE_SPECIAL_CHARS);
        $birth_date = new DateTime($_POST['birth_date']);
        $nationality = filter_input(INPUT_POST, "nationality", FILTER_SANITIZE_SPECIAL_CHARS);
        $biography = filter_input(INPUT_POST, "biography", FILTER_SANITIZE_SPECIAL_CHARS);

        $birth = $birth_date->format('Y.m.d');

        if (empty($authorName)) {
            echo "<script type=\"text/javascript\"> showError('Введіть ім\'я');</script>";
        }

        $imageTargetDir = __DIR__ . "/imeges/authors-img/";

        $imageExtension = pathinfo($_FILES["authorImage"]["name"], PATHINFO_EXTENSION);
        $imageName = $authorName . "." . $imageExtension;
        $imageTargetFilePath = $imageTargetDir . $imageName;

        $allowedImageTypes = ["image/jpeg", "image/png", "image/gif"];
        if (in_array($_FILES["authorImage"]["type"], $allowedImageTypes)) {
            if (!copy($_FILES["authorImage"]["tmp_name"], $imageTargetFilePath)) {
                echo "<script type=\"text/javascript\"> showError('❌ Помилка при завантаженні зображення.');</script>";
            }
        } else {
            echo "<script type=\"text/javascript\"> showError('❌ Файл не є зображенням. Будь ласка, завантажте файл формату JPEG, PNG або GIF.');</script>";
        }

        if(empty($birth)){
            echo "<script type=\"text/javascript\"> showError('Введіть дату народження');</script>";

        }elseif(empty($nationality)){
            echo "<script type=\"text/javascript\"> showError('Введіть країну походження');</script>";
        }
        elseif(empty($biography)){
            echo "<script type=\"text/javascript\"> showError('Поле біографії пусте');</script>";
        }else{
            $sql = "INSERT INTO authors (author_name, birth_date, nationality, biography) 
            VALUES ('$authorName','$birth','$nationality','$biography')";

            if(mysqli_query($conn, $sql)){
                echo '<meta http-equiv="refresh" content="0;url=authors.php">';
                exit();
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