<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: login.php');
    }

    require_once('../models/AdminModel.php');
    $pageTitle = "Medicine Management";
    $categories = getAllCategories();
    $medicines = getAllMedicines();
    require_once('header.php');
?>

<h3>Medicine Management</h3>

<form method="post" action="../controllers/medicineController.php" enctype="multipart/form-data" class="validate-medicine box" data-image-required="1">
    <fieldset>
        <legend>Add Medicine</legend>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="action" value="add">

        <table class="form-table">
            <tr>
                <td>Name</td>
                <td>
                    <input type="text" name="name" value="">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                    <select name="category_id">
                        <option value="">Select category</option>
                        <?php foreach($categories as $category){ ?>
                            <option value="<?php echo h($category['id']); ?>">
                                <?php echo h($category['name']); ?> (<?php echo h($category['category_type']); ?>)
                            </option>
                        <?php } ?>
                    </select>
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Vendor Name</td>
                <td>
                    <input type="text" name="vendor_name" value="">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Price</td>
                <td>
                    <input type="number" name="price" value="" min="1" step="0.01">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Availability</td>
                <td>
                    <input type="number" name="availability" value="" min="0">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Image</td>
                <td>
                    <input type="file" name="image" accept="image/jpeg,image/png" required>
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea name="description"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Add Medicine"></td>
            </tr>
        </table>
    </fieldset>
</form>

<table class="data-table">
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Vendor</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Action</th>
    </tr>
    <?php foreach($medicines as $medicine){ ?>
        <tr>
            <td>
                <?php if($medicine['image_path'] != "" && file_exists('../' . $medicine['image_path'])){ ?>
                    <img class="thumb" src="../<?php echo h($medicine['image_path']); ?>" alt="<?php echo h($medicine['name']); ?>">
                <?php }else{ ?>
                    No Image
                <?php } ?>
            </td>
            <td><?php echo h($medicine['name']); ?></td>
            <td><?php echo h($medicine['category_name']); ?> (<?php echo h($medicine['category_type']); ?>)</td>
            <td><?php echo h($medicine['vendor_name']); ?></td>
            <td><?php echo number_format((float)$medicine['price'], 2); ?></td>
            <td><?php echo h($medicine['availability']); ?></td>
            <td>
                <a href="medicine_edit.php?id=<?php echo h($medicine['id']); ?>">Edit</a>
                <form method="post" action="../controllers/medicineController.php" class="inline-form delete-form">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo h($medicine['id']); ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<?php require_once('footer.php'); ?>