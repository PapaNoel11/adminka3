<?php



session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_connection = mysqli_connect("localhost", "root", "", "adminka3");


    if (!$db_connection) {
        die("Connection failed: " . mysqli_connect_error());
    }


    $username = mysqli_real_escape_string($db_connection, $_POST['username']);
    $password = mysqli_real_escape_string($db_connection, $_POST['password']);


    $sql = "SELECT password, role FROM users WHERE username = '$username'";
    $result = mysqli_query($db_connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $stored_password = $row['password'];
    $user_role = $row['role'];


    if ($password == $stored_password && $user_role == 'admin') {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $user_role;
        header('Location: admin.php');
        exit();
    } else {
        echo "Invalid username, password, or role";
    }


    mysqli_close($db_connection);
}
?>