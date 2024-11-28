<?php

require_once "src/func/database.php";

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['UID'])) {
    echo json_encode(['success' => false, 'message' => 'User  not logged in.']);
    exit();
}

// Kiểm tra nếu yêu cầu là POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ request
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Lấy thông tin anime từ dữ liệu
    $userId = $_SESSION['UID']; // Lấy ID người dùng từ session
    $animeId = $data['animeId'];
    $animeTitle = $data['animeTitle'];
    $animeImage = $data['animeImage'];

    // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng anime_history
    $stmt = $conn->prepare("INSERT INTO anime_history (UID, anime_id, anime_title, anime_image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $userId, $animeId, $animeTitle, $animeImage);

    // Thực thi câu lệnh và kiểm tra kết quả
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save anime history.']);
    }

    // Đóng statement
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Đóng kết nối
$conn->close();
?>