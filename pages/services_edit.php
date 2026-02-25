<?php include "../db.php"; 

$id = $_GET['id'];
$service = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id"));

if (isset($_POST['update'])) {
    $name = $_POST['service_name'];
    $desc = $_POST['description'];
    $rate = $_POST['hourly_rate'];
    $active = $_POST['is_active'];
    
    mysqli_query($conn, "UPDATE services SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active' WHERE service_id=$id");
    header("Location: services_list.php");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Service</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
    <h2>Edit Service</h2>
    
    <form method="post" class="form">
        <div class="form-group">
            <label>Service Name</label>
            <input type="text" name="service_name" class="form-control" value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($service['description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Hourly Rate (₱)</label>
            <input type="number" step="0.01" name="hourly_rate" class="form-control" value="<?php echo $service['hourly_rate']; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Status</label>
            <select name="is_active" class="form-control">
                <option value="1" <?php if($service['is_active'] == 1) echo "selected"; ?>>Active</option>
                <option value="0" <?php if($service['is_active'] == 0) echo "selected"; ?>>Inactive</option>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" name="update" class="btn btn-primary">Update Service</button>
            <a href="services_list.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>