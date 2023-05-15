<link rel="stylesheet" href="style.css">
<?php
  session_start();
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "adminka3";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = mysqli_real_escape_string($conn, $_POST["login"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $sql = "SELECT * FROM user WHERE login='$login'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      if (password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        header("Location: main.php");
        exit();
      } else {
        echo "Неправильный логин или пароль";
      }
    } else {
      echo "Неправильный логин или пароль";
    }
  }

  $conn->close();
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Логин: <input type="text" name="login"><br>
  Пароль: <input type="password" name="password"><br>
  <input type="submit" value="Войти">
</form>

<form action="register.php" method="post">
        <button type="submit">Зарегистрироваться</button>
    </form>
    <form action="index.php" method="post">
        <button type="submit">Назад</button>
    </form>

