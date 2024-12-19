<?php 
    include("include/config.php");
    
    include("include/menu_handler.php");
    include("include/conect.php");

    $sql = "
        SELECT 
            *
        FROM 
            authors;
        
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
</head>
<body>
    <?php include("include/menu.php"); ?>
    <script src="js/script.js"></script>


    <form class="section-search" action="authors.php" method="post">
        <input class="section-search_input" placeholder="Знайти автора" name="search" type="search">
        <input class="section-search_button" type="submit" type="search" value ="Знайти">
    </form>

    <section class="section-authors content">

        <?php

            if($_POST["search"]){

                echo "<script type=\"text/javascript\"> changeName();</script>";
        
                while($row = mysqli_fetch_assoc($result)){
                    if(stripos($row['author_name'], $_POST["search"]) !== false){
        ?>
                <a href="author_page.php?author_id=<?php echo $row['author_id']; ?>">
                    <div class="section-authors-list">
                            <?php echo $row['author_name']?>
                    </div>
                </a>

        <?php }}
            }else{ 
                while($row = mysqli_fetch_assoc($result)){
            ?>
                <a href="author_page.php?author_id=<?php echo $row['author_id']; ?>">
                    <div class="section-authors-list">
                            <?php echo $row['author_name']?>
                    </div>
                </a>
        <?php       
                }
            }
        ?>

    </section>

    <footer class="footer">
        <p class="footer_text">Усі права захищено</p>
    </footer>


</body>
</html>

