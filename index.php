<?php 

    include("include/config.php");
    
    include("include/menu_handler.php");
    include("include/conect.php");

    $sql = "
        SELECT 
            books.book_id,
            books.title,
            authors.author_name AS author_name
        FROM 
            books
        JOIN 
            authors
        ON 
            books.author_id = authors.author_id;
        
    ";

    $sql2 = "
        SELECT 
            books.book_id,
            books.title,
            authors.author_name,
            COUNT(comments.comment_id) AS comment_count
        FROM 
            books
        JOIN 
            comments
        ON 
            books.book_id = comments.book_id
        JOIN 
            authors
        ON 
            books.author_id = authors.author_id
        GROUP BY 
            books.book_id
        ORDER BY 
            comment_count DESC;
        
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
</head>
<body>

    <?php include("include/menu.php"); ?>


    <div class="size-fixer">
        <section class="section-about">
            <div class="slider middle">
                <div class="slides">
                    <input type="radio" name="r" id="r1" checked>
                    <input type="radio" name="r" id="r2">
                    <input type="radio" name="r" id="r3">
                    <input type="radio" name="r" id="r4">

                    <div class="slide s1"><img src="imeges/section-about/bg.jpg" alt=""></div>
                    <div class="slide"><img src="imeges/section-about/bgr-banner-nnxtux8zaniv1g8qyrbxsuoi7hftbuzoympklz1hqo.png" 
                        alt=""></div>
                    <div class="slide"><img src="imeges/section-about/Central-Library-Teen-Center.jpg" alt=""></div>
                    <div class="slide"><img src="imeges/section-about/istockphoto-495747679-612x612.jpg" alt=""></div>
                </div>
                <div class="nav_positioning">
                    <div class="navigation">
                        <label for="r1" class="bar"></label>
                        <label for="r2" class="bar"></label>
                        <label for="r3" class="bar"></label>
                        <label for="r4" class="bar"></label>
                    </div>
                </div>
            </div>

            <div class="section-about_divForText">
                <h2 >Про нас</h2>
                <p>Ми — сучасна онлайн бібліотека, яка відкриває безліч можливостей для здобуття знань, розвитку та культурного зростання. Наша мета — стати вашим надійним 
                    партнером у світі інформації, де ви завжди знайдете відповіді на свої запитання, розширите свої знання та відкриєте нові горизонти.
                </p>
                <p>Запрошуємо вас скористатися всіма можливостями нашої онлайн бібліотеки. Разом ми будуємо культурну спільноту, де кожен може знайти своє місце та розширити
                     свій світогляд.
                </p>
            </div>
        </section>
    </div>

    <section class="section-books">
        <h1 class="section-popular_h1">Рекомендуємо для прочитання</h1>
        <div class="section-popular_catalog">
            <div class="section-popular_list">
                <?php    
                    for($i = 0; $i < 5; $i++){       
                        $row = mysqli_fetch_assoc($result);
                        include("include/img.php");               
                ?>        
                    <a class="section-popular_element_link section-popular_element" href="book_page.php?book_id=<?php echo $row['book_id']; ?>">     
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

    <section class="section-books content">
        <h1 class="section-popular_h1">Найбільше відгуків</h1>
        <div class="section-popular_catalog">
            <div class="section-popular_list">
                <?php    
                    for($i = 0; $i < 5; $i++){       
                        $row = mysqli_fetch_assoc($result2);
                        include("include/img.php");               
                ?>        
                    <a class="section-popular_element_link section-popular_element" href="book_page.php?book_id=<?php echo $row['book_id']; ?>">     
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
