<?php include "../db.php"; ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Services</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
    <div class="table-header">
        <h2>Services</h2>
        <a href="services_add.php" class="btn btn-primary">+ Add Service</a>
    </div>
    
    <?php
    $result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
    ?>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Hourly Rate</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while($row = mysqli_fetch_assoc($result)) { 
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['service_name']); ?></strong></td>
                    <td>₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
                    <td>
                        <?php 
                        $status_style = $row['is_active'] ? "background:#e6f7e6; color:#2e7d32;" : "background:#fee; color:#c62828;";
                        $status_text = $row['is_active'] ? "Active" : "Inactive";
                        ?>
                        <span style="<?php echo $status_style; ?> padding:4px 12px; border-radius:30px; font-size:13px; font-weight:500;"><?php echo $status_text; ?></span>
                    </td>
                    <td class="actions">
                        <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn-small">Edit</a>
                    </td>
                </tr>
                <?php 
                } 
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>