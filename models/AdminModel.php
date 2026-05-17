<?php

    require_once(__DIR__ . '/../config/db.php');

    function getOneValue($sql, $types = "", $values = []){
        $con = getConnection();
        $stmt = mysqli_prepare($con, $sql);

        if($types != ""){
            mysqli_stmt_bind_param($stmt, $types, ...$values);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row ? array_values($row)[0] : 0;
    }

    function getDashboardCounts(){
        return [
            'medicines' => getOneValue("select count(*) as total from medicines"),
            'categories' => getOneValue("select count(*) as total from categories"),
            'customers' => getOneValue("select count(*) as total from users where role = 'customer'"),
            'pending_orders' => getOneValue("select count(*) as total from orders where status = 'pending'")
        ];
    }

    function getAllCategories(){
        $con = getConnection();
        $sql = "select c.*, count(m.id) as medicine_count
                from categories c
                left join medicines m on c.id = m.category_id
                group by c.id
                order by c.category_type, c.name";
        $result = mysqli_query($con, $sql);
        $categories = [];

        while($row = mysqli_fetch_assoc($result)){
            $categories[] = $row;
        }

        return $categories;
    }

    function getCategoryById($id){
        $con = getConnection();
        $sql = "select * from categories where id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    function addCategory($category){
        $con = getConnection();
        $sql = "insert into categories (name, category_type) values (?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $category['name'], $category['category_type']);
        return mysqli_stmt_execute($stmt);
    }

    function updateCategory($category){
        $con = getConnection();
        $sql = "update categories set name = ?, category_type = ? where id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $category['name'], $category['category_type'], $category['id']);
        return mysqli_stmt_execute($stmt);
    }

    function deleteCategory($id){
        if(getOneValue("select count(*) as total from medicines where category_id = ?", "i", [$id]) > 0){
            return "This category has medicines. Delete or move medicines first.";
        }

        $con = getConnection();
        $sql = "delete from categories where id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if(mysqli_stmt_execute($stmt)){
            return true;
        }

        return "Category delete failed";
    }

    function getAllMedicines(){
        $con = getConnection();
        $sql = "select m.*, c.name as category_name, c.category_type
                from medicines m
                inner join categories c on m.category_id = c.id
                order by m.created_at desc, m.id desc";
        $result = mysqli_query($con, $sql);
        $medicines = [];

        while($row = mysqli_fetch_assoc($result)){
            $medicines[] = $row;
        }

        return $medicines;
    }

    function getMedicineById($id){
        $con = getConnection();
        $sql = "select * from medicines where id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    function addMedicine($medicine){
        $con = getConnection();
        $sql = "insert into medicines (name, category_id, vendor_name, price, availability, description, image_path)
                values (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sisdiss",
            $medicine['name'],
            $medicine['category_id'],
            $medicine['vendor_name'],
            $medicine['price'],
            $medicine['availability'],
            $medicine['description'],
            $medicine['image_path']
        );
        return mysqli_stmt_execute($stmt);
    }

    function updateMedicine($medicine){
        $con = getConnection();

        if($medicine['image_path'] != ""){
            $sql = "update medicines
                    set name = ?, category_id = ?, vendor_name = ?, price = ?, availability = ?, description = ?, image_path = ?
                    where id = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                "sisdissi",
                $medicine['name'],
                $medicine['category_id'],
                $medicine['vendor_name'],
                $medicine['price'],
                $medicine['availability'],
                $medicine['description'],
                $medicine['image_path'],
                $medicine['id']
            );
        }else{
            $sql = "update medicines
                    set name = ?, category_id = ?, vendor_name = ?, price = ?, availability = ?, description = ?
                    where id = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                "sisdisi",
                $medicine['name'],
                $medicine['category_id'],
                $medicine['vendor_name'],
                $medicine['price'],
                $medicine['availability'],
                $medicine['description'],
                $medicine['id']
            );
        }

        return mysqli_stmt_execute($stmt);
    }

    function deleteMedicine($id){
        $medicine = getMedicineById($id);

        if(!$medicine){
            return "Medicine not found";
        }

        $pendingSql = "select count(*) as total
                       from order_items oi
                       inner join orders o on oi.order_id = o.id
                       where oi.medicine_id = ? and o.status = 'pending'";

        if(getOneValue($pendingSql, "i", [$id]) > 0){
            return "This medicine is used in a pending order.";
        }

        if(getOneValue("select count(*) as total from order_items where medicine_id = ?", "i", [$id]) > 0){
            return "This medicine has purchase history, so it cannot be deleted.";
        }

        $con = getConnection();
        mysqli_begin_transaction($con);

        try{
            $cartSql = "delete from cart where medicine_id = ?";
            $cartStmt = mysqli_prepare($con, $cartSql);
            mysqli_stmt_bind_param($cartStmt, "i", $id);
            mysqli_stmt_execute($cartStmt);

            $sql = "delete from medicines where id = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            mysqli_commit($con);

            if($medicine['image_path'] != "" && file_exists(__DIR__ . '/../' . $medicine['image_path'])){
                unlink(__DIR__ . '/../' . $medicine['image_path']);
            }

            return true;
        }catch(Exception $e){
            mysqli_rollback($con);
            return "Medicine delete failed";
        }
    }

    function getAllCustomers(){
        $con = getConnection();
        $sql = "select id, name, email, address, phone, created_at
                from users
                where role = 'customer'
                order by created_at desc";
        $result = mysqli_query($con, $sql);
        $customers = [];

        while($row = mysqli_fetch_assoc($result)){
            $customers[] = $row;
        }

        return $customers;
    }

    function deleteCustomer($id){
        $con = getConnection();
        mysqli_begin_transaction($con);

        try{
            $cartSql = "delete from cart where user_id = ?";
            $cartStmt = mysqli_prepare($con, $cartSql);
            mysqli_stmt_bind_param($cartStmt, "i", $id);
            mysqli_stmt_execute($cartStmt);

            $orderSql = "select id from orders where user_id = ?";
            $orderStmt = mysqli_prepare($con, $orderSql);
            mysqli_stmt_bind_param($orderStmt, "i", $id);
            mysqli_stmt_execute($orderStmt);
            $orderResult = mysqli_stmt_get_result($orderStmt);

            while($order = mysqli_fetch_assoc($orderResult)){
                $orderId = $order['id'];

                $paymentSql = "delete from payments where order_id = ?";
                $paymentStmt = mysqli_prepare($con, $paymentSql);
                mysqli_stmt_bind_param($paymentStmt, "i", $orderId);
                mysqli_stmt_execute($paymentStmt);

                $itemSql = "delete from order_items where order_id = ?";
                $itemStmt = mysqli_prepare($con, $itemSql);
                mysqli_stmt_bind_param($itemStmt, "i", $orderId);
                mysqli_stmt_execute($itemStmt);
            }

            $deleteOrderSql = "delete from orders where user_id = ?";
            $deleteOrderStmt = mysqli_prepare($con, $deleteOrderSql);
            mysqli_stmt_bind_param($deleteOrderStmt, "i", $id);
            mysqli_stmt_execute($deleteOrderStmt);

            $userSql = "delete from users where id = ? and role = 'customer'";
            $userStmt = mysqli_prepare($con, $userSql);
            mysqli_stmt_bind_param($userStmt, "i", $id);
            mysqli_stmt_execute($userStmt);

            mysqli_commit($con);
            return true;
        }catch(Exception $e){
            mysqli_rollback($con);
            return false;
        }
    }

    function getAllOrders(){
        $con = getConnection();
        $sql = "select o.*, u.name as customer_name, u.email as customer_email, u.phone
                from orders o
                inner join users u on o.user_id = u.id
                order by o.order_date desc";
        $result = mysqli_query($con, $sql);
        $orders = [];

        while($row = mysqli_fetch_assoc($result)){
            $orders[] = $row;
        }

        return $orders;
    }

    function updateOrderStatus($id, $status){
        $con = getConnection();
        $sql = "update orders set status = ? where id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        return mysqli_stmt_execute($stmt);
    }

    function getPurchaseHistory(){
        $con = getConnection();
        $sql = "select o.id as order_id, o.total_amount, o.shipping_address, o.status, o.payment_method, o.order_date,
                       u.name as customer_name, u.email, u.phone,
                       m.name as medicine_name, oi.quantity, oi.unit_price
                from orders o
                inner join users u on o.user_id = u.id
                inner join order_items oi on o.id = oi.order_id
                inner join medicines m on oi.medicine_id = m.id
                where o.status = 'accepted'
                order by o.order_date desc, o.id desc";
        $result = mysqli_query($con, $sql);
        $history = [];

        while($row = mysqli_fetch_assoc($result)){
            $orderId = $row['order_id'];

            if(!isset($history[$orderId])){
                $history[$orderId] = [
                    'order_id' => $row['order_id'],
                    'customer_name' => $row['customer_name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'total_amount' => $row['total_amount'],
                    'shipping_address' => $row['shipping_address'],
                    'payment_method' => $row['payment_method'],
                    'order_date' => $row['order_date'],
                    'items' => []
                ];
            }

            $history[$orderId]['items'][] = [
                'medicine_name' => $row['medicine_name'],
                'quantity' => $row['quantity'],
                'unit_price' => $row['unit_price']
            ];
        }

        return $history;
    }

?>
