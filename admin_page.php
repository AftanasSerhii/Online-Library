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

    $sql2 = "
        SELECT 
            COUNT(*) 
        AS 
            total_users 
        FROM 
            users;
    ";

    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);
    $total_users = mysqli_fetch_assoc($result2);
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
            <?php for($i = 0; $i < $total_users["total_users"]; $i++){       
                        $row = mysqli_fetch_assoc($result); ?>
            <div class="line-with-user-information">
                <p>І'мя: <?php echo $row['username']; ?></p>
                <p>Дата народження: <?php 
                    $dateObject = new DateTime($row['birthday']);
                        echo $dateObject->format('d.m.Y');
                    ?>
                </p>
                <p>Email: <?php echo $row['email']; ?></p>
                <div class="admin-buttons">
                    <?php if($_SESSION['user_id'] != $row["user_id"]) {  if($row["username"] != "serhii") { ?>
                        <form action="admin_page.php?user_id=<?php echo $row['user_id']; ?>" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                            <input class="users-remove" type="submit" value="Видалити користувача" name="removeUser">
                        </form>
                        <?php if($row['admin'] != 1){ ?>
                            <form action="admin_page.php?user_id=<?php echo $row['user_id']; ?>" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                <input class="users-makeAdmin" type="submit" value="Зробити адміністратором" name="makeAdmin">
                            </form>
                        <?php }else { ?>
                            <form action="admin_page.php?user_id=<?php echo $row['user_id']; ?>" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                <input class="users-makeAdmin" type="submit" value="Видалити з адміністраторів" name="removeAdmin">
                            </form>
                        <?php }?>
                    <?php }  }?>
                </div> 
            </div> 
        </form>

        <?php } 
        
                if (isset($_POST["removeUser"]) && isset($_POST['user_id'])) {
                   
                    $userID = $_POST['user_id'];
                
                   if (!empty($userID)) {
                       $query1 = "DELETE FROM comments WHERE user_id = ?";
                       $query2 = "DELETE FROM users WHERE user_id = ?";
                        
                       $stmt1 = $conn->prepare($query1);
                       $stmt2 = $conn->prepare($query2);

                       if ($stmt1 === false || $stmt2 === false) {
                           die("Помилка підготовки запиту: " . $conn->error);
                       }
                    
                       $stmt1->bind_param("i", $userID);
                       $stmt2->bind_param("i", $userID); 
                       if ($stmt1->execute() && $stmt2->execute()) {
                           echo '<meta http-equiv="refresh" content="0;">'; 
                       } else {
                           echo "Помилка при видаленні користувача: " . $stmt1->error . $stmt2->error;
                       }
                       $stmt1->close();
                       $stmt2->close();
                   }
                }

                if (isset($_POST["makeAdmin"]) && isset($_POST['user_id'])) {
                   
                    $userID = $_POST['user_id'];
                
                   if (!empty($userID)) {
                       $query = "UPDATE users SET admin = 1 WHERE user_id = ?";
                       
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

                       $stmt1->close();
                   }
                }

                if (isset($_POST["removeAdmin"]) && isset($_POST['user_id'])) {
                   
                    $userID = $_POST['user_id'];
                
                   if (!empty($userID)) {
                       $query = "UPDATE users SET admin = 0 WHERE user_id = ?";
                       
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