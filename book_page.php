<?php 
    include("include/config.php");
    
    include("include/menu_handler.php");

    include("include/conect.php");

    $book_id = (int)$_GET['book_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "
        SELECT 
            books.book_id,
            books.title,
            authors.author_name AS author_name, 
            genres.genre_name AS genre_name,
            books.publication_year,
            books.publisher
        FROM 
            books
        JOIN 
            authors
        ON 
            books.author_id = authors.author_id
        JOIN 
            genres
        ON 
            books.genre_id = genres.genre_id
        WHERE
            books.book_id = '$book_id';
    ";

    $sql2 = "
        SELECT
            comment_id,
            users.username AS username,
            comments.date_of_publication,
            comments.comment_text,
            books.title AS title
        FROM 
            comments
        JOIN 
            users
        ON 
            comments.user_id = users.user_id
        JOIN 
            books
        ON 
            comments.book_id = books.book_id
        WHERE
            books.book_id = '$book_id';
    ";

    $sql3 = "
        SELECT 
            *       
        FROM 
            favorite_books
        WHERE
            favorite_books.user_id = '$user_id';
        
    ";

    $result = mysqli_query($conn, $sql);

    $result2 = mysqli_query($conn, $sql2);

    $result3 = mysqli_query($conn, $sql3);

    $row = mysqli_fetch_assoc($result);

    $is_added = false;

    while($row3 = mysqli_fetch_assoc($result3)){
        if($book_id == $row3['book_id'] && $user_id == $row3['user_id']){
            $is_added = true;
            break;
        }
    }
    
    include("include/img.php");  
?>

<!DOCTYPE html>
<html lang="en">
<head class="book_page-head">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="icon" type="imege/x-icon" href="imeges/Icon/icon2.png">
    <link rel="stylesheet" href="css/style.css">
    

</head>
<body class="book_page-body">
    <?php include("include/menu.php"); ?>
    <script src="js/script.js"></script>
    

    <div class="book_page content">
        <div class="book-info">
            <div class="book-info-img">
                <img src="<?php echo $imagePath; ?>" alt="">
            </div>

            <div class="book-info-text">
                <h2><?php echo $row['title'];?></h2>
                <p>Автор: <?php echo $row['author_name'];?></p>
                <p>Жанр: <?php echo $row['genre_name'];?></p>
                <p>Рік публікації: <?php echo $row['publication_year'];?></p>
                <p>Видавництво: <?php echo $row['publisher'];?></p>

                <?php if ($is_added): ?>
                    <form action="book_page.php?book_id=<?php echo $row['book_id']; ?>" method="post">
                        <input class="favorite" type="submit" value="Видалити з улюблентх" name="favorite">
                    </form>

                    <?php 
   
                        if($_POST["favorite"]){

                            $query = "DELETE FROM favorite_books WHERE book_id = ?";

                            $stmt = $conn->prepare($query);
                            if ($stmt === false) {
                                die("Помилка підготовки запиту: " . $conn->error);
                            }

                            if (!isset($book_id) || $book_id === null || $book_id <= 0) {
                                die("Помилка: Невірне значення для book_id.");
                            }

                            $stmt->bind_param("i", $book_id);
                            if ($stmt->execute()) {
                                echo "<meta http-equiv=\"refresh\" content=\"0\">";
                            } else {
                                echo "Помилка при додаванні запису: " . $stmt->error;
                            }
                            $stmt->close();
                        }
                    ?>

                <?php else: ?>
                    <form action="book_page.php?book_id=<?php echo $row['book_id']; ?>" method="post">
                        <input class="favorite" type="submit" value="Додати в улюблені" name="favorite">
                    </form>

                    <div id="error-alert" class="error-alert hidden">
                        <p></p>
                    </div>

                    <?php 
   
                        if($_POST["favorite"]){
                            $user_id = $_SESSION['user_id'];
                            $title = $row['title'];
                            $author_name = $row['author_name'];

                            $query = "INSERT INTO favorite_books (book_id, title, author_name, user_id) VALUES (?, ?, ?, ?)";

                            if (!isset($user_id) || $user_id === null || $user_id <= 0) {
                                echo "<script type=\"text/javascript\"> showError('Помилка: для того щоб додати книгу до улюблених авторизуйтесь');</script>";
                            }else {
                                $stmt = $conn->prepare($query);
                                if ($stmt === false) {
                                    die("Помилка підготовки запиту: " . $conn->error);
                                }
                                if (!isset($book_id) || $book_id === null || $book_id <= 0) {
                                    die("Помилка: Невірне значення для book_id.");
                                }
                                $stmt->bind_param("issi", $book_id, $title, $author_name, $user_id);
                                if ($stmt->execute()) {
                                    echo "<meta http-equiv=\"refresh\" content=\"0\">";
                                } else {
                                    echo "Помилка при додаванні запису: " . $stmt->error;
                                }
                                $stmt->close();
                            }
                                      
                        }
                    ?>
              
                <?php endif; ?>

                <?php if( $_SESSION['admin']){ ?>
                        <form action="book_page.php?book_id=<?php echo $row['book_id']; ?>" method="post">
                            <input class="favorite" type="submit" value="Видалити книгу" name="removeBook">
                        </form>
                <?php }
                
                    if($_POST["removeBook"]){
                        $query2 = "DELETE FROM books WHERE books.book_id = '$book_id';";

                        if($book_id != null){
                            $stmt2 = $conn->prepare($query2);

                            if ($stmt2 === false) {
                                die("Помилка підготовки запиту: " . $conn->error);
                            }
                            if ($stmt2->execute()) {
                                echo '<meta http-equiv="refresh" content="0;url=book_collection.php">';
                            } else {
                                echo "Помилка при додаванні запису: " . $stmt2->error;
                            }
                            $stmt2->close();
                        }
                    }

                ?>
                     
            </div>
        </div>

        <div class="book-pdf">
            <?php
                $pdfPath = "pdf/" . $row['title'] . ".pdf";
                if (file_exists($pdfPath)) {
                    echo '<iframe src="' . $pdfPath . '"></iframe>';
                } else {
                    echo '<h2 style="margin: auto 0">PDF для цієї книги наразі недоступний.</h2>';
                }
            ?>
        </div>

        <div class="coments">
            
            <h2>Відгуки</h2>
            
            <?php 
                while ($row2 = mysqli_fetch_assoc($result2)) {
            ?>
            
                <div class="coments-card" id="bottom">
                    <div class="coments-user-data">
                        <p><?php echo htmlspecialchars($row2['username']); ?></p>
                        <p><?php 
                            $dateObject = new DateTime($row2['date_of_publication']);
                            echo $dateObject->format('d.m.Y');
                        ?></p>
                    </div>
            
                    <div class="coments-user-text">
                        <p><?php echo htmlspecialchars($row2['comment_text']); ?></p>
                    </div>
            
                    <?php if ($_SESSION['admin']) { ?>
                        <form action="book_page.php?book_id=<?php echo $row['book_id']; ?>" method="post">
                            <input type="hidden" name="comment_id" value="<?php echo $row2['comment_id']; ?>">
                            <input class="coments-remove" type="submit" value="Видалити коментар" name="removeComments" >
                        </form>
                    <?php } ?>
                </div>
            <?php 
            }

            if (isset($_POST["removeComments"]) && isset($_POST['comment_id'])) {
                $commentID = $_POST['comment_id'];
            
                if (!empty($commentID)) {
                    $query3 = "DELETE FROM comments WHERE comment_id = ?";
                    $stmt3 = $conn->prepare($query3);
                
                    if ($stmt3 === false) {
                        die("Помилка підготовки запиту: " . $conn->error);
                    }
                
                    $stmt3->bind_param("i", $commentID); 
                    if ($stmt3->execute()) {
                        echo '<meta http-equiv="refresh" content="0;">'; 
                    } else {
                        echo "Помилка при видаленні коментаря: " . $stmt3->error;
                    }
                    $stmt3->close();
                }
            }
            ?>
        </div>

        

        <div class="coments">
            <h2>Поділіться враженнями</h2>
        
            <div class="coments-input">
                <form action="book_page.php?book_id=<?php echo $row['book_id']; ?>" method="post">
                    <textarea class="coment-text" rows="4" cols="50" placeholder="Введіть текст (максимум 300 символів)" name="text"></textarea>
                    <input class="send-button" type="submit" value="Надіслати" name="send">
                </form>
            </div>

            <div id="error-alert" class="error-alert hidden">
                <p></p>
            </div>

            <?php 
   
               if($_POST["send"]){
                   $user_id = $_SESSION['user_id'];
                   $text = $_POST["text"];
                   $query = "INSERT INTO comments (user_id, date_of_publication, comment_text, book_id) VALUES (?, ?, ?, ?)";

                   if (!isset($user_id) || $user_id === null || $user_id <= 0) {
                        echo "<script type=\"text/javascript\"> showError('Помилка: користувач не авторизований!'); </script>";
                        echo "<script type=\"text/javascript\"> scroll() </script>";
                   } elseif(strlen($text) <= 2){
                        echo "<script type=\"text/javascript\"> showError('Помилка: текст занадто короткий!');</script>";
                        echo "<script type=\"text/javascript\"> scroll() </script>";
                   } elseif (strlen($text) > 300) {
                        echo "<script type=\"text/javascript\"> showError('Помилка: текст занадто довгий!');</script>";
                        echo "<script type=\"text/javascript\"> scroll() </script>";
                   } else {
                        $stmt = $conn->prepare($query);
                        if ($stmt === false) {
                            echo "<script type=\"text/javascript\"> showError('Помилка підготовки запиту!');</script>";
                        }
                    
                        $stmt->bind_param("issi", $user_id, date("Y-m-d"), $text, $book_id);
                        if ($stmt->execute()) {
                            echo "<meta http-equiv=\"refresh\" content=\"0\">";
                            echo "<script type=\"text/javascript\"> scroll() </script>";
                        } else {
                            echo "<script type=\"text/javascript\"> showError('Помилка при додаванні запису!');</script>";
                        }
                        $stmt->close();
                   }                
               }
            ?>
        </div>
    </div>
    
    <footer class="footer">
        <p class="footer_text">Усі права захищено</p>
    </footer>

</body>
</html>

<?php 

    mysqli_close($conn);
?>