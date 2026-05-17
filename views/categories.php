<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: login.php');
    }

    require_once('../models/AdminModel.php');
    $pageTitle = "Category Management";
    $categories = getAllCategories();
    require_once('header.php');
?>

<h3>Category Management</h3>

<form method="post" action="../controllers/categoryController.php" class="validate-category box">
    <fieldset>
        <legend>Add Category</legend>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="action" value="add">

        <table class="form-table">
            <tr>
                <td>Category Name</td>
                <td>
                    <input type="text" name="name" value="">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Category Type</td>
                <td>
                    <select name="category_type">
                        <option value="">Select type</option>
                        <option value="liquid">Liquid</option>
                        <option value="solid">Solid</option>
                    </select>
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Add Category"></td>
            </tr>
        </table>
    </fieldset>
</form>

<table class="data-table">
    <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Medicines</th>
        <th>Action</th>
    </tr>
    <?php foreach($categories as $category){ ?>
        <tr>
            <td><?php echo h($category['name']); ?></td>
            <td><?php echo h($category['category_type']); ?></td>
            <td><?php echo h($category['medicine_count']); ?></td>
            <td>
                <a href="category_edit.php?id=<?php echo h($category['id']); ?>">Edit</a>
                <form method="post" action="../controllers/categoryController.php" class="inline-form delete-form">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo h($category['id']); ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<?php require_once('footer.php'); ?>
