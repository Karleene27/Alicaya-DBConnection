<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $hourly_rate = $_POST['hourly_rate'];
    $is_active = $_POST['is_active'];

    // simple validation
    if ($service_name == "" || $hourly_rate == "") {
        $message = "Service name and hourly rate are required!";
    } else if (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
        $message = "Hourly rate must be a number greater than 0.";
    } else {
        $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
                VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
        mysqli_query($conn, $sql);

        header("Location: services_list.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Service</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include "../nav.php"; ?>

    <div class="container">
        <h1>Add New Service</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-error"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" class="form">
            <div class="form-group">
                <label>Service Name <span class="required">*</span></label>
                <input type="text" name="service_name" class="form-control" placeholder="Enter service name" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Enter service description"></textarea>
            </div>

            <div class="form-group">
                <label>Hourly Rate (₱) <span class="required">*</span></label>
                <input type="text" name="hourly_rate" class="form-control" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" name="save" class="btn btn-primary">Save Service</button>
                <a href="services_list.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>