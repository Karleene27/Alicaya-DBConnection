<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
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
    <title>Add Client</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
    <h2>Add Client</h2>
    
    <?php if ($message): ?>
        <div class="alert alert-error"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <form method="post" class="form">
        <div class="form-group">
            <label>Full Name <span class="required">*</span></label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control">
        </div>
        
        <div class="form-actions">
            <button type="submit" name="save" class="btn btn-primary">Save Client</button>
            <a href="clients_list.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>