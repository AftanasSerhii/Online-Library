<?php 
    include("include/config.php");
    include("include/menu_handler.php");
    include("include/conect.php");

    $sql = "
        SELECT 
            author_name
        FROM 
            authors
    ";

    $sql2 = "
        SELECT 
            genre_name
        FROM 
            genres
    ";


    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
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

    <div style="margin-top: 100px;">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <label for="bookName">Назва книги:</label>
            <input type="text" name="bookName">
            <label for="authorName">Виберіть автора:</label>
            <select name="authorName" id="">
                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <option value="<?php echo $row['author_name']; ?>"><?php echo $row['author_name']; ?></option>
                <?php }?>
            </select>
            <label for="genre">Виберіть жанр:</label>
            <select name="genre" id="">
                <?php while($row = mysqli_fetch_assoc($result2)){ ?>
                    <option value="<?php echo $row['genre_name']; ?>"><?php echo $row['genre_name']; ?></option>
                <?php }?>
            </select>
            <label for="year">Введіть рік публікації:</label>
            <input type="number" name="year">
            <label for="publisher">Введіть видавця книги:</label>
            <input type="text" name="publisher">

            <input type="submit">
        </form>
    </div>
    
    <div id="error-alert" class="error-alert hidden">
        <p></p>
    </div>

</body>
</html>

<?php 

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $bookName = filter_input(INPUT_POST, "bookName", FILTER_SANITIZE_SPECIAL_CHARS);
        $authorName = filter_input(INPUT_POST, "authorName", FILTER_SANITIZE_SPECIAL_CHARS);
        $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_SPECIAL_CHARS);
        $year = filter_input(INPUT_POST, "year", FILTER_SANITIZE_SPECIAL_CHARS);
        $publisher = filter_input(INPUT_POST, "publisher", FILTER_SANITIZE_SPECIAL_CHARS);

        $sql3 = "
            SELECT 
                author_id
            FROM 
                authors
            WHERE
                author_name = '$authorName';
        ";
        $result3 = mysqli_query($conn, $sql3);
        $row = mysqli_fetch_assoc($result3);

        $authorId = $row['author_id'];

        $sql4 = "
            SELECT 
                genre_id
            FROM 
                genres
            WHERE
                genre_name = '$genre';
        ";

        $result4 = mysqli_query($conn, $sql4);
        $row2 = mysqli_fetch_assoc($result4);

        $genreId = $row2['genre_id'];

        if(empty($bookName)){
            echo "<script type=\"text/javascript\"> showError('Введіть ім\'я');</script>";
        }
        elseif(empty($year)){
            echo "<script type=\"text/javascript\"> showError('Введіть дату народження');</script>";
        }
        elseif(empty($publisher)){
            echo "<script type=\"text/javascript\"> showError('Введіть Email');</script>";
        }else{
            $sql5 = "INSERT INTO books (title, author_id, genre_id, publication_year, publisher) 
            VALUES ('$bookName','$authorId','$genreId','$year', '$publisher')";

            if(mysqli_query($conn, $sql5)){
                echo '<meta http-equiv="refresh" content="0;url=book_collection.php">';
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