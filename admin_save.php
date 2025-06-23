<?php
session_start();
$conn = new mysqli("localhost", "root", "", "company_db");
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

if (!isset($_POST['approve']) || empty($_SESSION['pending_companies'])) {
    die("<div style='font-family:Arial,sans-serif; text-align:center; margin-top:50px;'>
            <h2 style='color:#d9534f;'>No data or no approval received.</h2>
            <a href='import_csv.php' style='color:#0275d8; text-decoration:none;'>Go Back</a>
         </div>");
}

$approved = $_POST['approve'];
$companies = $_SESSION['pending_companies'];

$sql = "REPLACE INTO company_details (added_time, company_id, company_name, address, email, website) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

foreach ($approved as $index) {
    $c = $companies[$index];
    $stmt->bind_param("sissss", $c['added_time'], $c['company_id'], $c['company_name'], $c['address'], $c['email'], $c['website']);
    $stmt->execute();
}

$stmt->close();
$conn->close();
unset($_SESSION['pending_companies']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Approval Success</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f9fc;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .success-box {
      background: #e6ffe6;
      border: 2px solid #4CAF50;
      padding: 30px;
      text-align: center;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(76,175,80,0.4);
      max-width: 400px;
    }
    .success-box h2 {
      color: #4CAF50;
      margin-bottom: 20px;
    }
    .success-box a {
      text-decoration: none;
      color: white;
      background-color: #4CAF50;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    .success-box a:hover {
      background-color: #45a049;
    }
    .gif {
      margin: 20px 0;
      max-width: 100px;
    }
  </style>
</head>
<body>
  <div class="success-box">
    <h2>✅ Companies Approved Successfully!</h2>
    <img src="https://gifdb.com/images/high/approved-498-x-498-gif-5cqy83ahb678q1sa.gif" alt="Loading GIF" class="gif" />
    <br>
    <a href="import_csv.php">Back to Dashboard</a>
  </div>
</body>
</html>
