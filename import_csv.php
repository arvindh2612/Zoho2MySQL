<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "company_db");
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// Fetch approved companies from DB
$approved_companies = [];
$res = $conn->query("SELECT * FROM company_details");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $approved_companies[] = $row;
    }
}

// Fetch all companies from Google Sheets CSV
$url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQq2YC_-H8eIJIiu-gyjwoo93hX09dvdDKr6xmJe22ckdrHOjh0XJMZi82UxZdWqHP3KMF21tt4J767/pub?output=csv&nocache=' . time();
$file = fopen($url, "r");
$pending_companies = [];

if ($file) {
    fgetcsv($file); // Skip header
    while (($data = fgetcsv($file)) !== FALSE) {
        if (count($data) < 7) continue;

        // Check if company_id already approved
        $already_approved = false;
        foreach ($approved_companies as $ac) {
            if ($ac['company_id'] == $data[2]) {
                $already_approved = true;
                break;
            }
        }

        if (!$already_approved) {
            $pending_companies[] = [
                'added_time' => $data[0],
                'company_id' => $data[2],
                'company_name' => $data[3],
                'address' => $data[4],
                'email' => $data[5],
                'website' => $data[6]
            ];
        }
    }
    fclose($file);
}

// Save pending in session for admin_save.php
$_SESSION['pending_companies'] = $pending_companies;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Import & Approve Companies</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2 class="mb-4">Import Companies & Approve</h2>

  <!-- Pending Companies -->
  <div class="mb-5">
    <h4>Pending Approval</h4>
    <?php if (count($pending_companies)): ?>
    <form method="post" action="admin_save.php">
      <table class="table table-bordered table-sm">
        <thead class="table-light">
          <tr>
            <th>Select</th>
            <th>Added Time</th>
            <th>Company ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Website</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pending_companies as $index => $company): ?>
          <tr>
            <td><input type="checkbox" name="approve[]" value="<?= $index ?>"></td>
            <td><?= htmlspecialchars($company['added_time']) ?></td>
            <td><?= htmlspecialchars($company['company_id']) ?></td>
            <td><?= htmlspecialchars($company['company_name']) ?></td>
            <td><?= htmlspecialchars($company['address']) ?></td>
            <td><?= htmlspecialchars($company['email']) ?></td>
            <td><?= htmlspecialchars($company['website']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <button type="submit" class="btn btn-success">Approve Selected</button>
    </form>
    <?php else: ?>
      <div class="alert alert-info">No new companies awaiting approval.</div>
    <?php endif; ?>
  </div>

  <!-- Approved Companies -->
  <div>
    <h4>Approved Companies</h4>
    <?php if (count($approved_companies)): ?>
    <table class="table table-bordered table-sm">
      <thead class="table-light">
        <tr>
          <th>Added Time</th>
          <th>Company ID</th>
          <th>Name</th>
          <th>Address</th>
          <th>Email</th>
          <th>Website</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($approved_companies as $company): ?>
        <tr>
          <td><?= htmlspecialchars($company['added_time']) ?></td>
          <td><?= htmlspecialchars($company['company_id']) ?></td>
          <td><?= htmlspecialchars($company['company_name']) ?></td>
          <td><?= htmlspecialchars($company['address']) ?></td>
          <td><?= htmlspecialchars($company['email']) ?></td>
          <td><?= htmlspecialchars($company['website']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="alert alert-warning">No approved companies yet.</div>
    <?php endif; ?>
  </div>

  <!-- Button to view full company details -->
  <div class="text-center mt-4">
    <a href="index.html" class="btn btn-primary btn-lg"> MODIFY THE DETAILS</a>
  </div>

</div>
</body>
</html>
