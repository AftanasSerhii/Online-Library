<?php 
    include("include/config.php");
    
    include("include/menu_handler.php");
    include("include/conect.php");

    $author_id = $_GET['author_id'];

    $sql2 = "
        SELECT 
            *
        FROM 
            authors
        WHERE
            author_id = '$author_id';
        
    ";

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
            authors.author_id = '$author_id';
    ";

    $result = mysqli_query($conn, $sql);

    $result2 = mysqli_query($conn, $sql2);

    $row2 = mysqli_fetch_assoc($result2);
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

    <div class="autor-page">
        <div class="autor-info">
            <div class="autor-info-img">
                <img src="imeges/authors-img/<?php echo $row2['author_name'];?>.jpg" alt="">
            </div>

            <div class="autor-info-text">
                <h2><?php echo $row2['author_name']?></h2>
                <p>Дата народження: <?php 
                    $dateObject = new DateTime($row2['birth_date']);
                    echo $dateObject->format('d.m.Y');
                    ?>
                </p>
                <p>Країна походження: <?php echo $row2['nationality']?></p>
                <p>Біографія: <?php echo $row2['biography']?></p>

                <?php if( $_SESSION['admin']){ ?>
                    <form action="author_page.php?author_id=<?php echo $row2['author_id']; ?>" method="post">
                        <input class="favorite" type="submit" value="Видалити автора" name="removeAuthor">
                    </form>

                <?php }
                
                    if($_POST["removeAuthor"]){
                        $query2 = "DELETE FROM authors WHERE authors.author_id = '$author_id';";

                        if($author_id != null){
                            $stmt2 = $conn->prepare($query2);

                            if ($stmt2 === false) {
                                die("Помилка підготовки запиту: " . $conn->error);
                            }
                            if ($stmt2->execute()) {
                                echo '<meta http-equiv="refresh" content="0;url=authors.php">';
                            } else {
                                echo "Помилка при додаванні запису: " . $stmt2->error;
                            }
                            $stmt2->close();
                        }
                    }

                ?>
            </div>

        </div>
    </div>
    
    <section class="section-books content">
        <h1 class="section-popular_h1">Книги автора доступні для прочитання</h1>
        <div class="section-popular_catalog">
            <div class="section-popular_list">
                <?php    
                    while($row = mysqli_fetch_assoc($result)){       
                        include("include/img.php");               
                ?>   
                    <a class="section-popular_element_link section-popular_element" href="book_page.php?book_id=<?php echo $row['book_id']; ?>" >     
                        <div class="section-popular_element-card">

                            <img class="section-popular_elem_img" src="<?php echo $imagePath; ?>" alt="">
                        
                            <h3 class="section-popular_elements_name"><?php echo $row['title']?></h3>
                        
                            <p class="section-popular_elements_autor"><?php echo $row['author_name']?></p>
                           
                        </div>
                    </a>    
                <?php       
                    }
                ?>

                
            </div>
        </div>
    </section>

    <footer class="footer">
        <p class="footer_text">Усі права захищено</p>
    </footer>
    
</body>
</html>


<?php 

mysqli_close($conn);
    


?>