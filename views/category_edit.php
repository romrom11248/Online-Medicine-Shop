<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: login.php');
    }

    require_once('../models/AdminModel.php');
    $id = (int)($_GET['id'] ?? 0);
    $category = getCategoryById($id);

    if(!$category){
        $_SESSION['error'] = "Category not found";
        header('location: categories.php');
    }

    $pageTitle = "Edit Category";
    require_once('header.php');
?>

<h3>Edit Category</h3>

<form method="post" action="../controllers/categoryController.php" class="validate-category box">
    <fieldset>
        <legend>Category Info</legend>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo h($category['id']); ?>">

        <table class="form-table">
            <tr>
                <td>Category Name</td>
                <td>
                    <input type="text" name="name" value="<?php echo h($category['name']); ?>">
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td>Category Type</td>
                <td>
                    <select name="category_type">
                        <option value="liquid" <?php if($category['category_type'] == 'liquid'){ echo 'selected'; } ?>>Liquid</option>
                        <option value="solid" <?php if($category['category_type'] == 'solid'){ echo 'selected'; } ?>>Solid</option>
                    </select>
                    <span class="field-error"></span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Update Category">
                    <a class="btn" href="categories.php">Back</a>
                </td>
            </tr>
        </table>
    </fieldset>
</form>

<?php require_once('footer.php'); ?>
