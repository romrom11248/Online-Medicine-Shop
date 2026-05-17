<?php
require_once '../controllers/authHelper.php';
require_once '../models/medicineModel.php';

// Check auth
checkAuth();

$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - OMS</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <div class="brand">OMS</div>
            <div class="nav-links">
            <a href="customer/medicines.php">Browse Medicines</a>
            <a href="customer/cart.php">See Cart</a>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> (<?php echo htmlspecialchars($_SESSION['role']); ?>)</span>
                <a href="view.php">Profile</a>
                <a href="../controllers/logout.php" class="btn-outline" style="padding: 0.25rem 0.75rem;">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container home-layout">
        <aside class="sidebar">
            <h3>Categories</h3>
            <ul class="category-list" id="categoryList">
                <li><a href="#" class="active" data-id="">All Medicines</a></li>
                <?php foreach($categories as $cat): ?>
                    <li>
                        <a href="#" data-name="<?php echo htmlspecialchars($cat['name']); ?>">
                            <?php echo htmlspecialchars($cat['name']); ?> 
                            <?php if(!empty($cat['category_type'])) echo '('.htmlspecialchars($cat['category_type']).')'; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <main>
            <div class="search-bar">
                <input type="text" id="searchQuery" placeholder="Search medicines by name...">
                <input type="text" id="searchVendor" placeholder="Filter by vendor...">
                <button class="btn btn-primary" id="searchBtn" style="width: auto;">Search</button>
            </div>

            <div class="medicines-grid" id="medicinesContainer">
                <!-- Medicines will be populated here via AJAX -->
                <div class="text-center" style="grid-column: 1 / -1; padding: 2rem; color: var(--text-light);">
                    Loading medicines...
                </div>
            </div>
        </main>
    </div>

    <script src="../public/js/home.js"></script>
</body>
</html>