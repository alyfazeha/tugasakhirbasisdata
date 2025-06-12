<?php
// config.php - Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fungsi untuk menjalankan query SELECT
function executeQuery($pdo, $query, $params = []) {
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

// Fungsi untuk mendapatkan semua menu (SELECT Statement)
function getAllMenus($pdo) {
    $query = "SELECT no_menu, name_menu, type_menu, 
              FORMAT(price, 0, 'id_ID') as formatted_price, 
              price 
              FROM menu 
              ORDER BY type_menu, name_menu";
    return executeQuery($pdo, $query);
}

// Fungsi untuk statistik menu terlaris (Fungsi Agregat + JOIN)
function getMenuStatistics($pdo) {
    $query = "SELECT 
                m.name_menu as item,
                COALESCE(SUM(od.quantity), 0) as sold,
                ROUND(AVG(CASE 
                    WHEN m.type_menu = 'appetizer' THEN 4.2
                    WHEN m.type_menu = 'main_course' THEN 4.6
                    WHEN m.type_menu = 'dessert' THEN 4.8
                    ELSE 4.0
                END), 1) as rating
              FROM menu m
              LEFT JOIN order_detail od ON m.no_menu = od.no_menu
              GROUP BY m.no_menu, m.name_menu
              ORDER BY sold DESC, rating DESC";
    return executeQuery($pdo, $query);
}

// Fungsi untuk laporan penjualan harian (JOIN + Agregat + Sorting)
function getDailySalesReport($pdo) {
    $query = "SELECT 
                t.date,
                COUNT(DISTINCT t.no_order) as total_orders,
                SUM(t.total_bayar) as total_revenue,
                FORMAT(SUM(t.total_bayar), 0, 'id_ID') as formatted_revenue,
                GROUP_CONCAT(DISTINCT t.payment_method SEPARATOR ', ') as payment_methods
              FROM transaction t
              INNER JOIN `order` o ON t.no_order = o.no_order
              GROUP BY t.date
              ORDER BY t.date DESC";
    return executeQuery($pdo, $query);
}

// Fungsi untuk detail pesanan customer (Multiple JOIN)
function getCustomerOrderDetails($pdo) {
    $query = "SELECT 
                c.name_customer,
                c.phone,
                o.no_order,
                o.date_order,
                m.name_menu,
                m.type_menu,
                od.quantity,
                m.price,
                (od.quantity * m.price) as subtotal,
                FORMAT((od.quantity * m.price), 0, 'id_ID') as formatted_subtotal
              FROM customer c
              INNER JOIN `order` o ON c.no_customer = o.no_customer
              INNER JOIN order_detail od ON o.no_order = od.no_order
              INNER JOIN menu m ON od.no_menu = m.no_menu
              ORDER BY o.date_order DESC, c.name_customer";
    return executeQuery($pdo, $query);
}

// Fungsi untuk top customers (JOIN + Agregat)
function getTopCustomers($pdo) {
    $query = "SELECT 
                c.name_customer,
                c.phone,
                COUNT(o.no_order) as total_orders,
                SUM(o.total_price) as total_spent,
                FORMAT(SUM(o.total_price), 0, 'id_ID') as formatted_total,
                AVG(o.total_price) as avg_order_value,
                FORMAT(AVG(o.total_price), 0, 'id_ID') as formatted_avg
              FROM customer c
              INNER JOIN `order` o ON c.no_customer = o.no_customer
              GROUP BY c.no_customer, c.name_customer, c.phone
              ORDER BY total_spent DESC, total_orders DESC
              LIMIT 10";
    return executeQuery($pdo, $query);
}

// Fungsi untuk menu berdasarkan kategori (SELECT dengan WHERE)
function getMenuByCategory($pdo, $category = '') {
    if ($category) {
        $query = "SELECT no_menu, name_menu, type_menu, 
                  FORMAT(price, 0, 'id_ID') as formatted_price, price
                  FROM menu 
                  WHERE type_menu = :category
                  ORDER BY price DESC";
        return executeQuery($pdo, $query, ['category' => $category]);
    } else {
        return getAllMenus($pdo);
    }
}
?>