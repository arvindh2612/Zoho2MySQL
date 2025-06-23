<?php
$conn = new mysqli("localhost", "root", "", "company_db");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}

// Get POST data as JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

// Prepare insert query
$stmt = $conn->prepare("INSERT INTO company_details (added_time, ip_address, company_id, company_name, address, email, website) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssissss", 
    $data['added_time'], 
    $data['ip_address'], 
    $data['company_id'], 
    $data['company_name'], 
    $data['address'], 
    $data['email'], 
    $data['website']
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["error" => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
