<?php
include "../db.php";
 
$id = mysqli_real_escape_string($conn, $_GET['id']);
 
$get = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id");
$client = mysqli_fetch_assoc($get);
 
$message = "";
 
if (isset($_POST['update'])) {
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "UPDATE clients
            SET full_name='$full_name', email='$email', phone='$phone', address='$address'
            WHERE client_id=$id";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Client</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
    <h2>Edit Client</h2>
    
    <?php if ($message): ?>
        <div class="alert alert-error"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <form method="post" class="form">
        <div class="form-group">
            <label>Full Name <span class="required">*</span></label>
            <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($client['full_name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($client['email']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($client['phone']); ?>">
        </div>
        
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($client['address']); ?>">
        </div>
        
        <div class="form-actions">
            <button type="submit" name="update" class="btn btn-primary">Update Client</button>
            <a href="clients_list.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>