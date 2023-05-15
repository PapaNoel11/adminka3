<link rel="stylesheet" href="style.css">
<h1>Авторизация для администрора</h1>
<form method="post" action="authcheck.php">
    <div>
        <label for="username">Логин:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <button type="submit">Войти</button>
    </div>
</form>
<h1>Авторизация и регистрация для пользователя</h1>
<form action="login.php" method="post">
        <button type="submit">Войти</button>
    </form>
<form action="register.php" method="post">
        <button type="submit">Регистрация</button>
    </form>

    <h1>Каталог товаров</h1>
    <form action="catalogy.php" method="post">
        <button type="submit">Каталог</button>
    </form>
