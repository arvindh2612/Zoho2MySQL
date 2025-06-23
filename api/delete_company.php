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

$stmt = $conn->prepare("DELETE FROM company_details WHERE company_id=?");
$stmt->bind_param("i", $data['company_id']);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["error" => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
