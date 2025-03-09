<?php 
    include("include/config.php");
    
    include("include/menu_handler.php");
    include("include/conect.php");

    $sql = "
        SELECT 
            *       
        FROM 
            users;
        
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

    <div class="list-of-users">
        <form action="">
            <?php for($i = 0; $i < 10; $i++){       
                        $row = mysqli_fetch_assoc($result); ?>
                <div class="line-with-user-information">
                    <p>І'мя: <?php echo $row['username']; ?></p>
                    <p>Дата народження: <?php 
                        $dateObject = new DateTime($row['birthday']);
                        echo $dateObject->format('d.m.Y');
                        ?>
                    </p>
                    <p>Email: <?php echo $row['email']; ?></p>
                    <input type="submit" value="Видалити">
                </div> 
            <?php } ?>
        </form>
    </div>

</body>
</html>