<?php 
    session_start();

    include("include/menu_handler.php");
    include("include/conect.php");

    $user_id = $_SESSION['user_id'];

    $sql = "
        SELECT 
            *       
        FROM 
            favorite_books
        WHERE
            favorite_books.user_id = '$user_id';
        
    ";

    $sql2 = "SELECT * FROM users WHERE user_id = '$user_id'";

    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
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

    <div class="user-page">
        <div class="user-info">
            <div class="user-info-text">
                <h2>І'мя: <?php echo $row2['username']?></h2>
                <p>Дата народження: <?php 
                    $dateObject = new DateTime($row2['birthday']);
                    echo $dateObject->format('d.m.Y');
                    ?>
                </p>
                <p>Email: <?php echo $row2['email']?></p>
            </div>
        </div>
    </div>

    <section class="section-books">
        <h1 class="section-popular_h1">Улюблені книги</h1>
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
    
</body>
</html>

