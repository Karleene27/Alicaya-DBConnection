<?php
include "../db.php";

/* ============================
   SOFT DELETE (Deactivate)
   ============================ */
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Soft delete (set is_active to 0)
    mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
    
    header("Location: services_list.php");
    exit;
}

/* ============================
   FETCH ALL SERVICES
   ============================ */
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>

<!DOCTYPE html>
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
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Hourly Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                    ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['service_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['description'] ?: '—'); ?></td>
                        <td>₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
                        <td>
                            <?php 
                            if ($row['is_active'] == 1) {
                                echo '<span style="background: #e6f7e6; color: #2e7d32; padding: 4px 12px; border-radius: 30px; font-size: 13px; font-weight: 500;">Active</span>';
                            } else {
                                echo '<span style="background: #fee; color: #c62828; padding: 4px 12px; border-radius: 30px; font-size: 13px; font-weight: 500;">Inactive</span>';
                            }
                            ?>
                        </td>
                        <td class="actions">
                            <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn-small">Edit</a>
                            
                            <?php if ($row['is_active'] == 1): ?>
                            <a href="services_list.php?delete_id=<?php echo $row['service_id']; ?>" 
                               class="btn-small" 
                               style="background: #fee; color: #c62828; margin-left: 8px;"
                               onclick="return confirm('Deactivate this service?')">
                                Deactivate
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center">No services found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>