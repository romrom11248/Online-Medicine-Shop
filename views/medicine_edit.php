<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: login.php');
    }

    require_once('../models/AdminModel.php');
    $id = (int)($_GET['id'] ?? 0);
    $medicine = getMedicineById($id);

    if(!$medicine){
        $_SESSION['error'] = "Medicine not found";
        header('location: medicines.php');
    }

    $categories = getAllCategories();
    $pageTitle = "Edit Medicine";
    require_once('header.php');
?>

<h3>Edit Medicine</h3>

<form method="post" action="../controllers/medicineController.php" enctype="multipart/form-data" class="validate-medicine box">
    <fieldset>
        <legend>Medicine Info</legend>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo h($medicine['id']); ?>">

        <table class="form-table">
            <tr>
                <td>Name</td>
                <td>
                    <input type="text" name="name" value="<?php echo h($medicine['name']); ?>">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                    <select name="category_id">
                        <?php foreach($categories as $category){ ?>
                            <option value="<?php echo h($category['id']); ?>" <?php if($category['id'] == $medicine['category_id']){ echo 'selected'; } ?>>
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
                    <input type="text" name="vendor_name" value="<?php echo h($medicine['vendor_name']); ?>">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Price</td>
                <td>
                    <input type="number" name="price" value="<?php echo h($medicine['price']); ?>" min="1" step="0.01">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Availability</td>
                <td>
                    <input type="number" name="availability" value="<?php echo h($medicine['availability']); ?>" min="0">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>New Image</td>
                <td>
                    <input type="file" name="image" accept="image/jpeg,image/png">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea name="description"><?php echo h($medicine['description']); ?></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Update Medicine">
                    <a class="btn" href="medicines.php">Back</a>
                </td>
            </tr>
        </table>
    </fieldset>
</form>

<?php require_once('footer.php'); ?>
