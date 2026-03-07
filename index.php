<?php
session_start();

// If not logged in, redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; 

function get_count($conn, $query, $key) {
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row[$key];
    }
    return 0;
}

$clients  = get_count($conn, "SELECT COUNT(*) AS c FROM clients", 'c');
$services = get_count($conn, "SELECT COUNT(*) AS c FROM services", 'c');
$bookings = get_count($conn, "SELECT COUNT(*) AS c FROM bookings", 'c');
$revenue  = get_count($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments", 's');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Dashboard Overview</h2>
            <div style="color: #64748b;">Welcome, <?php echo $_SESSION['username']; ?>!</div>
        </div>
        
        <div class="cards">
            <div class="card">
                <span class="label">Total Clients</span>
                <span class="value"><?php echo number_format($clients); ?></span>
            </div>
            
            <div class="card">
                <span class="label">Total Services</span>
                <span class="value"><?php echo number_format($services); ?></span>
            </div>
            
            <div class="card">
                <span class="label">Total Bookings</span>
                <span class="value"><?php echo number_format($bookings); ?></span>
            </div>
            
            <div class="card">
                <span class="label">Total Revenue</span>
                <span class="value">₱<?php echo number_format($revenue, 2); ?></span>
            </div>
        </div>
        
        <div class="actions">
            <a href="/assessment_beginner/pages/clients_add.php" class="btn">Add Client</a>
            <a href="/assessment_beginner/pages/bookings_create.php" class="btn">Create Booking</a>
            <a href="/assessment_beginner/pages/services_list.php" class="btn">View Services</a>
        </div>
    </div>
</body>
</html>