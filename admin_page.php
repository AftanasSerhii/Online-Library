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
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <?php for($i = 0; $i < 15; $i++){       
                        $row = mysqli_fetch_assoc($result); ?>
                <div class="line-with-user-information">
                    <p>І'мя: <?php echo $row['username']; ?></p>
                    <p>Дата народження: <?php 
                        $dateObject = new DateTime($row['birthday']);
                        echo $dateObject->format('d.m.Y');
                        ?>
                    </p>
                    <p>Email: <?php echo $row['email']; ?></p>

                    <?php if($_SESSION['user_id'] != $row["user_id"]) {?>
                        <form action="admin_page.php?user_id=<?php echo $row['user_id']; ?>" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                            <input class="users-remove" type="submit" value="Видалити користувача" name="removeUser">
                        </form>
                    <?php }?>
                </div> 
            
        </form>

        <?php } 
                if (isset($_POST["removeUser"]) && isset($_POST['user_id'])) {
                   $userID = $_POST['user_id'];

                   echo $userID;
                
                   if (!empty($userID)) {
                       $query = "DELETE FROM users WHERE user_id = ?";
                       $stmt = $conn->prepare($query);

                       if ($stmt === false) {
                           die("Помилка підготовки запиту: " . $conn->error);
                       }
                    
                       $stmt->bind_param("i", $userID); 
                       if ($stmt->execute()) {
                           echo '<meta http-equiv="refresh" content="0;">'; 
                       } else {
                           echo "Помилка при видаленні користувача: " . $stmt->error;
                       }
                       $stmt->close();
                   }
                }
            ?>
    </div>

</body>
</html>

<?php 

    mysqli_close($conn);
?>