<?php if ($_SESSION['logged_in']): ?>
    <div class="menu">
        <div class="icon-and-mainPages">
            <div class="center-section">
                <img  src="imeges/Icon/icon2.png" alt="" width="40px">
            </div>

            <div class="menu-links">
                <form action="index.php" method="post">
                    <input type="submit" value="Головна" name="main">
                </form>

                <form action="book_collection.php" method="post">
                    <input type="submit" value="Книги" name="books">
                </form>

                <form action="authors.php" method="post">
                    <input type="submit" value="Автори" name="authors">
                </form>

                <form action="genres.php" method="post">
                    <input type="submit" value="Жанри" name="genres">
                </form>
            </div>
        </div>
        

        <div class="user-section">
            <?php if ($_SESSION['admin']): ?>
                <form action="admin_page.php" method="post">
                    <input type="submit" value="Панель адміністратора" name="admin_page">
                </form>
            <?php endif; ?>

            <form action="user_page.php" method="post">
                <input type="submit" value="Профіль" name="user_page">
            </form>

            <form action="index.php" method="post">
                <input type="submit" value="Вийти" name="log_out">
            </form>
        </div>

        <button class="menu-toggle">&#9776;</button>
    </div>

    <div class="mobile-menu">

        <form action="index.php" method="post">
            <input type="submit" value="Головна" name="main">
        </form>

        <form action="book_collection.php" method="post">
            <input type="submit" value="Книги" name="books">
        </form>

        <form action="authors.php" method="post">
            <input type="submit" value="Автори" name="authors">
        </form>

        <form action="genres.php" method="post">
            <input type="submit" value="Жанри" name="genres">
        </form>

        <?php if ($_SESSION['admin']): ?>
            <form action="admin_page.php" method="post">
                <input type="submit" value="Панель адміністратора" name="admin_page">
            </form>
        <?php endif; ?>

        <form action="user_page.php" method="post">
            <input type="submit" value="Профіль" name="user_page">
        </form>

        <form action="index.php" method="post">
            <input type="submit" value="Вийти" name="log_out">
        </form>

    </div>

<?php else: ?>
    <div class="menu">
    <div class="icon-and-mainPages">
            <div class="center-section">
                <img  src="imeges/Icon/icon2.png" alt="" width="40px">
            </div>

            <div class="menu-links">
                <form action="index.php" method="post">
                    <input type="submit" value="Головна" name="main">
                </form>

                <form action="book_collection.php" method="post">
                    <input type="submit" value="Книги" name="books">
                </form>

                <form action="authors.php" method="post">
                    <input type="submit" value="Автори" name="authors">
                </form>

                <form action="genres.php" method="post">
                    <input type="submit" value="Жанри" name="genres">
                </form>
            </div>
        </div>

        <div class="login-and-registration">
            <form action="log_in.php" method="post">
                <input type="submit" value="Увійти" name="log_in">
            </form>

            <form action="registration.php" method="post">
                <input type="submit" value="Реєстрація" name="registration">
            </form>
        </div>

        <button class="menu-toggle">&#9776;</button>
    </div>

    <div class="mobile-menu">

        <form action="index.php" method="post">
            <input type="submit" value="Головна" name="main">
        </form>

        <form action="book_collection.php" method="post">
            <input type="submit" value="Книги" name="books">
        </form>

        <form action="authors.php" method="post">
            <input type="submit" value="Автори" name="authors">
        </form>

        <form action="genres.php" method="post">
            <input type="submit" value="Жанри" name="genres">
        </form>

        <form action="log_in.php" method="post">
            <input type="submit" value="Увійти" name="log_in">
        </form>

        <form action="registration.php" method="post">
            <input type="submit" value="Реєстрація" name="registration">
        </form>
        
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleButton = document.querySelector(".menu-toggle");
        const mobileMenu = document.querySelector(".mobile-menu");

        toggleButton.addEventListener("click", function() {
            mobileMenu.classList.toggle("show");
        });
    });
</script>