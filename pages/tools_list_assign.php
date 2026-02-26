<?php
include "../db.php";
 
$message = "";
 
// ASSIGN TOOL
if (isset($_POST['assign'])) {
  $booking_id = $_POST['booking_id'];
  $tool_id = $_POST['tool_id'];
  $qty = $_POST['qty_used'];
 
  $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));
 
  if ($qty > $toolRow['quantity_available']) {
    $message = "Not enough available tools!";
  } else {
    mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
      VALUES ($booking_id, $tool_id, $qty)");
 
    mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
 
    $message = "Tool assigned successfully!";
  }
}
 
$tools = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tools</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container">
    <h2>Tools / Inventory</h2>
    
    <?php if($message): ?>
        <div class="alert alert-success" style="background:#e6f7e6; color:#2e7d32; border:1px solid #b7e0b7;"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <h3 style="margin:25px 0 15px;">Available Tools</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Total</th>
                    <th>Available</th>
                </tr>
            </thead>
            <tbody>
                <?php while($t = mysqli_fetch_assoc($tools)) { ?>
                <tr>
                    <td><?php echo $t['tool_name']; ?></td>
                    <td><?php echo $t['quantity_total']; ?></td>
                    <td><?php echo $t['quantity_available']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <hr style="margin:30px 0; border:1px solid #e9eef2;">
    
    <h3 style="margin:0 0 20px;">Assign Tool to Booking</h3>
    <form method="post" class="form">
        <div class="form-group">
            <label>Booking ID</label>
            <select name="booking_id" class="form-control">
                <?php while($b = mysqli_fetch_assoc($bookings)) { ?>
                    <option value="<?php echo $b['booking_id']; ?>">#<?php echo $b['booking_id']; ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Tool</label>
            <select name="tool_id" class="form-control">
                <?php
                    $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
                    while($t2 = mysqli_fetch_assoc($tools2)) {
                ?>
                    <option value="<?php echo $t2['tool_id']; ?>">
                        <?php echo $t2['tool_name']; ?> (Avail: <?php echo $t2['quantity_available']; ?>)
                    </option>
                <?php } ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Qty Used</label>
            <input type="number" name="qty_used" min="1" value="1" class="form-control">
        </div>
        
        <div class="form-actions">
            <button type="submit" name="assign" class="btn btn-primary">Assign Tool</button>
        </div>
    </form>
</div>
</body>
</html>