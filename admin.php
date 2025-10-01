<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "890890890f";
$dbname = "motorcycle_shop";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// إضافة منتج جديد
if (isset($_POST['add_product'])) {
  $image_url = $_POST['image_url'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  $sql = "INSERT INTO products (image_url, name, description, price) 
          VALUES ('$image_url', '$name', '$description', '$price')";
  $conn->query($sql);
}

// تعديل منتج
if (isset($_POST['edit_product'])) {
  $id = $_POST['id'];
  $image_url = $_POST['image_url'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  $sql = "UPDATE products SET image_url='$image_url', name='$name', description='$description', price='$price' WHERE id='$id'";
  $conn->query($sql);
}

// حذف منتج
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
  $sql = "DELETE FROM products WHERE id='$delete_id'";
  $conn->query($sql);
}

// عرض المنتجات
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Motorcycle Shop</title>
</head>
<body>

  <h2>Admin Panel</h2>

  <!-- نموذج إضافة منتج جديد -->
  <form method="POST">
    <h3>Add New Product</h3>
    <input type="text" name="image_url" placeholder="Image URL" required>
    <input type="text" name="name" placeholder="Product Name" required>
    <textarea name="description" placeholder="Product Description" required></textarea>
    <input type="number" name="price" placeholder="Price" required>
    <button type="submit" name="add_product">Add Product</button>
  </form>

  <hr>

  <h3>Product List</h3>
  <table>
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>Description</th>
      <th>Price</th>
      <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><img src="<?= $row['image_url'] ?>" alt="<?= $row['name'] ?>" width="100"></td>
      <td><?= $row['name'] ?></td>
      <td><?= $row['description'] ?></td>
      <td><?= $row['price'] ?> Baht</td>
      <td>
        <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> | 
        <a href="?delete_id=<?= $row['id'] ?>">Delete</a>
      </td>
    </tr>
    <?php } ?>
  </table>

</body>
</html>

<?php
$conn->close();
?>
