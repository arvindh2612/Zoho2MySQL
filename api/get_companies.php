<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "company_db");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}
$result = $conn->query("SELECT * FROM company_details ORDER BY company_id ASC");
$companies = [];
while ($row = $result->fetch_assoc()) {
    $companies[] = $row;
}
echo json_encode($companies);
$conn->close();
?>
