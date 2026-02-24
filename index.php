<?php 
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
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>
<?php include 'nav.php'; ?>
    <div class="container">
        <h2>Dashboard Overview</h2>
        
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
        </div>
    </div>
</body>
</html>