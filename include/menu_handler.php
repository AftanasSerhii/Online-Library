<?php 
    if($_POST["main"]){
        header("Location: index.php");
    }
    elseif($_POST["books"]){
        header("Location: book_collection.php");
    }
    elseif($_POST["registration"]){
        header("Location: registration.php");
    }
    elseif($_POST["log_in"]){
        header("Location: log_in.php");
    }
    elseif($_POST['user_page']){
        header("Location: user_page.php");
    }
    elseif($_POST['log_out']){
        mysqli_close($conn);
        $_SESSION['logged_in'] = false;
        header("Location: index.php");
        session_destroy();
    }
    

?>