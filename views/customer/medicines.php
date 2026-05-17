<?php

session_start();

$_SESSION['user_id'] = 2;
$_SESSION['role'] = 'customer';

require_once('../../config/db.php');

$sql = "SELECT * FROM medicines";

$result = mysqli_query($con, $sql);

?>

<!DOCTYPE html>

<html>

<head>

<title>Medicines</title>

<style>
body{
    font-family: Arial;
    background:#f5f5f5;
    padding:20px;
}

.card{
    background:white;
    border:1px solid #ddd;
    width:300px;
    padding:15px;
    margin:15px;
    border-radius:6px;
}

button{
    background:#2d89ef;
    color:white;
    border:none;
    padding:8px 14px;
    border-radius:4px;
    cursor:pointer;
}

input{
    padding:5px;
    width:60px;
}

a{
    text-decoration:none;
    color:#2d89ef;
}
</style>

</head>

<body>

<h1>Medicine List</h1>

<h3>
<a href="cart.php">
Cart (
<span id="cartCount">0</span>
)
</a>
</h3>

<?php

while($medicine = mysqli_fetch_assoc($result)){

?>

<div class="card">

<h3>
<?php echo $medicine['name']; ?>
</h3>

<p>
Vendor:
<?php echo $medicine['vendor_name']; ?>
</p>

<p>
Price:
<?php echo $medicine['price']; ?>
</p>

<p>
Available:
<?php echo $medicine['availability']; ?>
</p>

<input
type="number"
id="qty_<?php echo $medicine['id']; ?>"
value="1"
min="1"
>

<br><br>

<button
onclick="addToCart(<?php echo $medicine['id']; ?>)">
Add To Cart
</button>

</div>

<?php
}
?>

<p id="msg"></p>

<script src="../../public/js/cart.js"></script>

</body>

</html>