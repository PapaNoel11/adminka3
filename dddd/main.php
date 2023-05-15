<link rel="stylesheet" href="style.css">
<?php
$db_connection = mysqli_connect("localhost", "root", "", "adminka3");

$sql_categories = "SELECT id, name FROM categories";
$result_categories = mysqli_query($db_connection, $sql_categories);

$sql_products = "SELECT products.id, products.name, products.price, categories.name AS category_name, products.show_date FROM products LEFT JOIN categories ON products.category_id = categories.id";
$result_products = mysqli_query($db_connection, $sql_products);

echo '<table>
    <tr>
        <th>ID</th>
        <th>Название постановки</th>
        <th>Жанр</th>
        <th>Дата показа</th>
        <th>Цена</th>
        <th></th>
    </tr>';
while ($product = mysqli_fetch_assoc($result_products)) {
    echo '<tr>
            <td>' . $product['id'] . '</td>
            <td>' . $product['name'] . '</td>
            <td>' . $product['category_name'] . '</td>
            <td>' . $product['show_date'] . '</td>
            <td>' . $product['price'] . '</td>
            <td>
                <form method="post" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="' . $product['id'] . '">
                    <button type="submit">Добавить в корзину</button>
                </form>
            </td>
        </tr>';
        
}

echo '</table>';
?>
<form action="index.php" method="post">
    <button type="submit">На главную</button>
</form>