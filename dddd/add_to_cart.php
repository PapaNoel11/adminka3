<link rel="stylesheet" href="style.css">
<?php
session_start();
$db_connection = mysqli_connect("localhost", "root", "", "adminka3");

if (isset($_POST['product_id'])) {

$product_id = $_POST['product_id'];

$sql_product = "SELECT id, name, price FROM products WHERE id = $product_id";
$result_product = mysqli_query($db_connection, $sql_product);
$product = mysqli_fetch_assoc($result_product);

$sql_cart = "SELECT product_id FROM cart WHERE product_id = $product_id";
$result_cart = mysqli_query($db_connection, $sql_cart);
$cart_product = mysqli_fetch_assoc($result_cart);
if ($cart_product) {
    $_SESSION['cart'][$product_id]++;
    $sql_update = "UPDATE cart SET quantity = quantity + 1 WHERE product_id = $product_id";
    mysqli_query($db_connection, $sql_update);
} else {
    $_SESSION['cart'][$product_id] = 1;
    $sql_insert = "INSERT INTO cart (product_id, name, price, quantity) VALUES ('$product_id', '{$product['name']}', '{$product['price']}', '1')";
    mysqli_query($db_connection, $sql_insert);
}
    }
if (isset($_POST['update_cart'])) {
    $quantities = $_POST['quantity'];
    foreach ($quantities as $product_id => $quantity) {
    if ($quantity == 0) {
        $sql_delete = "DELETE FROM cart WHERE product_id = $product_id";
        mysqli_query($db_connection, $sql_delete);
        unset($_SESSION['cart'][$product_id]);
    } else {
        $sql_update = "UPDATE cart SET quantity = $quantity WHERE product_id = $product_id";
        mysqli_query($db_connection, $sql_update);
        $_SESSION['cart'][$product_id] = $quantity;
    }
    }
    }
    

if (isset($_GET['delete_id'])) {
    $product_id = $_GET['delete_id'];

    if (isset($_SESSION['cart'][$product_id])) {
     
        $_SESSION['cart'][$product_id]--;
        
        if ($_SESSION['cart'][$product_id] == 0) {
            $sql_delete = "DELETE FROM cart WHERE product_id = $product_id";
            mysqli_query($db_connection, $sql_delete);
            unset($_SESSION['cart'][$product_id]);
        } else {
         
            $sql_update = "UPDATE cart SET quantity = quantity - 1 WHERE product_id = $product_id";
            mysqli_query($db_connection, $sql_update);
        }
    }
}
    
 
    if (!empty($_SESSION['cart'])) {
    $total_price = 0;
    echo "<table>";
    echo "<tr><th>Название товара</th><th>Количество</th><th>Цена</th><th>Удалить</th></tr>";
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $sql_product = "SELECT * FROM products WHERE id = $product_id";
    $result_product = mysqli_query($db_connection, $sql_product);
    $product = mysqli_fetch_assoc($result_product);
    $price = $product['price'] * $quantity;
    $total_price += $price;
    echo "<tr><td>".$product['name']."</td><td><form method='post'><input type='number' name='quantity[$product_id]' value='$quantity'><button type='submit' name='update_cart'>Обновить</button></form></td><td>".$price." руб.</td><td><a href='?delete_id=".$product_id."'>Удалить</a></td></tr>";
    }
    echo "<tr><td colspan='2'>Итого:</td><td>".$total_price." руб.</td><td><a href='?clear_cart'>Очистить корзину</a></td></tr>";
    echo "</table>";
    } else {
    echo "Корзина пуста";
    }

    
if (isset($_GET['clear_cart'])) {
    
    $sql_delete = "DELETE FROM cart";
    mysqli_query($db_connection, $sql_delete);
  
    unset($_SESSION['cart']);
   
    header("Location: add_to_cart.php");
    exit();
}

?>
<form action="main.php" method="post">
    <button type="submit">Назад</button>
</form>