<?php
$conn = new mysqli("localhost", "root", "", "company_db");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['company_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$stmt = $conn->prepare("UPDATE company_details SET added_time=?, ip_address=?, company_name=?, address=?, email=?, website=? WHERE company_id=?");
$stmt->bind_param("ssssssi", 
    $data['added_time'], 
    $data['ip_address'], 
    $data['company_name'], 
    $data['address'], 
    $data['email'], 
    $data['website'], 
    $data['company_id']
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
