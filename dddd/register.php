<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "adminka3";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $surname = mysqli_real_escape_string($conn, $_POST["surname"]);
    $patronymic = mysqli_real_escape_string($conn, $_POST["patronymic"]);
    $login = mysqli_real_escape_string($conn, $_POST["login"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $password_repeat = mysqli_real_escape_string($conn, $_POST["password_repeat"]);

    $sql = "SELECT * FROM user WHERE login='$login' OR email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      echo "Пользователь с таким логином или email уже существует";
    } else {
      if ($password == $password_repeat && strlen($password) >= 6) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (name, surname, patronymic, login, email, password) VALUES ('$name', '$surname', '$patronymic', '$login', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
          echo "Регистрация прошла успешно";
          echo "<br><a href='login.php'>Войти в аккаунт</a>";
        } else {
          echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }
      } else {
        echo "Пароль должен быть не менее 6 символов и совпадать с полем для повторения пароля";
      }
    }
  }

  $conn->close();
  ?>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Имя: <input type="text" name="name" pattern="[а-яА-ЯёЁ\s\-]+"><br>
    Фамилия: <input type="text" name="surname" pattern="[а-яА-ЯёЁ\s\-]+"><br>
    Отчество: <input type="text" name="patronymic" pattern="[а-яА-ЯёЁ\s\-]*"><br>
    Логин: <input type="text" name="login" pattern="[a-zA-Z0-9\-]+"><br>
    Email: <input type="email" name="email"><br>
    Пароль: <input type="password" name="password" minlength="6"><br>
    Повторите пароль: <input type="password" name="password_repeat" minlength="6"><br>
    <input type="checkbox" name="rules" required> Согласен с правилами регистрации<br>
    <input type="submit" value="Зарегистрироваться">
  </form>
  <form action="login.php" method="post">
        <button type="submit">Войти</button>
    </form>
    <form action="index.php" method="post">
        <button type="submit">На главную</button>
    </form>