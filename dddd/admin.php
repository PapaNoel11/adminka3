<?php

$db_connection = mysqli_connect("localhost", "root", "", "adminka3");

session_start();


if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}


if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}





function add_category($category_name) {
    global $db_connection;

    $query = "INSERT INTO categories (name) VALUES ('$category_name')";
    header('Location: admin.php');

    mysqli_query($db_connection, $query);

}


function add_product($product_name, $product_category, $product_price, $show_date) {
    global $db_connection;

    $query = "INSERT INTO products (name, category_id, price, show_date) VALUES ('$product_name', '$product_category', '$product_price', '$show_date')";
    header('Location: admin.php');

    mysqli_query($db_connection, $query);
}


function update_category($category_id, $new_name) {
    global $db_connection;

    $query = "UPDATE categories SET name='$new_name' WHERE id=$category_id";
    header('Location: admin.php');

    mysqli_query($db_connection, $query);
}


function update_product($product_id, $new_name) {
    global $db_connection;

    $query = "UPDATE products SET name='$new_name' WHERE id=$product_id";
    header('Location: admin.php');

    mysqli_query($db_connection, $query);
}


function delete_category($category_id) {
    global $db_connection;

    $query = "DELETE FROM categories WHERE id=$category_id";
    header('Location: admin.php');

    mysqli_query($db_connection, $query);
}


function delete_product($product_id) {
    global $db_connection;

    $query = "DELETE FROM products WHERE id=$product_id";
    header('Location: admin.php');

    mysqli_query($db_connection, $query);
}


$result = mysqli_query($db_connection, "SELECT * FROM categories");
$categories = array();
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

$result = mysqli_query($db_connection, "SELECT * FROM products");
$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        add_category($_POST['category_name']);
    } elseif (isset($_POST['add_product'])) {
        add_product($_POST['product_name'], $_POST['product_category'], $_POST['product_price'], $_POST['show_date']); 
    } elseif (isset($_POST['update_category'])) {
        update_category($_POST['category_id'], $_POST['new_category_name']);
    } elseif (isset($_POST['update_product'])) {
        update_product($_POST['product_id'], $_POST['new_product_name']);
    } elseif (isset($_POST['delete_category'])) {
        delete_category($_POST['category_id']);
    } elseif (isset($_POST['delete_product'])) {
        delete_product($_POST['product_id']);
    }
}

?>

<form method="POST">
<link rel="stylesheet" href="style.css">
<h1>Добавление жанров:</h1>
    <label for="category_name">Название жанра:</label>
    <input type="text" name="category_name" id="category_name">
    <button type="submit" name="add_category">Добавить жанр</button>
</form>


<form method="POST">
<h1>Добавление постановки:</h1>
    <label for="product_name">Название постановки:</label>
    <input type="text" name="product_name" id="product_name">
    <label for="product_category">Жанр постановки:</label>
    <select name="product_category" id="product_category">
        <?php foreach ($categories as $category) { ?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
        <?php } ?>
    </select>
    <label for="show_date">Дата показа:</label>
    <input type="date" name="show_date" id="show_date"> 
    <label for="product_price">Цена:</label>
    <input type="text" name="product_price" id="product_price">
    <button type="submit" name="add_product">Добавить постановку</button>
</form>



<form method="POST">
<h1>Редактирование жанра:</h1>
    <label for="category_id">ID жанра:</label>
    <input type="text" name="category_id" id="category_id">
    <label for="new_category_name">Новое название жанра:</label>
    <input type="text" name="new_category_name" id="new_category_name">
    <button type="submit" name="update_category">Обновить жанр</button>
</form>


<form method="POST">
<h1>Редактирование постановки:</h1>
    <label for="product_id">ID постановки:</label>
    <input type="text" name="product_id" id="product_id">
    <label for="new_product_name">Новое название постановки:</label>
    <input type="text" name="new_product_name" id="new_product_name">
    <button type="submit" name="update_product">Обновить постановку</button>
</form>


<form method="POST">
<h1>Удаление жанра:</h1>
    <label for="category_id">ID жанра для удаления:</label>
    <input type="text" name="category_id" id="category_id">
    <button type="submit" name="delete_category">Удалить жанр</button>
</form>


<form method="POST">
<h1>Удаление постановки:</h1>
    <label for="product_id">ID постановки для удаления:</label>
    <input type="text" name="product_id" id="product_id">
    <button type="submit" name="delete_product">Удалить постановку</button>
</form>

    <div class="bv">
    <form action="logout.php" method="post">
        <button type="submit">Выход</button>
    </form>
    <form action="catalogy.php" method="post">
        <button type="submit">На главную</button>
    </form>
    </div>

<?php


$sql_categories = "SELECT id, name FROM categories";
$result_categories = mysqli_query($db_connection, $sql_categories);


$sql_products = "SELECT products.id, products.name, products.price, categories.name AS category_name, products.show_date FROM products LEFT JOIN categories ON products.category_id = categories.id";
$result_products = mysqli_query($db_connection, $sql_products);


echo '<table>
    <tr>
        <th>ID</th>
        <th>Название жанра</th>
    </tr>';
while ($category = mysqli_fetch_assoc($result_categories)) {
    echo '<tr>
            <td>' . $category['id'] . '</td>
            <td>' . $category['name'] . '</td>
        </tr>';
}
echo '</table>';


echo '<table>
    <tr>
        <th>ID</th>
        <th>Название постановки</th>
        <th>Жанр</th>
        <th>Дата показа</th>
        <th>Цена</th>
    </tr>';
while ($product = mysqli_fetch_assoc($result_products)) {
    echo '<tr>
            <td>' . $product['id'] . '</td>
            <td>' . $product['name'] . '</td>
            <td>' . $product['category_name'] . '</td>
            <td>' . $product['show_date'] . '</td>
            <td>' . $product['price'] . '</td>
        </tr>';
}
echo '</table>';