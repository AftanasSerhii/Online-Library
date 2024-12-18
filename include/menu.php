<?php if ($_SESSION['logged_in']): ?>

<div class="menu">

    <div class="center-section">
        <form  action="index.php" method="post">
            <input type="submit" value="Головна" name="main">
        </form>

        <form  action="book_collection.php" method="post">
            <input type="submit" value="Книги" name="books">
        </form>

        <form  action="authors.php" method="post">
            <input type="submit" value="Автори" name="authors">
        </form>

    </div>

    <div class="log_out">
        <form  action="user_page.php" method="post">
            <input type="submit" value="Профіль" name="user_page">
        </form>

        <form class="menu-form-log_out" action="index.php" method="post">
            <input type="submit" value="Вийти" name="log_out">
        </form>
    </div>

</div>
<?php else: ?>

<div class="menu">

    <div class="center-section">
        <form action="index.php" method="post">
            <input type="submit" value="Головна" name="main">
        </form>

        <form action="book_collection.php" method="post">
            <input type="submit" value="Книги" name="books">
        </form>

        <form action="authors.php" method="post">
            <input type="submit" value="Автори" name="authors">
        </form>

    </div>

    <div class="login-and-registration">
        <form action="index.php" method="post">
            <input type="submit" value="Увійти" name="log_in">
        </form>

        <form action="index.php" method="post">
            <input type="submit" value="Реєстрація" name="registration">
        </form>
    </div>

</div>
<?php endif; ?>