<?php 
    include("include/config.php");
    
    include("include/menu_handler.php");

    include("include/conect.php");


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
            books.genre_id = genres.genre_id; 
    ";

    $result = mysqli_query($conn, $sql);

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

    <form class="section-search" action="book_collection.php" method="post">
        <input class="section-search_input" placeholder="Знайти книгу" name="search" type="search">
        <input class="section-search_button" type="submit" type="search" value ="Знайти">
    </form>

    <section class="section-books content">
            <div class="section-popular_catalog">
                <div class="section-popular_list">
                    <?php
                        if($_POST["search"]){
                            echo "<script type=\"text/javascript\"> changeName();</script>";
                            while($row = mysqli_fetch_assoc($result)){
                                include("include/img.php");
                                if(stripos($row['title'], $_POST["search"]) !== false || stripos($row['author_name'], $_POST["search"]) !== false){
                    ?>
                        <a class="section-popular_element_link section-popular_element" href="book_page.php?book_id=<?php echo $row['book_id']; ?>" >     
                            <div class="section-popular_element-card">
                                <img class="section-popular_elem_img" src="<?php echo $imagePath; ?>" alt="">
                                <h3 class="section-popular_elements_name"><?php echo $row['title']?></h3>
                                <p class="section-popular_elements_autor"><?php echo $row['author_name']?></p>
                            </div>
                        </a>
                                
                    <?php    }}
                        }else{
                                
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